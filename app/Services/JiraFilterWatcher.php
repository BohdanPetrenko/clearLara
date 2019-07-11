<?php

namespace App\Services;

use App\JiraFilter;

class JiraFilterWatcher
{
    public function shouldNotifySlack(JiraFilter $db)
    {
        $filterId = $db->getAttributes()['filter_id'];
        $maxTotalTasks = $db->getAttributes()['max_total_tasks'];

        $totalTasksInJiraByFilterId =
            (new JiraProvider)->getTotalTasksByFilter($filterId);

        return $totalTasksInJiraByFilterId >= $maxTotalTasks ? true : false;
    }
}
