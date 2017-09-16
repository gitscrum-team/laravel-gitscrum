<?php

namespace GitScrum\Services;

use GitScrum\Contracts\SlackInterface;
use Log;
use Maknz\Slack\Client;


class SlackService implements SlackInterface
{
    const ISSUE_ASSIGNATION = 1;
    const STATUS_UPDATE = 2;

    private $client;
    private $settings;

    public function __construct()
    {
        $this->settings = [
            'channel' => env('SLACK_CHANNEL', ''),
            'username' => env('SLACK_BOT_NAME', ''),
            'icon' => ':page_facing_up:',
            'unfurl_links' => true,
            'link_names' => 1,
            'allow_markdown' => 1,
        ];
        $this->client = new Client(env('SLACK_WEBHOOK', ''), $this->settings);
    }

    /**
     * Send an Slack notification
     * @param  array  $content  This array can contains custom attributes to send different notifications
     * @param  integer $type    Type of notification
     * 
     * @return void
     */
    public function send($content, $type = 0)
    {
        if (empty($this->client->getEndpoint()) || empty($this->client->getDefaultChannel()) 
            || empty($this->client->getDefaultUsername())) {
            Log::info('One or more settings are missing, Slack notifications are not availables');

            return;
        }

        $message = $this->buildMessage($content, $type);
        $this->client->attach([
            'title' => $content['title'],
            'title_link' => $content['url'],
            'color' => 'good',
        ])->enableMarkdown()->send($message);
    }

    /**
     * Build the final output of message
     * @param  array  $content  This array can contains custom attributes to send different notifications
     * @param  integer $type    Type of notification
     * 
     * @return string   Message ready to send
     */
    private function buildMessage($content, $type)
    {
        $message = '';

        switch ($type) {
            case 1:
                $usersAssigned = [];
                
                foreach ($content['assigned_to'] as $username) {
                    if (! empty($username)) {
                        $usersAssigned[] = "@{$username}";
                    }
                }

                $usersAssigned = implode(' ', $usersAssigned);
                $params = [
                    'assignedBy' => $content['assigned_by'],
                    'assignedTo' => $usersAssigned,
                ];
                $message = trans('gitscrum.issue-assigned', $params);
                break;
            case 2:
                switch ($content['status']) {
                    case 1:
                        $status = 'Todo';
                        break;
                    case 2:
                        $status = 'In Progress';
                        break;
                    case 3:
                        $status = 'Done';
                        break;
                    case 4:
                        $status = 'Archived';
                        break;
                    default:
                        $status = 'Todo';
                        break;
                }

                $params = [
                    'username' => $content['updated_by'],
                    'status' => $status,
                ];
                $message = trans('gitscrum.issue-status-updated', $params);
                break;
            default:
                # code...
                break;
        }

        return $message;
    }
}
