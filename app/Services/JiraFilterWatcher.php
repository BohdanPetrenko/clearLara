<?php

namespace App\Services;

use App\JiraFilter;

class JiraFilterWatcher
{
    public function shouldNotifySlack(JiraFilter $jiraFilter)
    {
        $filterId = $jiraFilter->filter_id;
        $maxTotalTasks = $jiraFilter->max_total_tasks;

        $totalTasks =
            (new JiraProvider)->getTotalTasksByFilter($filterId);

        return $totalTasks >= $maxTotalTasks ? true : false;
    }
}
