<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $grade = $_POST['grade'] ?? '';

    if (empty($id) || empty($name) || empty($age) || empty($grade)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    if (!is_numeric($age) || $age < 0) {
        echo json_encode(['status' => 'error', 'message' => 'Age must be a valid positive number.']);
        exit;
    }

    if (!is_numeric($grade) || $grade < 1 || $grade > 12) {
        echo json_encode(['status' => 'error', 'message' => 'Grade must be between 1 and 12.']);
        exit;
    }

    $studentsFile = '../students.json';
    if (!file_exists($studentsFile)) {
        echo json_encode(['status' => 'error', 'message' => 'Students file not found.']);
        exit;
    }
    
    $studentsData = json_decode(file_get_contents($studentsFile), true);
    if ($studentsData === null) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data in students file.']);
        exit;
    }

    $found = false;

    foreach ($studentsData as $index => $student) {
        if (isset($student['id']) && $student['id'] === $id) {
            $studentsData[$index]['name'] = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $studentsData[$index]['age'] = (int)$age;
            $studentsData[$index]['grade'] = (int)$grade;
            $found = true;
            break;
        }
    }

    if ($found) {
        if (file_put_contents($studentsFile, json_encode($studentsData, JSON_PRETTY_PRINT)) !== false) {
            echo json_encode(['status' => 'success', 'message' => 'Student updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Could not write to students file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>