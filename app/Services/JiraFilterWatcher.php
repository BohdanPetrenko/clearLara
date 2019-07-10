<?php

namespace App\Services;

class JiraFilterWatcher
{
    public function run(int $filterId)
    {
        return (new JiraProvider())->getTotalTasksByFilter($filterId);
    }
}
