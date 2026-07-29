<?php

require_once __DIR__ . '/lib/Database.php';

$pdo = Database::connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);

    if ($fname && $lname) {

        $sql = "INSERT INTO counselors
                (fname, lname)
                VALUES
                (:fname, :lname)";

        $cnmt = $pdo->prepare($sql);

        $cnmt->bindValue(":fname", $fname);
        $cnmt->bindValue(":lname", $lname);

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

<h1>Add Counselor</h1>

<p>
    <a href="students.php">Back to Counselors</a>
</p>

<?php if (isset($error)): ?>

<p class="red"">
    <?= htmlspecialchars($error) ?>
</p>

<?php endif; ?>

<form method="post">

    <p>
        First Name<br>
        <input type="text" name="fname" required>
    </p>

    <p>
        Last Name<br>
        <input type="text" name="lname" required>
    </p>

    <p>
        <input type="submit" value="Add Counselor">
    </p>

</form>

</body>
</html>