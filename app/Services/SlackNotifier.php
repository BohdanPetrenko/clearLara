<?php

namespace App\Services;

use App\JiraFilter;
use GuzzleHttp\Client;

class SlackNotifier
{
    public function send(JiraFilter $jiraFilter)
    {
        $client = new Client ([
            'base_uri' => 'https://hooks.slack.com'
        ]);

        $filterInfo = $this->getNameAndTotalTasks($jiraFilter);
        $message = "Количество задач по фильтру `$filterInfo[name]` достигло `$filterInfo[totalTasks]` и превышает норму.";
        $payload = json_encode(
            [
                'text' => $message,
                'username' => 'JiraNotification',
                'icon_emoji' => ':exclamation:'
            ]);

        $workspaceUri = (parse_url($jiraFilter->slack_webhook))['path'];
        $client->request(
            'POST',
            $workspaceUri, [
            'body' => $payload
        ]);
    }
    private function getNameAndTotalTasks(JiraFilter $jiraFilter)
    {
        $filter = new JiraProvider();
        $encodedFilterName = $filter->getFilterById($jiraFilter->filter_id)->getBody()->getContents();
        $decodeFilterName = (\GuzzleHttp\json_decode($encodedFilterName));
        $filterName = $decodeFilterName->name;
        $totalTask = $filter->getTotalTasksByFilter($jiraFilter->filter_id);

        return ['name' => $filterName, 'totalTasks' => $totalTask];
    }
}
