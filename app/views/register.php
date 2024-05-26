<?php
// Załaduj kontroler użytkownika
require_once BASE_PATH . '/app/controllers/UserController.php';
$userController = new UserController();

// Pobierz listę miast
$cities = $userController->getCities();
?>

<form action="" method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" name="username" id="username" autofocus><br><br>

    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password"><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email"><br><br>

    <!-- miasto -->
    <?php
        $cities = (new UserController)->getCities();
        //print_r($cities);
    ?>
    <label for="city">Miasto:</label>
    <select name="city" id="city">
        <?php
            foreach ($cities as $city):
                echo "<option value=\"$city[id]\">".htmlspecialchars($city['name'])."</option>";
            endforeach;
        ?>
    </select><br><br>

    <label for="birthday">Data urodzenia:</label>
    <input type="date" name="birthday" id="birthday"><br><br>

    <input type="submit" value="Zarejestruj się">
</form>