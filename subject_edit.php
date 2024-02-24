<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
  $id = $_POST['id'];
  $coursecode = $_POST['coursecode'];
  $subject = $_POST['subject'];
  $professor = $_POST['professor'];

  $sql = "UPDATE SUBJECTADD SET COURSECODE = ?, SUBJECT = ?, PROFNAME = ? WHERE SUBJECTID = ?";
  $params = array($coursecode, $subject, $professor, $id);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  } else {
    echo 'Data updated successfully.';
  }
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM SUBJECTADD WHERE SUBJECTID = ?";
  $params = array($id);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  }

  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
  header("Location: subject_show.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Edit Data</title>
</head>
<body>

<div class="container mt-5">
  <h2>Edit Data</h2>
  <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['SUBJECTID']; ?>">

    <div class="form-group">
      <label for="name">Course Code:</label>
      <input type="text" class="form-control" name="coursecode" value="<?php echo $row['COURSECODE']; ?>" required>
    </div>

    <div class="form-group">
      <label for="address">Subject Name:</label>
      <input type="text" class="form-control" name="subject" value="<?php echo $row['SUBJECT']; ?>" required>
    </div>

    <div class="form-group">
      <label for="contact">Professor's Name:</label>
      <input type="text" class="form-control" name="professor" value="<?php echo $row['PROFNAME']; ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-primary" style="margin-bottom: 15px;">Update</button><br>
  </form>

  <a href="subject_show.php" class="btn btn-secondary" role="button">Back</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
