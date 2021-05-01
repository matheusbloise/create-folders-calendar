<?php

include __DIR__ . '/../vendor/autoload.php';

use Service\ExecuteCalendarService;

$year = getopt("y:")['y'];

$calendarService = new ExecuteCalendarService($year);
$calendarService->execute();