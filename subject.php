<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Phone Book</title>
</head>
<body>

<?php
session_start();

$serverName = "CHARLES-MENDOZA\SQLEXPRESS";
$connectionOptions = [
  "Database" => "WEBAPP",
  "Uid" => "",
  "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn == false) {
  die(print_r(sqlsrv_errors(), true));
} else {
  echo '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
  // Retrieve USERID from session
  if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    
    $coursecode = $_POST['coursecode']; 
    $subject = $_POST['subject']; 
    $professor = $_POST['professor'];

    $sql = "INSERT INTO SUBJECTADD (USERID, COURSECODE, SUBJECT, PROFNAME) VALUES (?, ?, ?, ?)";
    $params = array($userid, $coursecode, $subject, $professor);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
      die(print_r(sqlsrv_errors(), true));
    } else {
      header("Location: subject_show.php");
      exit();
    }
  }
}

?>

<div class="container mt-5">
  <form method="post" action="">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Course Code</th>
          <th scope="col">Subject</th>
          <th scope="col">Professor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="text" name="coursecode" class="form-control" placeholder="Enter Course Code" required></td>
          <td><input type="text" name="subject" class="form-control" placeholder="Enter Subject Name" required></td>
          <td><input type="text" name="professor" class="form-control" placeholder="Enter Professor's Name" required></td>
          <td>
          <center><button type="submit" name="add" class="btn btn-success">Add</button></center>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <a href="subject_show.php" class="btn btn-primary" role="button">Records</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
