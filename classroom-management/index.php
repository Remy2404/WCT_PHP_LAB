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

    <main class="container mx-auto p-4 flex-grow">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Student Management</h2>

        <form action="actions/add_student.php" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="mb-4">
                <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="age" class="block text-lg font-medium text-gray-700">Age</label>
                <input type="number" name="age" id="age" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="grade" class="block text-lg font-medium text-gray-700">Grade</label>
                <input type="text" name="grade" id="grade" required class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white text-lg py-2 rounded-lg hover:bg-blue-700">Add Student</button>
        </form>

        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Student List</h3>
        <div id="student-list" class="bg-white shadow-md rounded-lg p-6">
            <!-- Student list will be populated here via JavaScript -->
        </div>
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

        function editStudent(id) {
            // Redirect to a form page or implement inline editing
            window.location.href = `includes/edit_form.php?id=${id}`;
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>