<?php
class Student {
    private $name;
    private $age;
    private $grade;

    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }

    public function getName() {
        return $this->name;
    }

    public function getAge() {
        return $this->age;
    }

    public function getGrade() {
        return $this->grade;
    }

    public static function addStudent($student) {
        $students = self::getAllStudents();
        $students[] = $student;
        self::saveStudents($students);
    }

    public static function editStudent($index, $student) {
        $students = self::getAllStudents();
        if (isset($students[$index])) {
            $students[$index] = $student;
            self::saveStudents($students);
        }
    }

    public static function deleteStudent($index) {
        $students = self::getAllStudents();
        if (isset($students[$index])) {
            unset($students[$index]);
            self::saveStudents(array_values($students));
        }
    }

    public static function getAllStudents() {
        if (file_exists('../students.json')) {
            $data = file_get_contents('../students.json');
            return json_decode($data, true);
        }
        return [];
    }

    private static function saveStudents($students) {
        file_put_contents('../students.json', json_encode($students, JSON_PRETTY_PRINT));
    }
}
?>