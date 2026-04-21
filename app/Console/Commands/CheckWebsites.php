<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsiteHealth;
use App\Models\Website;
use Illuminate\Console\Command;

class CheckWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websites:check {--id= : Check specific website by ID} {--sync : Run synchronously without queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check health of all websites or a specific website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websiteId = $this->option('id');
        $sync = $this->option('sync');

        if ($websiteId) {
            // Check specific website
            $website = Website::find($websiteId);
            
            if (!$website) {
                $this->error("Website with ID {$websiteId} not found!");
                return 1;
            }

            $this->info("Checking website: {$website->name} ({$website->url})");
            
            if ($sync) {
                (new CheckWebsiteHealth($website))->handle();
                $this->info("✓ Check completed");
            } else {
                CheckWebsiteHealth::dispatch($website);
                $this->info("✓ Check job dispatched to queue");
            }

            // Show result
            $website->refresh();
            $this->newLine();
            $this->line("Status: " . strtoupper($website->status));
            $this->line("HTTP Status: " . ($website->http_status ?? 'N/A'));
            $this->line("Response Time: " . ($website->response_time ?? 'N/A') . " ms");
            $this->line("Last Checked: " . $website->last_checked_at?->diffForHumans());

        } else {
            // Check all websites
            $websites = Website::all();
            
            if ($websites->isEmpty()) {
                $this->warn("No websites found in database!");
                return 0;
            }

            $this->info("Checking {$websites->count()} websites...");
            $this->newLine();

            $progressBar = $this->output->createProgressBar($websites->count());
            $progressBar->start();

            foreach ($websites as $website) {
                if ($sync) {
                    (new CheckWebsiteHealth($website))->handle();
                } else {
                    CheckWebsiteHealth::dispatch($website);
                }
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);

            if ($sync) {
                $this->info("✓ All website checks completed");
            } else {
                $this->info("✓ All check jobs dispatched to queue");
            }

            // Show summary
            $this->newLine();
            $this->table(
                ['Status', 'Count'],
                [
                    ['Up', Website::where('status', 'up')->count()],
                    ['Slow', Website::where('status', 'slow')->count()],
                    ['Down', Website::where('status', 'down')->count()],
                    ['Unknown', Website::where('status', 'unknown')->count()],
                ]
            );
        }

        return 0;
    }
}
