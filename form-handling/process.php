<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-4 md:p-8 space-y-6 bg-white rounded-lg shadow-lg transform transition duration-300 hover:shadow-2xl mx-4">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $confirm = htmlspecialchars($_POST['confirm_password']);

            $errors = [];
            if (empty($name)) {
                $errors[] = "Name is required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            if ($password !== $confirm) {
                $errors[] = "Passwords do not match.";
            }

            if (empty($errors)) {
                echo '<h2 class="text-xl md:text-2xl font-bold text-center text-green-600">Form Submitted Successfully!</h2>';
                echo '<div class="space-y-4">';
                echo '<div class="p-4 bg-gray-50 rounded-lg">';
                echo "<p class='text-gray-700'><span class='font-medium'>Name:</span> $name</p>";
                echo "<p class='text-gray-700'><span class='font-medium'>Email:</span> $email</p>";
                echo "<p class='text-gray-700'><span class='font-medium'>Password:</span> ********</p>";
                echo '</div>';
                echo '</div>';
            } else {
                echo '<h2 class="text-xl md:text-2xl font-bold text-center text-red-600">Error</h2>';
                echo '<div class="p-4 bg-red-50 rounded-lg">';
                echo '<ul class="list-disc list-inside space-y-2">';
                foreach ($errors as $err) {
                    echo "<li class='text-red-600'>$err</li>";
                }
                echo '</ul>';
                echo '</div>';
            }
        } else {
            echo '<h2 class="text-xl md:text-2xl font-bold text-center text-red-600">Invalid Request</h2>';
        }
        ?>
        <a href="index.html" class="block w-full px-4 py-2 font-bold text-center text-white bg-blue-500 rounded-lg transform transition duration-300 hover:bg-blue-600 hover:scale-[1.02] active:scale-95">Back to Form</a>
    </div>
</body>
</html>