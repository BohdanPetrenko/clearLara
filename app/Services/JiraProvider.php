<?php

namespace App\Services;

use GuzzleHttp\Client;

class JiraProvider
{

    public function listFilters()
    {

        $client = new Client(['base_uri'
        => 'https://' . getenv('JIRA_PROJECT_NAME') . '.atlassian.net/rest/api/3/']);
        $response = $client->request(
            'GET',
            'filter/search', [
            'headers' => [
                'Authorization' => "Basic " . base64_encode(getenv('USER_JIRA_EMAIL') . ':' . getenv('JIRA_API_TOKEN'))
            ]]);

        $filters = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $filters['values'];
    }

    public function listIssuesByFilter(string $filter)
    {
        $filterList = $this->listFilters();

        return $filterList[$filter] ?? abort(404);
    }
}
