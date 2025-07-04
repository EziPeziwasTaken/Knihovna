<?php
session_start();
require 'connect.php';
$hledat = $_GET['hledat'] ?? '';
$tridit = $_GET['tridit'] ?? 'nazev';

$sql = "SELECT knihy.*, zanry.nazev AS zanr FROM knihy JOIN zanry ON knihy.zanr_id = zanry.id
        WHERE knihy.nazev LIKE ? OR autor LIKE ? ORDER BY $tridit";
$stmt = $mysqli->prepare($sql);
$like = "%$hledat%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$vysledek = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Online knihovna</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form method="GET">
    <input type="text" name="hledat" placeholder="Hledat knihu nebo autora">
    <select name="tridit">
        <option value="nazev">Název</option>
        <option value="rok_vydani">Rok vydání</option>
        <option value="zanr">Zanr</option>
        <option value="autor">Autor</option>
    </select>
    <button type="submit">Filtrovat</button>
</form>
<table>
<tr><th>Název</th><th>Autor</th><th>Žánr</th><th>Rok</th><?php if ($_SESSION['role'] === 'admin') echo '<th>Akce</th>'; ?></tr>
<?php while ($radek = $vysledek->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($radek['nazev']) ?></td>
    <td><?= htmlspecialchars($radek['autor']) ?></td>
    <td><?= htmlspecialchars($radek['zanr']) ?></td>
    <td><?= $radek['rok_vydani'] ?></td>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <td>
            <a href="upravit.php?id=<?= $radek['id'] ?>">Upravit</a>
            <a href="smazat.php?id=<?= $radek['id'] ?>" onclick="return confirm('Opravdu smazat?');">Smazat</a>
        </td>
    <?php endif; ?>
</tr>
<?php endwhile; ?>
</table>

<a href="logout.php">Odhlásit</a>
&nbsp;
<?php if ($_SESSION['role'] === 'admin') echo '<a href="admin.php">Admin panel</a>'; ?>

</body>
</html>

