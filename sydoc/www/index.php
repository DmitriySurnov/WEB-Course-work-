<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Styles/index.css">
    <title>Судоку</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
<H1>Игра Судоку</H1>
<H2>Выберите уровениь сложности</H2>
<form method="post" action="Game.php">
    <?php
    $buttons = array("Очень Легкий","Легкий","Средний","Сложный","Эксперт");
    for ($i = 0; $i < count($buttons) ; $i++) {
        $element = $buttons[$i];
        echo ("<button name='level' value='$i'> $element </button>");
    }
    ?>
</form>
</body>
</html>