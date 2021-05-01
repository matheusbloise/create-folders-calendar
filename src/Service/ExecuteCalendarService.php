<?php

namespace Service;

use Carbon\Carbon;

class ExecuteCalendarService {

    private string $year;

    private array $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

    public function __construct(string $year) {
        $this->year = $year;
    }

    public function execute() {
        $this->executeYear();
        $this->executeMonths();
        $this->executeDays();
    }

    private function executeYear(): void {
        $date = Carbon::create($this->year);
        exec("mkdir {$date->format('Y')}");
    }

    private function executeMonths(): void {
        $months = array_map(fn ($month) => Carbon::create($this->year, $month)->format('M'), $this->months);
        array_walk($months, fn ($month, $key) => exec("cd $this->year && mkdir {$this->months[$key]}-$month"));
    }

    private function executeDays(): void {
        foreach($this->months as $month) {
            $date = Carbon::create($this->year, $month);
            $namelyMonth = Carbon::create($this->year, $month)->format('M');

            do {
                $day = Carbon::make($date)->format('d');
                exec("cd $this->year && cd {$month}-$namelyMonth && mkdir $day");
                $date->addDay();

            } while($month == Carbon::make($date)->format('m'));
        }
    }
}