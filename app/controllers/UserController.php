<?php
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/City.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(require BASE_PATH . '/app/config/database.php');
    }

    public function register() {
        $errors = [];
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['username'] = htmlspecialchars(trim($_POST['username']));
            $data['password'] = htmlspecialchars(trim($_POST['password']));
            $data['email'] = htmlspecialchars(trim($_POST['email']));
            $data['city'] = htmlspecialchars(trim($_POST['city']));
            $data['birthday'] = htmlspecialchars(trim($_POST['birthday']));

            if (empty($data['username']) || !preg_match('/^[a-zA-Z0-9]{5,}$/', $data['username'])) {
                $errors['username'] = 'Nazwa użytkownika jest nieprawidłowa';
            }

            if (empty($data['password']) || strlen($data['password']) < 8) {
                $errors['password'] = 'Hasło nie spełnia wymagań';
            }

            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email jest nieprawidłowy';
            }

            if (empty($errors)) {
                $options = [
                    'memory_cost' => 1<<17, // 128 MB
                    'time_cost' => 4,       // 4 iteracje
                    'threads' => 2          // Równoległość
                ];
                $hashedPassword = password_hash($data['password'], PASSWORD_ARGON2ID, $options);
                $this->userModel->create($data['username'], $data['city'], $hashedPassword, $data['email'], $data['birthday']);
                
                // Przekierowanie po udanej rejestracji
                header("Location: /git/app/views/registration_success.php");
                exit();
            }
        }

        require_once BASE_PATH . '/app/views/register.php';
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
    
            // Pobieramy dane użytkownika na podstawie adresu email
            $user = $this->userModel->getUserByEmail($email);
    
            if ($user) {
                // Użytkownik istnieje, sprawdzamy hasło
                $hashedPassword = $user['password'];
                
                // Haszujemy podane hasło za pomocą Argon2id
                $options = [
                    'memory_cost' => 1<<17, // 128 MB
                    'time_cost' => 4,       // 4 iteracje
                    'threads' => 2          // Równoległość
                ];
                $hashedInputPassword = password_hash($password, PASSWORD_ARGON2ID, $options);
    
                // Porównujemy hasha hasła przesłanego przez formularz z hasłem zapisanym w bazie danych
                if (password_verify($hashedInputPassword, $hashedPassword)) {
                    // Hasło poprawne, użytkownik zalogowany
                    // Tutaj możemy przekierować użytkownika do strony powitalnej
                    header("Location: /git/app/views/welcome.php");
                    exit();
                } else {
                    // Nieprawidłowe hasło
                    $error = 'Nieprawidłowy adres email lub hasło.';
                }
            } else {
                // Użytkownik nie istnieje
                $error = 'Nieprawidłowy adres email lub hasło.';
            }
        }
    
        // W przypadku GET lub błędnych danych wyświetlamy formularz logowania
        require_once BASE_PATH . '/app/views/login.php';
    }
    public function redirectToLogin() {
        header("Location: /git/app/views/login.php");
        exit();
    }

    public function getCities() {
        $cityModel = new City(require BASE_PATH . '/app/config/database.php');
        $cities = [];
        $result = $cityModel->getCities();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cities[] = $row;
            }
        }
        return $cities;
    }
}
?>
