# Classroom Management Mini Application

## Overview
This project is a simple classroom management application built using HTML and PHP. It allows users to manage student information, including adding, editing, and deleting student records. The application is designed to be responsive and user-friendly, utilizing Tailwind CSS for styling.

## Project Structure
```
classroom-management
├── classes
│   └── Student.php
├── includes
│   ├── header.php
│   └── footer.php
├── actions
│   ├── add_student.php
│   ├── delete_student.php
│   ├── edit_student.php
│   └── get_students.php
├── index.php
├── students.json
└── README.md
```
#Running the Application
 ```bash
 php -S localhost:8000
 ```
```diff
- don't missing  cd to the folder and run the command 
```

## Setup Instructions
1. **Clone the Repository**: Download or clone the repository to your local machine.
2. **Install a Local Server**: Ensure you have a local server environment set up (e.g., XAMPP, MAMP, or WAMP).
3. **Place the Project**: Move the `classroom-management` folder into the server's root directory (e.g., `htdocs` for XAMPP).
4. **Access the Application**: Open your web browser and navigate to `http://localhost/classroom-management/index.php`.

## Usage
- **Add Student**: Fill out the form on the main page to add a new student. The information will be saved in `students.json`.
- **Edit Student**: Click on the edit button next to a student's name to modify their details.
- **Delete Student**: Click on the delete button next to a student's name to remove them from the list.

## Features
- Responsive design using Tailwind CSS.
- User-friendly interface for managing student records.
- Persistent storage of student data in JSON format.
