<?php
$mysqli = new mysqli("localhost", "cech23", "Tis*2653775", "cech23");
if ($mysqli->connect_error) {
    die("Chyba pripojeni: " . $mysqli->connect_error);
}
?>