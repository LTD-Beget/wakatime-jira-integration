<?php
/**
 * @author: Viskov Sergey
 * @date: 05.07.17
 * @time: 2:07
 */

namespace LTDBeget\jiraIntegration;

/**
 * Class Programmer
 * @package LTDBeget\jiraIntegration
 */
class Programmer
{
    /**
     * Programmer constructor.
     * @param string $wakatimeApiKey
     */
    public function __construct(string $wakatimeApiKey)
    {
        $this->wakatimeApiKey = $wakatimeApiKey;
    }

    /**
     * @var string
     */
    private $wakatimeApiKey;

    /**
     * @return string
     */
    public function getWakatimeApiKey(): String
    {
        return $this->wakatimeApiKey;
    }


    /**
     * Вытаскиваем имена всех веток по всем проектам программиста за последнии N часов активности
     * Это ветки в контексте которых программист сейчас работает
     *
     * @return string[]
     */
    public function getActiveBranches() : array {
        return [];
    }
}