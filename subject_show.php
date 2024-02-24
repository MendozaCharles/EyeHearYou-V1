<?php
session_start();

$serverName = "CHARLES-MENDOZA\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if (isset($_POST['subjectid'])) {
        $subjectid = $_POST['subjectid'];

        $sqlDelete = "DELETE FROM SUBJECTADD WHERE SUBJECTID = ?";
        $paramsDelete = array($subjectid);
        $stmtDelete = sqlsrv_query($conn, $sqlDelete, $paramsDelete);

        if ($stmtDelete === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo 'Data deleted successfully.';
        }
    }
}

// Retrieve USERID from session
if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    // Query to fetch subjects related to the logged-in user
    $sql = "SELECT * FROM SUBJECTADD WHERE USERID = ?";
    $params = array($userid);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Show Data</title>
</head>
<body>

<div class="container mt-5">
    <h2><center>Subject Information</center></h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Course</th>
            <th scope="col">Subject</th>
            <th scope="col">Professor</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['COURSECODE']}</td>";
            echo "<td>{$row['SUBJECT']}</td>";
            echo "<td>{$row['PROFNAME']}</td>";
            echo "<td><center><a href='subject_edit.php?id={$row['SUBJECTID']}' class='btn btn-warning'>Edit</a></center></td>";
            echo "<td><center>
                <form method='post' action=''>
                  <input type='hidden' name='subjectid' value='{$row['SUBJECTID']}'>
                  <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                </center></form>
              </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="subject.php" class="btn btn-primary" role="button">Add a Subject</a><br>
    <center><a href="user_dashboard.php" class="btn btn-primary" role="button">User Dashboard</a></center>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
