<?php

require_once __DIR__ . '/lib/Database.php';

$pdo = Database::connect();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid counselor ID.");
}

$sql = "SELECT *
        FROM counselors
        WHERE counselor_id = :id";

$cnmt = $pdo->prepare($sql);
$cnmt->bindValue(":id", $id, PDO::PARAM_INT);
$cnmt->execute();

$counselor = $cnmt->fetch();

if (!$counselor) {
    exit("Counselor not found.");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);

    if ($fname && $lname) {

        $sql = "UPDATE counselors
                SET
                    fname = :fname,
                    lname = :lname
                WHERE counselor_id = :id";

        $cnmt = $pdo->prepare($sql);

        $cnmt->bindValue(":fname", $fname);
        $cnmt->bindValue(":lname", $lname);
        $cnmt->bindValue(":id", $id, PDO::PARAM_INT);

        $cnmt->execute();

        header("Location: counselors.php");
        exit;
    }

    $error = "Please complete all fields.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Add Counselor</title>
</head>

<body>

<h1>Edit Counselor</h1>

<p>
    <a href="counselors.php">Back to Counselors</a>
</p>

<?php if (isset($error)): ?>

<p class="red">
    <?= htmlspecialchars($error) ?>
</p>

<?php endif; ?>

<form method="post">

    <p>
        First Name<br>
        <input
            type="text"
            name="fname"
            value="<?= htmlspecialchars($counselor['fname']) ?>"
            required>
    </p>

    <p>
        Last Name<br>
        <input
            type="text"
            name="lname"
            value="<?= htmlspecialchars($counselor['lname']) ?>"
            required>

    <p>
        <input type="submit" value="Update Counselor">
    </p>

</form>

</body>
</html>