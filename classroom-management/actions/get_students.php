<?php

header('Content-Type: application/json');

$studentsFile = '../students.json';

if (file_exists($studentsFile)) {
    $studentsData = file_get_contents($studentsFile);
    echo $studentsData;
} else {
    echo json_encode([]);
}
?>