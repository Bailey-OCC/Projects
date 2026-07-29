<?php
require_once __DIR__ . '/lib/Database.php';
$pdo = Database::connect();
// Validate id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('Invalid recipe id');
}

// Get Student
$sqlStudent = "SELECT s.student_id, s.fname, s.lname, s.campus, s.counselor_id,
               c.fname AS counselor_fname,
               c.lname AS counselor_lname
              FROM students s
              JOIN counselors c
                ON s.counselor_id = c.counselor_id
              WHERE student_id = :id";

$stmt = $pdo->prepare($sqlStudent);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    exit('Student not found');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        <?= htmlspecialchars($student['fname']) ?>
        <?= htmlspecialchars($student['lname']) ?>
    </title>
</head>

<body>

<a href="students.php">Back to Students</a>

<h1>
    <?= htmlspecialchars($student['fname']) ?>
    <?= htmlspecialchars($student['lname']) ?>
</h1>

<p>
    <strong>Student ID:</strong>
    <?= htmlspecialchars($student['student_id']) ?>
</p>

<p>
    <strong>Campus:</strong>
    <?= htmlspecialchars($student['campus']) ?>
</p>

<p>
    <strong>Counselor ID:</strong>
    <?= htmlspecialchars($student['counselor_id']) ?>
</p>

<p>
    <strong>Counselor:</strong>
    <?= htmlspecialchars($student['counselor_fname']) ?>
    <?= htmlspecialchars($student['counselor_lname']) ?>
</p>

</body>
</html>