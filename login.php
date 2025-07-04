<?php
session_start();
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $heslo = $_POST['heslo'];
    $stmt = $mysqli->prepare("SELECT id, heslo, role FROM uzivatele WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();
        if (password_verify($heslo, $hashed_password)) {
            $_SESSION['uzivatel_id'] = $id;
            $_SESSION['role'] = $role;
            header("Location: index.php");
            exit();
        }
    }
    $chyba = "Špatné jméno nebo heslo";
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
<div style="background-color: #fff3cd; border: 1px solid #ffeeba; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
    <strong>Účty pro přihlášení:</strong><br>
    <ul>
        <li><strong>Admin</strong> - uživatelské jméno: <u>admin</u>, heslo: <u>admin123</u></li>
        <li><strong>Uživatel</strong> - uživatelské jméno: <u>user</u>, heslo: <u>user123</u></li>
    </ul>
</div>
<form method="POST">
    <input type="text" name="username" placeholder="Uživatelské jméno" required>
    <input type="password" name="heslo" placeholder="Heslo" required>
    <button type="submit">Přihlásit se</button>
</form>
</body>
</html>
<?php if (isset($chyba)) echo "<p>$chyba</p>"; ?>
