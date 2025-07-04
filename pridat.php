<?php
session_start();
require 'connect.php';
if ($_SESSION['role'] !== 'admin') die("Přístup zakázán");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nazev = $_POST['nazev'];
    $autor = $_POST['autor'];
    $zanr_id = $_POST['zanr_id'];
    $rok = $_POST['rok'];
    $stmt = $mysqli->prepare("INSERT INTO knihy (nazev, autor, zanr_id, rok_vydani) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nazev, $autor, $zanr_id, $rok);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}
$zanry = $mysqli->query("SELECT * FROM zanry");
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
    <input type="text" name="nazev" placeholder="Název" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <select name="zanr_id">
        <?php while ($zanr = $zanry->fetch_assoc()): ?>
        <option value="<?= $zanr['id'] ?>"><?= htmlspecialchars($zanr['nazev']) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="rok" placeholder="Rok vydání" required>
    <button type="submit">Přidat</button>
</form>
</body>
</html>