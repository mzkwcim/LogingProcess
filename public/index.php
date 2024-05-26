<?php
define('BASE_PATH', realpath(dirname(__FILE__).'/..'));
require_once BASE_PATH . '/app/controllers/UserController.php';

$userController = new UserController();

// Sprawdzamy, czy użytkownik kliknął link "Zarejestruj się"
if ($_SERVER['REQUEST_URI'] == '/git/register') {
    // Jeśli tak, wykonujemy operacje związane z rejestracją
    $userController->register();
    // Po wykonaniu operacji, przekierowujemy użytkownika do widoku rejestracji
    // I nie wyświetlamy reszty strony
    exit();
}
if ($_SERVER['REQUEST_URI'] == '/git/public/login.php') {
    // Jeśli tak, przekierowujemy użytkownika do formularza logowania
    $userController->redirectToLogin();
    // Po przekierowaniu nie wyświetlamy dalszej zawartości strony
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona główna</title>
</head>
<body>
    <?php if ($_SERVER['REQUEST_URI'] != '/git/register'): ?>
    <h1>Witaj na stronie głównej</h1>
    <p>Wybierz jedną z opcji poniżej:</p>
    <ul>
        <li><a href="/git/register">Zarejestruj się</a></li>
        <li><a href="/git/public/login.php">Zaloguj się</a></li>
    </ul>
    <?php endif; ?>
</body>
</html>
