<?php
require_once "../Classes\PlayingField.php";
session_start();
if (count($_GET) > 0) {
    $temp = !empty($_GET['id']) ? $_GET['id'] : '';
    $number = !empty($_GET['number']) ? $_GET['number'] : '';
    $len = strlen($temp);
    $lenNumber = strlen($number);
    if ($lenNumber == 1 && ((int)$number) == 0)
        $lenNumber = 0;
    if ($len == 2 && $lenNumber == 1 && isset($_SESSION["IgrovoePole"])) {
        $Column = $temp[1];
        $row = $temp[0];
        $Field = $_SESSION["IgrovoePole"];
        $rezult = $Field->check($Column,$row,$number);
        echo ($rezult?"true":"false");
    }
}