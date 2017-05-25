<?php

// load one of drivers, here choose what you need

require __DIR__.'/models/Student.php';
require __DIR__.'/drivers/ExampleArray.php';
$driver = new ExampleArray();

// require __DIR__.'/drivers/Database.php';
// $driver = new Database();

// require __DIR__.'/drivers/DatabaseMySQL.php';
// $driver = new DatabaseMySQL();

// require __DIR__.'/drivers/DatabasePostgreSQL.php';
// $driver = new DatabasePostgreSQL();

$callback = false;
// ajax callback?
if (!empty($_GET['callback']))
    $callback = strval($_GET['callback']);

// name ?
if (!empty($_GET['name']))
    $driver->filterName(strval($_GET['name']));

// birthdate?
if (!empty($_GET['formerschool']))
    $driver->filterFormerSchool(strval($_GET['formerschool']));

// un?
if (!empty($_GET['untype']))
    if (!empty($_GET['unyear']))
        if (!empty($_GET['unnumber']))
            $driver->filterUN(strval($_GET['untype']), strval($_GET['unyear']), strval($_GET['unnumber']));

// $results = json_encode($driver->execute());
$results = json_encode($driver->execute(), JSON_PRETTY_PRINT); // for debug is good to have pretty print

header('Content-Type:application/json');
if ($callback !== false) echo $callback.'(';
echo $results;
if ($callback !== false) echo ');';
