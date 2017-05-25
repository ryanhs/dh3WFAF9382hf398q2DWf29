<?php

if (!interface_exists('DriverInterface')) {
    interface DriverInterface {
        // methods to add some filter to search
        public function filterUN($type, $year, $number);
        public function filterName($name);
        public function filterFormerSchool($formerSchool);

        // execute all filter to data driver, and get results in array
        public function execute();
    }
}
