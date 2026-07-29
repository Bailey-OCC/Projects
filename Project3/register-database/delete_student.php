<?php

require_once __DIR__ . '/lib/Database.php';

$pdo = Database::connect();

// Validate the student ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid student ID.");
}

// Retrieve the student
$sql = "SELECT *
        FROM students
        WHERE student_id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();

$student = $stmt->fetch();

if (!$student) {
    exit("Student not found.");
}

// If the confirmation form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "DELETE FROM students
            WHERE student_id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: students.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Delete Student</title>
</head>

<body>

<h1>Delete Student</h1>

<p>
    Are you sure you want to delete
    <strong>
        <?= htmlspecialchars($student['fname']) ?>
        <?= htmlspecialchars($student['lname']) ?>
    </strong>?
</p>

<form method="post">

    <input type="submit" value="Delete Student">

</form>

<p>
    <a href="students.php">Cancel</a>
</p>

</body>

</html>