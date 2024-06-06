<?php
require 'vendor/phplucidframe/console-table/src/LucidFrame/Console/ConsoleTable.php';

use LucidFrame\Console\ConsoleTable;

$table = new ConsoleTable();
$resourceID = '25e80bf3-f107-4ab4-89ef-251b5b9374e9';

$userSearch = readline("Enter company name: \n");
$data = "https://data.gov.lv/dati/lv/api/3/action/datastore_search?q={$userSearch}&resource_id={$resourceID}";

$json = file_get_contents($data);

if ($json === false) {
    die("Failed to fetch data from the API.");
}

$database = json_decode($json);

if ($database === null) {
    die("Failed to decode JSON.");
}

if ($database->result->records === [])) {
    die("No records of {$userSearch} found.");
}

$table->setHeaders(array('ID', 'Name', 'Type', 'Address', 'Status'));

foreach ($database->result->records as $row) {
    $table->addRow([
        $row->_id,
        $row->name,
        $row->type,
        $row->address,
        $row->closed === ' ' ? 'active' : 'X'
    ]);
}

$table->display();
