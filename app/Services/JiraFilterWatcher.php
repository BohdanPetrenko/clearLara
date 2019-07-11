<?php

namespace App\Services;

use App\JiraFilter;

class JiraFilterWatcher
{
    public function shouldNotifySlack(JiraFilter $jiraFilter)
    {
        $filterId = $jiraFilter->filter_id;
        $maxTotalTasks = $jiraFilter->max_total_tasks;

        $totalTasksInJiraByFilterId =
            (new JiraProvider)->totalTasks($filterId);

        return $totalTasksInJiraByFilterId >= $maxTotalTasks ? true : false;
    }
}
