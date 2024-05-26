<?php
class User {
    private $db;

    public function __construct($dbConfig) {
        try {
            $this->db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['db_name']);
        } catch(Exception $e) {
            die("Błędne połączenie z bazą danych: " . $e->getMessage());
        }
    }

    public function create($username, $city_id, $password, $email, $birthday) {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $stmt = $this->db->prepare("INSERT INTO users (username, city_id, password, email, birthday) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $username, $city_id, $hashedPassword, $email, $birthday); 
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>
