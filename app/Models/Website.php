<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Website extends Model
{
    protected $fillable = [
        'server_id',
        'name',
        'url',
        'type',
        'document_root',
        'check_interval',
        'status',
        'http_status',
        'response_time',
        'ssl_expiry_date',
        'last_checked_at',
    ];

    protected $casts = [
        'ssl_expiry_date' => 'date',
        'last_checked_at' => 'datetime',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(WebsiteCheck::class)->orderBy('checked_at', 'desc');
    }

    public function latestCheck()
    {
        return $this->hasOne(WebsiteCheck::class)->latestOfMany('checked_at');
    }

    public function alerts(): MorphMany
    {
        return $this->morphMany(Alert::class, 'alertable');
    }

    public function isUp(): bool
    {
        return $this->status === 'up';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'up' => 'green',
            'down' => 'red',
            'slow' => 'yellow',
            default => 'gray',
        };
    }
}
