<?php
session_start();
require 'connect.php';

if ($_SESSION['role'] !== 'admin') die("Přístup zakázán");
$id = $_GET['id'];
$mysqli->query("DELETE FROM knihy WHERE id = $id");
header("Location: index.php");
exit();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Online knihovna</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
</body>
</html>