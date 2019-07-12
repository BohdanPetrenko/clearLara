<?php

namespace App\Repositories;

use App\JiraFilter;

class JiraFilterRepository
{
    private $allTasks;

    public function __construct(JiraFilter $jiraFilter)
    {
        $this->allTasks = $jiraFilter;
    }

    public function getAll()
    {
        return $this->allTasks->all();
    }
}