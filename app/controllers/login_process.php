<?php
require_once BASE_PATH . '/app/models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sprawdzanie czy istnieje użytkownik o podanym emailu
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $userModel = new User(require BASE_PATH . '/app/config/database.php');
    $user = $userModel->getUserByEmail($email);

    if ($user) {
        // Sprawdzenie czy hasło pasuje do hasha w bazie danych
        if (password_verify($password, $user['password'])) {
            // Logowanie udane
            echo "Sukces: Zalogowano pomyślnie!";
            // Tutaj możesz przekierować użytkownika na inną stronę po udanym zalogowaniu
        } else {
            // Hasło niepoprawne
            echo "Błąd: Niepoprawne hasło.";
        }
    } else {
        // Użytkownik o podanym emailu nie istnieje
        echo "Błąd: Użytkownik o podanym emailu nie istnieje.";
    }
} else {
    // Jeśli żądanie nie jest typu POST, przekieruj gdzieś indziej lub wyświetl błąd
    echo "Błąd: Nieprawidłowe żądanie.";
}
?>
