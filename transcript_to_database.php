<?php
// Database connection details
$serverName = "CHARLES-MENDOZA\SQLEXPRESS"; // adjust as necessary
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "", // fill in your db username
    "PWD" => ""  // fill in your db password
];

// Connect to the database
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $convo_body = $_POST['CONVO_BODY'];

    // Prepare the SQL query
    $sql = "INSERT INTO TRANSCRIPTION (CONVO_BODY) VALUES (?)";
    $params = array($convo_body);

    // Execute the query
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Transcript saved successfully.";
    }
}
?>
