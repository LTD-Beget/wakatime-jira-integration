<?php
/**
 * @author: Viskov Sergey
 * @date: 05.07.17
 * @time: 1:29
 */

use LTDBeget\jiraIntegration\Programmer;

require './vendor/autoload.php';

$programmer = new Programmer("dcf86605-d4f1-495f-bffb-1a71877eb73e");

echo $programmer->getWakatimeApiKey().PHP_EOL;