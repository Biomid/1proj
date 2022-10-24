<?php
$host = 'localhost'; // адрес сервера
$database = 'Some_db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

$connect = mysqli_connect($host, $user, $password, $database);

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$kek = '';

$end_questions = array_key_last($data['answers']);

foreach ($data['answers'] as $item_key => $item_value)
{
    $kek .= $item_value;
    if($item_key != $end_questions) {
        $kek .= ' ';
    }
}

mysqli_query($connect, "INSERT INTO first_quiz (age, sex, vopros1, result) VALUES ( {$data['age']}, '{$data['gender']}','{$kek}','{$data['result']}') ");


?>