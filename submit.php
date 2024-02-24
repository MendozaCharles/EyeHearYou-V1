<?php
// First, check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and assign to variables
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["Email"]; // Correct the case to match your form field's name
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='register.html';</script>";
        exit;
    }

    // Database connection
    $serverName = "CHARLES-MENDOZA\SQLEXPRESS"; // Update with your details
    $connectionOptions = array(
        "Database" => "WEBAPP", // Update with your details
        "Uid" => "", // Update with your details
        "PWD" => "" // Update with your details
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn === false){
        die(print_r(sqlsrv_errors(), true));
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO REGISTER (FIRSTNAME, LASTNAME, EMAIL, PASSWORD) VALUES (?, ?, ?, ?)";
    $params = array($firstname, $lastname, $email, password_hash($password, PASSWORD_DEFAULT));

    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    if(sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "<script>alert('Registration successful.'); window.location.href='login.html';</script>";
}
?>
