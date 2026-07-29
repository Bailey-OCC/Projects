<?php
require_once __DIR__ . '/lib/Database.php';
$pdo = Database::connect();

$sql = "SELECT counselor_id, fname, lname
        FROM counselors
        ORDER BY lname, fname";

$stmt = $pdo->query($sql);
$counselors = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Counselors</title>
</head>

<body>

<h1>Counselors</h1>

<p>
    <a href="index.php">Home</a> |
    <a href="add_counselor.php">Add Counselor</a>
</p>

<table cellpadding="6">

<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Actions</th>
</tr>

<?php foreach ($counselors as $counselor): ?>

<tr>

    <td><?= htmlspecialchars($counselor['counselor_id']) ?></td>

    <td><?= htmlspecialchars($counselor['fname']) ?></td>

    <td><?= htmlspecialchars($counselor['lname']) ?></td>

    <td>

        <a href="counselor.php?id=<?= $counselor['counselor_id'] ?>">View</a>

        |

        <a href="edit_counselor.php?id=<?= $counselor['counselor_id'] ?>">Edit</a>

        |

        <a href="delete_counselor.php?id=<?= $counselor['counselor_id'] ?>">Delete</a>

    </td>

</tr>

<?php endforeach; ?>

</table>

</body>

</html>