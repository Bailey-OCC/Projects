<?php
require_once __DIR__ . '/lib/Database.php';
$pdo = Database::connect();

$sql = "SELECT s.student_id, s.fname, s.lname, s.campus, s.counselor_id,
               c.fname AS counselor_fname,
               c.lname AS counselor_lname
              FROM students s
              JOIN counselors c
                ON s.counselor_id = c.counselor_id
              ORDER BY s.lname, s.fname";

$stmt = $pdo->query($sql);
$students = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Students</title>
</head>

<body>

<h1>Students</h1>

<p>
    <a href="index.php">Home</a> |
    <a href="add_student.php">Add Student</a>
</p>

<table border="1" cellpadding="6">

<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Campus</th>
    <th>Counselor</th>
    <th>Actions</th>
</tr>

<?php foreach ($students as $student): ?>

<tr>

    <td><?= htmlspecialchars($student['student_id']) ?></td>

    <td><?= htmlspecialchars($student['fname']) ?></td>

    <td><?= htmlspecialchars($student['lname']) ?></td>

    <td><?= htmlspecialchars($student['campus']) ?></td>

    <td>
        <?= htmlspecialchars($student['counselor_fname']) ?>
        <?= htmlspecialchars($student['counselor_lname']) ?>
    </td>

    <td>

        <a href="student.php?id=<?= $student['student_id'] ?>">View</a>

        |

        <a href="edit_student.php?id=<?= $student['student_id'] ?>">Edit</a>

        |

        <a href="delete_student.php?id=<?= $student['student_id'] ?>">Delete</a>

    </td>

</tr>

<?php endforeach; ?>

</table>

</body>

</html>