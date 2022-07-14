<?php
//Лабораторная работа №7. Использование PDO + MySQL в PHP-приложении (2 часа).
//Цель: получить практические навыки работы с СУБД MySQL с использованием PDO.
//Теоретическая часть:
//https://phoenixnap.com/kb/how-to-create-new-mysql-user-account-grant-privileges
//https://www.php.net/manual/ru/ref.pdo-mysql.php
//https://www.php.net/manual/ru/pdo.connections.php
//Постановка задачи: Реализовать простое приложение PHP с использованием шаблонизатора
// twig и организации работы с базой данных MySQL с помощью PDO.
//Порядок выполнения:
//Анализ задачи.
//Исследование источников.
//Сконфигурировать подключение к БД.
//Реализовать функционал добавления записей в БД.
//Реализовать функционал отображения списка добавленных записей.
//Форма отчета: репозиторий на GitHub с php-приложением, работоспособное приложение доступное по сети,
// в котором в качестве шаблонизатора используется twig, а для взаимодействия с БД используется PDO.
//
// ***********************************************************************************************************************
//
//Лабораторная работа №8. Реализация паттерна Active Record (2 часа).
//Цель: получить практические навыки реализации DAL (Data Access Layer) через паттерн Active Record.
//Теоретическая часть:
//Постановка задачи: Реализовать простое приложение PHP с доступом в одну из таблиц БД через паттерн Active Record.
//Порядок выполнения:
//Анализ задачи.
//Исследование источников.
//С помощью паттерна Active Record реализовать функционал над одной таблицей БД по:
//а). получению всех записей
//б). получению записи по id
//в). получению записей по значению поля из таблицы (фильтрация по полю)
//г). сохранению записи
//д). удалению записи
//Форма отчета: репозиторий на GitHub с php-приложением, работоспособное приложение доступное по сети, в котором в качестве DAL используется паттерн Active Record.
//


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);




require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);
require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'Data.php']);




try {
    $dbh = new PDO('mysql:host=localhost;dbname=lab1', 'phplab1', 'phplab1');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

$type = null;
$id = null;
$message = null;
$res = null;
$d = null;

if (isset($_GET)) {
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }

    if ($type == 'search') {
        $d = new Data($dbh);
        $d->id = $id;
        $d->message = $message;
        $res = $d->find();
    }
    if ($type == 'insert') {
        $d = new Data($dbh);
        $d->id = $id;
        $d->message = $message;
        $d->save();
    }
    if ($type == 'delete') {
        $d = new Data($dbh);
        $d->id = $id;
        $d->message = $message;
        $d->delete();
    }
}
if (!$d) {
    $d = new Data($dbh);
    $res = $d->find();
}


$loader = new \Twig\Loader\FilesystemLoader(join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'templates']));
$twig = new \Twig\Environment($loader);

$template = $twig->load('index.html.twig');

echo $template->render(['data' => $res]);







