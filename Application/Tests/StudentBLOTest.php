<?php
require_once '../../loader.php';

$testFunctions = new StudentBLO();

$printData = $testFunctions->GetAllStudents();

echo "<pre>";
var_dump($printData);
echo "</pre>";
?>