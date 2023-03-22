<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include('form.php');
    include('modal.php');

    if (!empty($_GET['save'])) {
        echo "<script>modal('Спасибо, результаты сохранены!')</script>";
    }
    exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
    echo "<script>modal('Заполните имя!')</script>";
    $errors = TRUE;
}

if (empty($_POST['email'])) {
    echo "<script>modal('Заполните email!')</script>";
    $errors = TRUE;
}

if (empty($_POST['checkbox']) || !($_POST['checkbox'] == 'on' || $_POST['checkbox'] == 1)) {
    echo "<script>modal('Подтвердите checkbox!')</script>";
    $errors = TRUE;
}

if (empty($_POST['abilities'])) {
    echo "<script>modal('Выберите способности!')</script>";
    $errors = TRUE;
}

if (empty($_POST['limbs']) || !is_numeric($_POST['limbs']) || !preg_match('/^\d+$/', $_POST['limbs'])) {
    echo "<script>modal('Все так плохо?')</script>";
    $errors = TRUE;
}

if (empty($_POST['gender'])) {
    echo "<script>modal('Вы кто?')</script>";
    $errors = TRUE;
}

if (empty($_POST['year'])) {
    echo "<script>modal('Заполните дату рождения!')</script>";
    $errors = TRUE;
}


if ($errors) {
    exit();
}

$user = 'u52803';
$pass = '9294062';
$db = new PDO('mysql:host=localhost;dbname=u52803', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.
try {
    $stmt = $db->prepare("INSERT INTO users SET name = ?, year = ?, biography = ?, email = ?, limbs = ?, gender = ?, checkbox = ?");
    $stmt->execute([$_POST['fio'], $_POST['year'], $_POST['biography'], $_POST['email'], $_POST['limbs'], $_POST['gender'], 1]);
    if (!$stmt) {
        print('Error : ' . $stmt->errorInfo());
    }
} catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

$user_id = $db->lastInsertId();

foreach ($_POST['abilities'] as $ability_id) {
    try {
        $stmt = $db->prepare("INSERT INTO relations SET user_id = ?, ability_id = ?");
        $stmt->execute([$user_id, $ability_id]);
        if (!$stmt) {
            print('Error : ' . $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}
//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);

//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
header('Location: ?save=1');