<?php
/**
 * Created by PhpStorm.
 * User: voksiv
 * Date: 10.07.17
 * Time: 17:08
 */

namespace LTDBeget\jiraIntegration;


use Jira_Api;
use Jira_Api_Authentication_Basic;

class WorkLogger
{
    /**
     * @var Jira_Api
     */
    private $api;

    public function __construct(string $endpoint, string $jiraUserName, string $jiraUserPassword)
    {
        $this->api = new Jira_Api(
            $endpoint,
            new Jira_Api_Authentication_Basic($jiraUserName, $jiraUserPassword)
        );
    }

    public function log(Programmer $programmer)
    {
        $coddingActivity = $programmer->getCoddingActivity();
        foreach ($coddingActivity->iterateProjects() as $project) {
            foreach ($project->iterateActivity() as $branch => $timeSpent) {
                $this->apiLogWork($branch, $timeSpent, $project->getName(), $programmer);
            }
        }
    }

    /**
     * @param string $issieKey
     * @param int $timeSpentSeconds
     * @return mixed
     */
    private function apiLogWork(string $issieKey, int $timeSpentSeconds, string $project, Programmer $programmer) {
        $name = $programmer->getName();
        $email = $programmer->getEmail();
        return $this->api->api(Jira_Api::REQUEST_POST, "/rest/api/2/issue/$issieKey/worklog", [
            "comment" => "Automatic work log for project: $project for $name $email",
            "started" => (new \DateTime)->format("Y-m-d\TH:i:s.000+0000"),
            "timeSpentSeconds" => $timeSpentSeconds
        ]);
    }
}