<?php

namespace App\Services;

use App\JiraFilter;
use GuzzleHttp\Client;

class SlackNotifier
{
    private $jiraProvider;

    public function __construct(JiraProvider $jiraProvider)
    {
        $this->jiraProvider = $jiraProvider;
    }

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
        $encodedFilterInfo = $this->jiraProvider->getFilterById($jiraFilter->filter_id)->getBody()->getContents();
        $decodedFilterInfo = (\GuzzleHttp\json_decode($encodedFilterInfo));

        return $decodedFilterInfo->name;
    }

    private function getTotalTasks(JiraFilter $jiraFilter)
    {
        return $this->jiraProvider->getTotalTasksByFilter($jiraFilter->filter_id);

    }
}
