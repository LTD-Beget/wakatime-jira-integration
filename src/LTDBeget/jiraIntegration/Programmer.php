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
            // TODO check array key exists!
            foreach ($summaries['data'] as $summary) {
                $this->coddingActivity->add($summary['project'], $summary['branch'], $summary['duration']);
            }
        }
    }

    private function getTodayProjects(): array
    {
        $summaries = $this->wakatime->durations($this->getTodayWithWakaTimeFormat());
        $projects  = [];
        foreach ($summaries['data'] as $dataChunk) {
            $projects[] = $dataChunk["project"];
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

    /**
     * Вытаскиваем имена всех веток по всем проектам программиста за последний час активности
     * Это ветки в контексте которых программист сейчас работает
     *
     * @return string[]
     */
    public function getActiveBranches() : array {
//        $this->wakatime->heartbeats("2017-07-05", "time,project,branch");
//        // собственно отсюда можно достать активность за последний час или любой другой период
//
//        print_r(
////            $this->wakatime->durations("2017-07-05", "wakatime-jira-integration")
//            $this->wakatime->heartbeats("2017-07-05", "time,project,branch")
//        );

        return [];
    }



    // получить список активных иш
    // пересечь их со списком активных веток
    // попавшие в пересечение это список иш в которых сейчас работает программист
    // не попавшие активные те над которыми он перестал работать или с которых переключится
    // их нужно перевести в to do
}