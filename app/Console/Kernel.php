<?php

namespace App\Console;

use App\JiraFilter;
use App\Repositories\JiraFilterRepository;
use App\Services\JiraRunner;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * @param Schedule $schedule
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function schedule(Schedule $schedule)
    {
        $repository = app(JiraFilterRepository::class);
        $runner = app(JiraRunner::class);
        /**
         * @var JiraFilter $jiraFilter
         */
        foreach ($repository->getAll() as $jiraFilter) {
            $schedule->call(function () use ($jiraFilter, $runner) {
                $runner->send($jiraFilter);
            })->cron($jiraFilter->schedule);
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
