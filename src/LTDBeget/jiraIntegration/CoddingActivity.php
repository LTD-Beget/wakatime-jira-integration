<?php
/**
 * @author: Viskov Sergey
 * @date: 08.07.17
 * @time: 18:39
 */

namespace LTDBeget\jiraIntegration;

/**
 * Class CoddingActivity
 * @package LTDBeget\jiraIntegration
 */
class CoddingActivity
{
    /**
     * @var Project[]
     */
    private $projects = [];

    /**
     * @param string $project
     * @param string $branch
     * @param int $time
     * @return CoddingActivity
     */
    public function add(string $project, string $branch, int $time): self
    {
        $project = trim($project);
        if (array_key_exists($project, $this->projects)) {
            $this->projects[$project]->addActivity($branch, $time);
        } else {
            $this->projects[$project] = (new Project($project))->addActivity($branch, $time);
        }

        return $this;
    }

    /**
     * @return \Iterator|Project[]
     */
    public function iterateProjects(): \Iterator
    {
        foreach ($this->projects as $project) {
            yield $project;
        }
    }
}