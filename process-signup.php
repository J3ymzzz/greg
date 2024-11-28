<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include and retrieve database connection
    $mysqli = require __DIR__ . "/database.php";

    // Check if $mysqli is a valid object
    if (!$mysqli instanceof mysqli) {
        die("Failed to connect to the database.");
    }

    // Validation for Name
    if (empty(trim($_POST["name"]))) {
        die("Name is required!");
    }

    // Validation for Email
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required!");
    }

    // Validation for Password
    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters.");
    }

    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter.");
    }

    if (!preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number.");
    }

    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Passwords must match!");
    }

    // Password Hashing
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if the email is already taken
    $email = $_POST["email"];
    $checkEmailSql = "SELECT id FROM users WHERE email = ? LIMIT 1";

    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($checkEmailSql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        die("SQL execute error: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email already taken!");
    }

    // Insert into database
    $insertSql = "INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($insertSql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

    if (!$stmt->execute()) {
        die("Error during insertion: " . $stmt->error);
    }

    header("Location: signup-success.html");
    exit;
}
