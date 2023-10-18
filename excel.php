<?php
// Read CSV data
$csvData = file_get_contents('excfile.csv');
$dataArray = array_map('str_getcsv', explode("\n", $csvData));

// Convert CSV data to JSON
$jsonData = json_encode($dataArray);

// Set headers to indicate JSON content
header('Content-Type: application/json');

// Output JSON data
echo $jsonData;
?>
