<?php

require __DIR__.'/DriverInterface.php';
require __DIR__.'/../models/Student.php';

if (!class_exists('ExampleArray')) {
    class ExampleArray implements DriverInterface {
        private $data = [];
        private $filters = [];
        private $percentToCheck = 100;

        public function __construct() {
            $this->data = array_map('str_getcsv', file(__DIR__.'/../dataset/ExampleArray.csv'));
            $this->percentToCheck = 80;
        }

        public function filterUN($type, $year, $number) {
            $this->filters['0'] = $type.'|'.$year.'|'.$number;
        }

        public function filterName($name) {
            $this->filters['1'] = $name;
        }

        public function filterFormerSchool($formerSchool) {
            $this->filters['2'] = $formerSchool;
        }

        public function execute() {
            // pass if no filters
            if (count($this->filters) == 0) return [];

            $results = [];
            foreach ($this->data as $student) {
                $isSimiliar = true;

                // where  similar(UN) and similar(formerSchool) and similar(name)
                foreach ($this->filters as $k => $v) {
                    similar_text(strtolower($student[$k]), strtolower($v), $percent); // im this case, we use similar_text function
                    $isSimiliar = $isSimiliar && ($percent > $this->percentToCheck);
                }

                if ($isSimiliar) {
                    $tmp = new Student;
                    $tmp->name = $student[1];
                    $tmp->formerSchool = $student[2];
                    $tmp->unType = explode('|', $student[0])[0];
                    $tmp->unYear = explode('|', $student[0])[1];
                    $tmp->unNumber = explode('|', $student[0])[2];
                    $tmp->registeredAt = $student[3];
                    $results[] = $tmp;
                }
            }
            return $results;
        }
    }
}
