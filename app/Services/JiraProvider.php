<?php

namespace App\Services;

class JiraProvider
{

//    public function listIssuesByFilter(string $filter)
//    {
//        $filterList = $this->listFilters();
//
//        return $filterList[$filter] ?? abort(404);
//    }

    /** get all Jira filters
     * @return mixed
     */
    public function searchForFilters()
    {
        $response = (new  JiraFilterWatcher)->getRequest('filter/search');

        $filters = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $filters['values'];
    }

    /**
     * return all info about chosen ilter
     * @param int $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getFilter(int $id)
    {
        return (new JiraFilterWatcher)->getRequest('filter/' . $id) ?? abort(404);
    }

    public function getFilterAttribute(int $id, string $attribute)
    {
        return $this->getFilter($id)[$attribute] ?? abort(404);
    }

    public function getTotalTasksByFilter(int $id)
    {
        return (new JiraFilterWatcher)->run($id)['total'];
    }
}

