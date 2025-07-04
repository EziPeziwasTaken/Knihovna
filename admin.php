<?php
session_start();
if ($_SESSION['role'] !== 'admin') die("Přístup zakázán");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Online knihovna</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<a href="pridat.php">Přidat knihu</a>
<a href="index.php">Zpět na seznam knih</a>
<body>
</html>