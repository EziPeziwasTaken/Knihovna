<?php
session_start();
require 'connect.php';
if ($_SESSION['role'] !== 'admin') die("Přístup zakázán");
$id = $_GET['id'];
$zanry = $mysqli->query("SELECT * FROM zanry");
$kniha = $mysqli->query("SELECT * FROM knihy WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nazev = $_POST['nazev'];
    $autor = $_POST['autor'];
    $zanr_id = $_POST['zanr_id'];
    $rok = $_POST['rok'];
    $stmt = $mysqli->prepare("UPDATE knihy SET nazev=?, autor=?, zanr_id=?, rok_vydani=? WHERE id=?");
    $stmt->bind_param("ssiii", $nazev, $autor, $zanr_id, $rok, $id);
    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Online knihovna</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form method="POST">
    <input type="text" name="nazev" value="<?= htmlspecialchars($kniha['nazev']) ?>" required>
    <input type="text" name="autor" value="<?= htmlspecialchars($kniha['autor']) ?>" required>
    <select name="zanr_id">
        <?php while ($zanr = $zanry->fetch_assoc()): ?>
        <option value="<?= $zanr['id'] ?>" <?= $zanr['id'] == $kniha['zanr_id'] ? 'selected' : '' ?>><?= htmlspecialchars($zanr['nazev']) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="rok" value="<?= $kniha['rok_vydani'] ?>" required>
    <button type="submit">Uložit změny</button>
</form>
</body>
</html>