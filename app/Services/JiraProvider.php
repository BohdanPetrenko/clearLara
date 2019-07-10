<?php

namespace App\Services;

use GuzzleHttp\Client;

class JiraProvider
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://' . env('JIRA_PROJECT_NAME') . '.atlassian.net/rest/api/3/',
            'headers' => [
                'Authorization' => "Basic " . base64_encode(env('JIRA_USER_EMAIL') . ':' . env('JIRA_API_TOKEN'))
            ]
        ]);
    }

    /** get all Jira filters
     * @return mixed
     */
    public function searchForFilters()
    {
        $request = $this->client->request(
            'GET',
            'filter/search'
        );

        $filters = \GuzzleHttp\json_decode($request->getBody()->getContents(), true);

        return $filters['values'];
    }

//    public function getFilterAttribute(int $id, string $attribute)
//    {
//        return $this->getFilter($id)[$attribute] ?? abort(404);
//    }

    public function getTotalTasksByFilter(int $filterId)
    {
        $response = $this->getFilterById($filterId);

        $getQueryFromFilter = parse_url((\GuzzleHttp\json_decode($response->getBody()
            ->getContents(), true))['searchUrl'])['query'];

        $response = $this->searchByJql($getQueryFromFilter);
        $getFilterInfo = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $getFilterInfo['total'];
    }

    /**
     * return all info about chosen ilter
     * @param int $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getFilterById(int $id)
    {
        $response = $this->client->request(
            'GET',
            'filter/' . $id
        );
        return $response;
    }

    private function searchByJql(string $query)
    {
        $response = $this->client->request(
            'GET',
            'search?' . $query
        );
        return $response;
    }
}

