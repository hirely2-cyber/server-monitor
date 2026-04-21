<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Server extends Model
{
    protected $fillable = [
        'name',
        'hostname',
        'ip_address',
        'location',
        'provider',
        'os',
        'status',
        'last_seen_at',
        'api_token',
        // SSH Access
        'ssh_username',
        'ssh_password',
        'ssh_port',
        'ssh_private_key',
        // Panel Access
        'panel_type',
        'panel_url',
        'panel_username',
        'panel_password',
        'panel_port',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'ssh_port' => 'integer',
        'panel_port' => 'integer',
    ];

    protected $hidden = [
        'ssh_password',
        'ssh_private_key',
        'panel_password',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($server) {
            if (empty($server->api_token)) {
                $server->api_token = Str::random(64);
            }
        });
    }

    public function websites(): HasMany
    {
        return $this->hasMany(Website::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(ServerMetric::class)->orderBy('recorded_at', 'desc');
    }

    public function latestMetric()
    {
        return $this->hasOne(ServerMetric::class)->latestOfMany('recorded_at');
    }

    public function alerts(): MorphMany
    {
        return $this->morphMany(Alert::class, 'alertable');
    }

    public function isOnline(): bool
    {
        // Check if server has sent data in the last 5 minutes
        if ($this->last_seen_at) {
            return $this->last_seen_at->diffInMinutes(now()) < 5;
        }
        return false;
    }

    // Dynamic status based on last_seen_at
    public function getStatusAttribute($value)
    {
        // If last_seen_at is within 5 minutes, consider online
        if ($this->attributes['last_seen_at'] ?? null) {
            $lastSeen = \Carbon\Carbon::parse($this->attributes['last_seen_at']);
            if ($lastSeen->diffInMinutes(now()) < 5) {
                return 'online';
            }
        }
        // Otherwise, check database value or default to offline
        return $value ?: 'offline';
    }

    public function getUptimePercentageAttribute(): float
    {
        return $this->isOnline() ? 99.9 : 0;
    }

    // SSH Password Encryption
    public function setSshPasswordAttribute($value)
    {
        $this->attributes['ssh_password'] = $value ? encrypt($value) : null;
    }

    public function getSshPasswordAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // SSH Private Key Encryption
    public function setSshPrivateKeyAttribute($value)
    {
        $this->attributes['ssh_private_key'] = $value ? encrypt($value) : null;
    }

    public function getSshPrivateKeyAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // Panel Password Encryption
    public function setPanelPasswordAttribute($value)
    {
        $this->attributes['panel_password'] = $value ? encrypt($value) : null;
    }

    public function getPanelPasswordAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // Helper Methods
    public function getSshCommand(): string
    {
        if (!$this->ssh_username) {
            return '';
        }

        $user = $this->ssh_username;
        $host = $this->ip_address ?: $this->hostname;
        $port = $this->ssh_port ?: 22;

        return $port !== 22 
            ? "ssh {$user}@{$host} -p {$port}"
            : "ssh {$user}@{$host}";
    }

    public function getPanelUrlAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        // Ensure URL has protocol
        if (!preg_match("~^(?:f|ht)tps?://~i", $value)) {
            return "https://{$value}";
        }

        return $value;
    }
}
