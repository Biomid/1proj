<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$host = 'localhost'; // адрес сервера
$database = ''; // имя базы данных
$user = ''; // имя пользователя
$password = ''; // пароль

$connect = mysqli_connect($host, $user, $password, $database);

$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load("dataFile.xlsx");


if (!$connect){
    die('Error connect to database');
}

$data = mysqli_query($connect, "SELECT * FROM `first_quiz` ORDER BY `id`");


$countStartRow = 4;
$currentContentRow =4;
while($item = mysqli_fetch_array($data)){
    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1, 1);

    $spreadsheet->getActiveSheet()
        ->setCellValue('A'.$currentContentRow, $item['id'])
        ->setCellValue('B'.$currentContentRow, $item['age'])
        ->setCellValue('C'.$currentContentRow, $item['sex']);

    $questions_results = explode(" ", $item['vopros1']);
    //echo($questions_results);
    $spreadsheet->getActiveSheet()->fromArray($questions_results, NULL, 'D'.$currentContentRow);

    $spreadsheet->getActiveSheet()->setCellValue('N'.$currentContentRow, $item['result']);

    if(count($questions_results) == 10)
    {
        $spreadsheet->getActiveSheet()->setCellValue('O'.$currentContentRow, "да");
    }
    else
    {
        $spreadsheet->getActiveSheet()->setCellValue('O'.$currentContentRow, "нет");
    }

    $currentContentRow++;
}


$spreadsheet->getActiveSheet()->removeRow($currentContentRow,2);


$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
?>