<?php
    // Include the database connection
    $connection = require('./database.php');

    // Query the database
    $queryAccounts = "SELECT * FROM users";
    $sqlAccounts = mysqli_query($connection, $queryAccounts);

    // Check for query errors
    if (!$sqlAccounts) {
        die("Query failed: " . mysqli_error($connection));
    }
?>
