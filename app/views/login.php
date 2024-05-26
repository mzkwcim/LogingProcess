<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <form action="/git/app/controllers/UserController.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="hidden" name="action" value="login"> <!-- Dodajemy pole ukryte z wartością "login" -->

        <input type="submit" value="Zaloguj się">
    </form>
</body>
</html>
