<?php

$connection = require('./database.php'); // Assign the returned mysqli object to $connection

if (!$connection) {
    die('<script>alert("Database connection failed."); window.location.href = "/maxine faustino/admin-index.php";</script>');
}

if (isset($_POST['delete']) && isset($_POST['deleteId'])) {
    // Validate the ID
    $deleteId = filter_var($_POST['deleteId'], FILTER_VALIDATE_INT);

    if ($deleteId !== false) {
        // Use a prepared statement to safely delete the record
        $queryDelete = "DELETE FROM users WHERE id = ?";
        $stmt = $connection->prepare($queryDelete);

        if ($stmt) {
            $stmt->bind_param("i", $deleteId);

            if ($stmt->execute()) {
                echo '<script>alert("Successfully deleted!");</script>';
            } else {
                echo '<script>alert("Error deleting the record. Please try again.");</script>';
            }

            $stmt->close();
        } else {
            echo '<script>alert("Error preparing the delete statement.");</script>';
        }
    } else {
        echo '<script>alert("Invalid ID provided.");</script>';
    }

    echo '<script>window.location.href = "/maxine faustino/admin-index.php";</script>';
} else {
    echo '<script>window.location.href = "/maxine faustino/admin-index.php";</script>';
}

?>
