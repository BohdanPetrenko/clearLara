<?php

namespace App\Services;

use GuzzleHttp\Client;

class JiraProvider
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://' . env('JIRA_PROJECT_NAME') . '.atlassian.net/rest/api/3/']);
    }

    /** get all Jira filters
     * @return mixed
     */
    public function searchForFilters()
    {
        $request = $this->client->request(
            'GET',
            'filter/search', [
            'headers' => [
                'Authorization' => "Basic " . base64_encode(env('JIRA_USER_EMAIL') . ':' . env('JIRA_API_TOKEN'))
            ]]);

        $filters = \GuzzleHttp\json_decode($request->getBody()->getContents(), true);

        return $filters['values'];
    }

//    public function getFilterAttribute(int $id, string $attribute)
//    {
//        return $this->getFilter($id)[$attribute] ?? abort(404);
//    }

    /**
     * return all info about chosen ilter
     * @param int $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getFilterById(int $id)
    {
        $request = $this->client->request(
            'GET',
            'filter/' . $id, [
            'headers' => [
                'Authorization' => "Basic " . base64_encode(env('JIRA_USER_EMAIL') . ':' . env('JIRA_API_TOKEN'))
            ]]);
        return $request ?? abort(404);
    }

    private function searchByJql(string $query)
    {
        $request = $this->client->request(
            'GET',
            'search?' . $query, [
            'headers' => [
                'Authorization' => "Basic " . base64_encode(env('JIRA_USER_EMAIL') . ':' . env('JIRA_API_TOKEN'))
            ]]);
        return $request ?? abort(404);
    }

    public function getTotalTasksByFilter(int $filterId)
    {
        $request = $this->getFilterById($filterId);

        $getQueryFromFilter = parse_url((\GuzzleHttp\json_decode($request->getBody()
            ->getContents(), true))['searchUrl'])['query'];

        $request = $this->searchByJql($getQueryFromFilter);
        $getFilterInfo = \GuzzleHttp\json_decode($request->getBody()->getContents(), true);

        return $getFilterInfo['total'];
    }
}

