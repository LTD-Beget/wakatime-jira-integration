<?php
/**
 * @author: Viskov Sergey
 * @date: 05.07.17
 * @time: 1:29
 */

use LTDBeget\jiraIntegration\Programmer;
use LTDBeget\jiraIntegration\WorkLogger;

require '../vendor/autoload.php';

$programmer = new Programmer("your-wakatime-api-key");
$workLogger = new WorkLogger(
    "https://path-to-your-jira.com",
    "your-yser-name",
    "your-user-pass"
);
$workLogger->log($programmer);