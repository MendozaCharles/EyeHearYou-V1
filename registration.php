<?php
$serverName = "CHARLES-MENDOZA\SQLEXPRESS"; // adjust as necessary
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "", // fill in your db username
    "PWD" => ""  // fill in your db password
];

// Create a connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check if the connection was established
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Initialize variables
$latestAccountID = null;
$latestEmail = null;
$passwordUpdated = false;
$errors = [];

// Query to get the latest account ID and email
$sql = "SELECT TOP 1 ACCOUNTID, EMAIL FROM LOGIN ORDER BY ACCOUNTID DESC";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the data if available
if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $latestAccountID = $row['ACCOUNTID'];
    $latestEmail = $row['EMAIL'];
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    // Check if the two passwords match
    if ($_POST['password'] === $_POST['confirm_password']) {
        // Retrieve the new password from POST data (plaintext)
        $newPassword = $_POST['password'];

        // Get the current date and time in a format SQL Server can understand
        $currentDateTime = date('Y-m-d H:i:s');

        // Prepare the update statement to update the password and date_registration
        $updateSql = "UPDATE LOGIN SET PASSWORD = ?, DATE_REGISTRATION = ? WHERE ACCOUNTID = ?";
        $params = [$newPassword, $currentDateTime, $latestAccountID];

        $updateStmt = sqlsrv_query($conn, $updateSql, $params);

        if ($updateStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            $passwordUpdated = true;
        }
    } else {
        $errors[] = "Passwords do not match.";
    }
}
// Free the statement and close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Register5.css">
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        input[type="text"], input[type="password"] {
            margin: 10px 0;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <?php if($passwordUpdated): ?>
            <p>Password updated successfully for account ID <?php echo htmlspecialchars($latestAccountID); ?>.</p>
        <?php else: ?>
            <?php foreach ($errors as $error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <p>Latest Account ID: <?php echo htmlspecialchars($latestAccountID); ?></p>
            <p>Email: <?php echo htmlspecialchars($latestEmail); ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="confirm_password">Re-type Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <input type="submit" value="Set Password">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>