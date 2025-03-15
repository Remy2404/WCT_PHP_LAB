<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'includes/header.php'; ?>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex-grow">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6">Student Management</h2>
    
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
    
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
    
        <form action="actions/add_student.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-8" onsubmit="return validateForm()">
            <div class="mb-4">
                <label for="name" class="block text-base sm:text-lg font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="age" class="block text-base sm:text-lg font-medium text-gray-700">Age</label>
                <input type="number" name="age" id="age" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="grade" class="block text-base sm:text-lg font-medium text-gray-700">Grade</label>
                <input type="number" name="grade" id="grade" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div id="error-message" class="text-red-500 mb-4"></div>
            <button type="submit" class="w-full bg-blue-600 text-white text-base sm:text-lg py-2 rounded-lg hover:bg-blue-700">Add Student</button>
        </form>

        <div id="student-list" class="bg-white p-6 rounded-lg shadow-md"></div>
    </main>

    <script>
        window.onload = function () {
            fetch('actions/get_students.php')
                .then(response => response.json())
                .then(data => {
                    const studentList = document.getElementById('student-list');
                    studentList.innerHTML = '';
                    data.forEach(student => {
                        const studentItem = document.createElement('div');
                        studentItem.className = 'flex justify-between items-center border-b py-4';
                        studentItem.innerHTML = `
                            <div class="text-lg">
                                <strong>${student.name}</strong> (Age: ${student.age}, Grade: ${student.grade})
                            </div>
                            <div class="text-right">
                                <button onclick="editStudent('${student.id}')" class="text-blue-500 hover:underline">Edit</button>
                                <button onclick="deleteStudent('${student.id}')" class="text-red-500 hover:underline ml-4">Delete</button>
                            </div>
                        `;
                        studentList.appendChild(studentItem);
                    });
                });
        }

        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('actions/delete_student.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    });
            }
        }

        function validateForm() {
            const name = document.getElementById('name').value;
            const age = document.getElementById('age').value;
            const grade = document.getElementById('grade').value;
            const errorMessage = document.getElementById('error-message');
            const nameRegex = /^[a-zA-Z\s]+$/;
            const ageRegex = /^\d+$/;
            const gradeRegex = /^\d+$/;
            if (!nameRegex.test(name)) {
                errorMessage.textContent = 'Name should only contain letters and spaces.';
                return false;
            }
            if (!ageRegex.test(age)) {
                errorMessage.textContent = 'Age should be a number.';
                return false;
            }
            if (!gradeRegex.test(grade)) {
                errorMessage.textContent = 'Grade should be a number.';
                return false;
            }
            if (grade < 1 || grade > 12) {
                errorMessage.textContent = 'Grade must be between 1 and 12.';
                return false;
            }
            errorMessage.textContent = '';
            return true;
        }

        function editStudent(id) {
            window.location.href = `includes/edit_form.php?id=${id}`;
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>