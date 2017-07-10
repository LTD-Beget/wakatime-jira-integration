<?php
/**
 * @author: Viskov Sergey
 * @date: 08.07.17
 * @time: 19:05
 */

namespace LTDBeget\jiraIntegration;


/**
 * Class Project
 * @package LTDBeget\jiraIntegration
 */
class Project
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int[]
     */
    private $branchAndTimeSpent = [];

    public function __construct(string $name)
    {
        $this->name = trim($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $branch
     * @param int $time
     * @return Project
     */
    public function addActivity(string $branch, int $time): self
    {
        $branch = trim($branch);
        if (array_key_exists($branch, $this->branchAndTimeSpent)) {
            $this->branchAndTimeSpent[$branch] = $this->branchAndTimeSpent[$branch] + $time;
        } else {
            $this->branchAndTimeSpent[$branch] = $time;
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function iterateActivity() {
        foreach ($this->branchAndTimeSpent as $branch => $timeSpent) {
            yield $branch => $timeSpent;
        }
    }
}