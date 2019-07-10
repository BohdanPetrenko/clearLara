<?php

namespace App\Services;

class JiraProvider
{

    public function listIssuesByFilter(string $filter)
    {
        $filterList = $this->listFilters();

        return $filterList[$filter] ?? abort(404);
    }

    public function listFilters()
    {
        $response = (new  JiraFilterWatcher)->getRequest('filter/search');

        $filters = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $filters['values'];
    }
}
