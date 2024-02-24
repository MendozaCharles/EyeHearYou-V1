<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["login"];
    $password = $_POST["password"];

    $serverName = "CHARLES-MENDOZA\SQLEXPRESS";
    $connectionOptions = array(
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = "SELECT * FROM REGISTER WHERE EMAIL = ?";
    $params = array($email);

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        if (password_verify($password, $row["PASSWORD"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["userid"] = $row["USERID"];
            $_SESSION["email"] = $email;

            header("Location: user_dashboard.php");
exit;

        } else {
            echo "<script>alert('Password mismatch.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email is not registered.'); window.location.href='login.html';</script>";
    }
}
?>
