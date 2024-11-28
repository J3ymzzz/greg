<?php

require('./database.php'); // Include the database connection

if (isset($_POST['create'])) {
    // Capture form inputs
    $fullname = $_POST['name']; // Match the 'name' attribute from your form
    $email = $_POST['email']; // Match the 'email' attribute from your form
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely

    // Prepare and execute the query
    $queryCreate = "INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($queryCreate);

    if (!$stmt) {
        die("Error preparing query: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        echo '<script>alert("Successfully created!")</script>';
        echo '<script>window.location.href = "/maxine faustino/admin-index.php"</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '")</script>';
    }

    $stmt->close(); // Close the statement
}
?>
