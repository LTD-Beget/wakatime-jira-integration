<?php
/**
 * @author: Viskov Sergey
 * @date: 05.07.17
 * @time: 2:07
 */

namespace LTDBeget\jiraIntegration;

use GuzzleHttp\Client as Guzzle;
use Mabasic\WakaTime\WakaTime;

/**
 * Class Programmer
 * @package LTDBeget\jiraIntegration
 */
class Programmer
{
    /**
     * @var string
     */
    private $wakatimeApiKey;
    /**
     * @var WakaTime
     */
    private $wakatime;

    /**
     * @var CoddingActivity
     */
    private $coddingActivity;

    /**
     * Programmer constructor.
     * @param string $wakatimeApiKey
     */
    public function __construct(string $wakatimeApiKey)
    {
        $this->wakatime        = new WakaTime(new Guzzle, $wakatimeApiKey);
        $this->wakatimeApiKey  = $wakatimeApiKey;
        $this->coddingActivity = new CoddingActivity();
        foreach ($this->getTodayProjects() as $project) {
            $summaries = $this->wakatime->durations($this->getTodayWithWakaTimeFormat(), $project);
            if(!array_key_exists("data", $summaries)) {
                continue;
            }
            foreach ($summaries['data'] as $summary) {
                if( !array_key_exists("project", $summary) ||
                    !array_key_exists("branch", $summary) ||
                    !array_key_exists("duration", $summary)) {
                    continue;
                }

                $this->coddingActivity->add($summary['project'], $summary['branch'], $summary['duration']);
            }
        }
    }

    private function getTodayProjects(): array
    {
        $summaries = $this->wakatime->durations($this->getTodayWithWakaTimeFormat());
        $projects  = [];
        if(array_key_exists("data", $summaries)) {
            foreach ($summaries['data'] as $dataChunk) {
                $projects[] = $dataChunk["project"];
            }
        }

        return $projects;
    }

    private function getTodayWithWakaTimeFormat(): string
    {
        return (new \DateTime)->format("Y-m-d");
    }

    /**
     * @return CoddingActivity
     */
    public function getCoddingActivity(): CoddingActivity
    {
        return $this->coddingActivity;
    }
}