<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title>
</head>
<body>
<h2>Înregistrare</h2>
<?php if (isset($error)) {
    echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
} ?>
<form method="post" action="/register">
    <label for="nume">Nume:</label>
    <input type="text" id="nume" name="nume" required>
    <br>
    <label for="data_nastere">Data Nastere:</label>
    <input type="date" id="data_nastere" name="data_nastere" required>
    <br>
    <label for="oras">Oraș:</label>
    <input type="text" id="oras" name="oras" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="parola">Parolă:</label>
    <input type="password" id="parola" name="parola" required>
    <br>
    <label for="confirm_parola">Confirmă Parola:</label>
    <input type="password" id="confirm_parola" name="confirm_parola" required>
    <br>
    <button type="submit">Înregistrare</button>
</form>
<p>Deja ai un cont? <a href="login">Autentifică-te aici</a>.</p>
</body>
</html>
