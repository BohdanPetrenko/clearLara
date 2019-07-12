<?php

namespace App\Services;

class JiraRunner
{
    private $watcher;
    private $notifier;

    public function __construct(
        JiraFilterWatcher $jiraFilterWatcher,
        SlackNotifier $slackNotifier
    )

    {
        $this->watcher = $jiraFilterWatcher;
        $this->notifier = $slackNotifier;
    }

    public function send($jiraFilter)
    {
        if ($this->watcher->shouldNotifySlack($jiraFilter)) {
            $this->notifier->send($jiraFilter);
        }
    }
}
