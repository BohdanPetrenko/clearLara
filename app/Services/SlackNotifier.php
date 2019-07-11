<?php

namespace App\Services;

use App\JiraFilter;
use GuzzleHttp\Client;


class SlackNotifier
{
    public function send(JiraFilter $jiraFilter)
    {
        $client = new Client();

        $message = 'Количество задач по фильтру `' .
            $this->getName($jiraFilter) . '` достигло `' .
            $this->getTotalTasks($jiraFilter) . '` и превышает норму.';
        $payload = json_encode(
            [
                'text' => $message,
                'username' => 'JiraWatcher Bot',
                'icon_emoji' => ':exclamation:'
            ]);

        $client->request('POST', $jiraFilter->slack_webhook, [
            'body' => $payload
        ]);
    }

    private function getName(JiraFilter $jiraFilter)
    {
        $jiraProvider = new JiraProvider();
        $encodedFilterInfo = $jiraProvider->getFilterById($jiraFilter->filter_id)->getBody()->getContents();
        $decodeFilterInfo = (\GuzzleHttp\json_decode($encodedFilterInfo));
        $filterName = $decodeFilterInfo->name;

        return $filterName;
    }

    private function getTotalTasks(JiraFilter $jiraFilter)
    {
        $filter = new JiraProvider();
        $totalTask = $filter->getTotalTasksByFilter($jiraFilter->filter_id);

        return $totalTask;
    }
}
