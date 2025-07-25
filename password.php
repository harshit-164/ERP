<?php

// Assuming you have a form that submits data to this script
if (isset($_POST['submit_student'])) {
    $plainPassword = $_POST['password']; // Get the password from the form

    // Securely hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Assuming you have your database connection established ($pdo in this example)

    try {
        $stmt = $pdo->prepare("INSERT INTO students (password)
                               VALUES ( :password)");

        // Bind the hashed password
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();

        echo "Student data added successfully!";
        // Redirect or display a success message
    } catch (PDOException $e) {
        echo "Error adding student data: " . $e->getMessage();
        // Handle the error appropriately
    }
}

?>
