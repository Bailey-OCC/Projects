<?php

require_once __DIR__ . '/lib/Database.php';

$pdo = Database::connect();

// Validate the counselor ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid counselor ID.");
}

// Retrieve the counselor
$sql = "SELECT *
        FROM counselors
        WHERE counselor_id = :id";

$cnmt = $pdo->prepare($sql);
$cnmt->bindValue(":id", $id, PDO::PARAM_INT);
$cnmt->execute();

$counselor = $cnmt->fetch();

if (!$counselor) {
    exit("counselor not found.");
}

// If the confirmation form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "DELETE FROM counselors
            WHERE counselor_id = :id";

    $cnmt = $pdo->prepare($sql);
    $cnmt->bindValue(":id", $id, PDO::PARAM_INT);
    $cnmt->execute();

    header("Location: counselors.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Delete Counselor</title>
</head>

<body>

<h1>Delete Counselor</h1>

<p>
    Are you sure you want to delete
    <strong>
        <?= htmlspecialchars($counselor['fname']) ?>
        <?= htmlspecialchars($counselor['lname']) ?>
    </strong>?
</p>

<form method="post">

    <input type="submit" value="Delete counselor">

</form>

<p>
    <a href="counselors.php">Cancel</a>
</p>

</body>

</html>