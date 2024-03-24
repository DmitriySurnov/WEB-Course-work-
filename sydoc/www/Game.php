<?php
require_once "Classes\PlayingField.php";
session_start();

use Classes\IgrovoePole;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Судоку</title>
    <link rel="stylesheet" href="Styles/Game.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script type="module" src="JS/button.js"></script>
</head>
<body>
<H1>Игра Судоку</H1> <br>
<div class="null">
    <?php
    if (count($_POST) > 0) {
        $Field = $_SESSION["IgrovoePole"] ?? new IgrovoePole($_POST["level"]);
    }else
        $Field = $_SESSION["IgrovoePole"] ?? new IgrovoePole(0);
    ?>
</div>

<div ID="gridPole" id="external">
    <?php
    for ($row = 0; $row < 9; $row++) {
        if ($row % 3 == 0 && $row != 0)
            echo("<div class='grid internal indent'>");
        else
            echo("<div class='grid internal'>");
        for ($Column = 0; $Column < 9; $Column++) {
            if ($Column % 3 == 0)
                echo("<div class='gridColumn'>");
            $element = $Field->get_elent($Column, $row);
            if ($element == 0)
                echo("<button value='izmen' class='grid-item' id='$row$Column'> </button>");
            else
                echo("<button class='grid-item' id='$row$Column'> $element </button>");
            if (($Column + 1) % 3 == 0)
                echo('</div>');
        }
        echo('</div>');
    }
    ?>
</div>

<br>
<div ID="buttons">
    <form method="post" action="index.php">
        <button>Новая Игра</button>
    </form>
    <button id="clear">Очистить</button>
</div>
<br>

<div ID="grid">
    <?php
    for ($k = 1; $k < 10; $k++) {
        echo("<div>");
        echo("<button class='grid-item-numbers' id=''> $k </button>");
        echo("</div>");
    }
    ?>
</div>

</body>
</html>
