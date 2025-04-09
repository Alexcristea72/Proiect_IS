<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Autentificare</title>
</head>
<body>
<h2>Login</h2>
<?php if (isset($error)) {
    echo '<p style="color:red;">'
        . htmlspecialchars($error) . '</p>'; } ?>
<form method="post" action="/login">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Parolă:</label>
    <input type="password" id="parola" name="parola" required>
    <br>
    <button type="submit">Autentificare</button>
</form>
<p>Nu ai un cont? <a href="register">Înregistrează-te aici</a>.</p>
</body>
</html>
