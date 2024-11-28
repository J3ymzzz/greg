<?php
require('./database.php');

// Check if an ID is passed in the URL
if (!isset($_GET['id'])) {
    die("No user ID provided");
}

// Validate and sanitize the user ID from URL
$userId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$userId) {
    die("Invalid User ID");
}

// Fetch the current user's details to pre-fill the form
$queryFetch = "SELECT id, fullname, email, password_hash FROM users WHERE id = ?";
$stmtFetch = $connection->prepare($queryFetch);
$stmtFetch->bind_param("i", $userId);
$stmtFetch->execute();
$result = $stmtFetch->get_result();

if ($result->num_rows === 0) {
    die("User not found");
}

$userData = $result->fetch_assoc();
$stmtFetch->close();

// Check if the update form is submitted
if (isset($_POST['update'])) {
    // Sanitize and validate inputs
    $updateFullname = trim($_POST['updateName']);
    $updateEmail = filter_var($_POST['updateEmail'], FILTER_VALIDATE_EMAIL);
    $updatePassword = $_POST['updatePassword'];

    // Validate required fields
    if ($updateFullname && $updateEmail && $updatePassword) {
        // Hash the new password
        $hashedPassword = password_hash($updatePassword, PASSWORD_DEFAULT);

        // Prepare the SQL query
        $queryUpdate = "UPDATE users SET fullname = ?, email = ?, password_hash = ? WHERE id = ?";
        $stmt = $connection->prepare($queryUpdate);

        if ($stmt) {
            $stmt->bind_param("sssi", $updateFullname, $updateEmail, $hashedPassword, $userId);

            // Execute the query and check the result
            if ($stmt->execute()) {
                echo '<script>alert("Successfully updated!");</script>';
                echo '<script>window.location.href = "/maxine faustino/admin-index.php";</script>';
            } else {
                echo '<script>alert("Error updating user: ' . $stmt->error . '");</script>';
            }

            $stmt->close(); // Close the prepared statement
        } else {
            die("Error preparing statement: " . $connection->error);
        }
    } else {
        echo '<script>alert("Please fill out all fields correctly.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client Account</title>
    <style>
        /* (CSS styles remain the same) */
    </style>
</head>
<body>
    <div class="main">
        <form class="update-main" action="" method="post">
            <h3>Update Client User</h3>
            <input type="hidden" name="id" value="<?php echo $userId; ?>" />
            <input type="text" name="updateName" placeholder="Fullname" value="<?php echo htmlspecialchars($userData['fullname']); ?>" required>
            <input type="email" name="updateEmail" placeholder="Email Address" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            <input type="password" name="updatePassword" placeholder="Password" required>
            <input type="submit" name="update" value="Update Client Account">
        </form>
    </div>
</body>
</html>