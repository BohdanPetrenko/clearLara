<?php

namespace App\Services;

use GuzzleHttp\Client;

class JiraFilterWatcher
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://' . env('JIRA_PROJECT_NAME') . '.atlassian.net/rest/api/3/']);
    }

    public function run(int $filterId)
    {
        $response = $this->getRequest('filter/' . $filterId);
        $getQueryFromFilter = parse_url((\GuzzleHttp\json_decode($response->getBody()->getContents(), true))['searchUrl'])['query'];

        $response = $this->getRequest('search?' . $getQueryFromFilter);
        $getFilterInfo = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $getFilterInfo['total'];
    }

    public function getRequest($uri, $method = 'GET')
    {
        return $this->client->request(
            $method,
            $uri, [
            'headers' => [
                'Authorization' => "Basic " . base64_encode(env('JIRA_USER_EMAIL') . ':' . env('JIRA_API_TOKEN'))
            ]]);
    }
}
