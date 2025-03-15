<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $grade = trim($_POST['grade']);

    if (!empty($name) && !empty($age) && !empty($grade)) {
        if (!is_numeric($grade) || $grade < 1 || $grade > 12) {
            header('Location: ../index.php?error=Grade must be between 1 and 12');
            exit;
        }

        $studentData = json_decode(file_get_contents('../students.json'), true);
        $newStudent = [
            'id' => uniqid(),
            'name' => $name,
            'age' => $age,
            'grade' => $grade
        ];
        $studentData[] = $newStudent;
        file_put_contents('../students.json', json_encode($studentData, JSON_PRETTY_PRINT));
        header('Location: ../index.php?success=Student added successfully');
    } else {
        header('Location: ../index.php?error=All fields are required');
    }
} else {
    header('Location: ../index.php');
}
?>