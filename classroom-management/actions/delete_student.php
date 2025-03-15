<?php
header('Content-Type: application/json');

// Check for either GET or POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['id'] ?? '';
} else {
    // Return error for non-POST requests
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!empty($studentId)) {
    // Load existing students
    $studentsFile = '../students.json';
    
    if (!file_exists($studentsFile)) {
        echo json_encode(['success' => false, 'message' => 'Students file not found.']);
        exit;
    }
    
    $fileContent = file_get_contents($studentsFile);
    if ($fileContent === false) {
        echo json_encode(['success' => false, 'message' => 'Could not read students file.']);
        exit;
    }
    
    $studentsData = json_decode($fileContent, true) ?? [];
    
    // Find student by ID
    $found = false;
    foreach ($studentsData as $key => $student) {
        if (isset($student['id']) && $student['id'] == $studentId) {
            unset($studentsData[$key]);
            $found = true;
            break;
        }
    }
    
    if ($found) {
        // Re-index array
        $studentsData = array_values($studentsData);
        
        // Save updated students back to the file
        if (file_put_contents($studentsFile, json_encode($studentsData, JSON_PRETTY_PRINT)) !== false) {
            echo json_encode(['success' => true, 'message' => 'Student deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Could not write to students file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Student not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid student ID.']);
}
?>