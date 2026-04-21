<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Server;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with(['server', 'checks' => function ($query) {
            $query->latest('checked_at')->limit(1);
        }])
            ->orderBy('status')
            ->orderBy('name')
            ->paginate(15);

        $stats = [
            'total' => Website::count(),
            'up' => Website::where('status', 'up')->count(),
            'down' => Website::where('status', 'down')->count(),
            'slow' => Website::where('status', 'slow')->count(),
        ];

        return view('websites.index', compact('websites', 'stats'));
    }

    public function create()
    {
        $servers = Server::where('status', 'online')
            ->orderBy('name')
            ->get();

        return view('websites.create', compact('servers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'server_id' => 'nullable|exists:servers,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255|unique:websites,url',
            'type' => 'required|in:laravel,wordpress,static,php,other',
            'document_root' => 'nullable|string|max:255',
            'check_interval' => 'required|integer|min:30|max:3600',
        ]);

        $website = Website::create($validated);

        return redirect()
            ->route('websites.show', $website)
            ->with('success', 'Website berhasil ditambahkan dan akan mulai dimonitor!');
    }

    public function show(Website $website)
    {
        $website->load([
            'server',
            'checks' => function ($query) {
                $query->latest('checked_at')->take(20);
            },
            'alerts' => function ($query) {
                $query->where('is_resolved', false)->latest()->take(5);
            }
        ]);

        // Calculate uptime percentage (last 24 hours)
        $uptimePercentage = 100; // Default
        $recentChecks = $website->checks()
            ->where('checked_at', '>=', now()->subDay())
            ->get();
        
        if ($recentChecks->count() > 0) {
            $upCount = $recentChecks->where('status', 'up')->count();
            $uptimePercentage = round(($upCount / $recentChecks->count()) * 100, 2);
        }

        return view('websites.show', compact('website', 'uptimePercentage'));
    }

    public function edit(Website $website)
    {
        $servers = Server::where('status', 'online')
            ->orderBy('name')
            ->get();

        return view('websites.edit', compact('website', 'servers'));
    }

    public function update(Request $request, Website $website)
    {
        $validated = $request->validate([
            'server_id' => 'nullable|exists:servers,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255|unique:websites,url,' . $website->id,
            'type' => 'required|in:laravel,wordpress,static,php,other',
            'document_root' => 'nullable|string|max:255',
            'check_interval' => 'required|integer|min:30|max:3600',
        ]);

        $website->update($validated);

        return redirect()
            ->route('websites.show', $website)
            ->with('success', 'Website berhasil diupdate!');
    }

    public function destroy(Website $website)
    {
        $name = $website->name;
        $website->delete();

        return redirect()
            ->route('websites.index')
            ->with('success', "Website '{$name}' berhasil dihapus!");
    }

    public function checkNow(Website $website)
    {
        // TODO: Trigger immediate health check
        // This will be implemented when we add the monitoring job

        return back()->with('success', 'Health check dimulai untuk ' . $website->name);
    }
}
