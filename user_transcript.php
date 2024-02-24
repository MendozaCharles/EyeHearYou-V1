<?php
session_start();

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
    // Check if USERID is set in session
    if(isset($_SESSION["userid"])) {
        $userid = $_SESSION["userid"];
        
        $convo_body = $_POST['CONVO_BODY'];
        $subject_id = isset($_POST['SUBJECTID']) ? $_POST['SUBJECTID'] : null; // Check if SUBJECTID is set

        // Prepare the SQL query
        $sql = "INSERT INTO USER_TRANSCRIPTION (USERID, CONVO_BODY, SUBJECTID) VALUES (?, ?, ?)";
        $params = array($userid, $convo_body, $subject_id);

        // Execute the query
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Transcript saved successfully.";
        }
    } else {
        echo "Error: USERID not set in session.";
    }
}
?>
