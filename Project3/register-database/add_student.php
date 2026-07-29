<?php

require_once __DIR__ . '/lib/Database.php';

$pdo = Database::connect();

$sql = "SELECT counselor_id, fname, lname
        FROM counselors
        ORDER BY lname, fname";

$stmt = $pdo->query($sql);
$counselors = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $campus = trim($_POST["campus"]);
    $counselor_id = filter_input(INPUT_POST, "counselor_id", FILTER_VALIDATE_INT);

    if ($fname && $lname && $campus && $counselor_id) {

        $sql = "INSERT INTO students
                (fname, lname, campus, counselor_id)
                VALUES
                (:fname, :lname, :campus, :counselor_id)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":fname", $fname);
        $stmt->bindValue(":lname", $lname);
        $stmt->bindValue(":campus", $campus);
        $stmt->bindValue(":counselor_id", $counselor_id, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: students.php");
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
    <title>Add Student</title>
</head>

<body>

<h1>Add Student</h1>

<p>
    <a href="students.php">Back to Students</a>
</p>

<?php if (isset($error)): ?>

<p class="red">
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
        Campus<br>
        <input type="text" name="campus" required>
    </p>

    <p>
        Counselor<br>

        <select name="counselor_id">

            <?php foreach ($counselors as $counselor): ?>

                <option value="<?= $counselor['counselor_id'] ?>">

                    <?= htmlspecialchars($counselor['fname']) ?>
                    <?= htmlspecialchars($counselor['lname']) ?>

                </option>

            <?php endforeach; ?>

        </select>

    </p>

    <p>
        <input type="submit" value="Add Student">
    </p>

</form>

</body>
</html>