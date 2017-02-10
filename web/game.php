<?php

$selectedBoard = $_GET['board'];
$boards = require __DIR__.'/../cache/board.php';

if (!in_array($selectedBoard, $boards)) {
    header('HTTP/1.1 404 Not Found');
    exit();
}
?>
<html>
    <head>
        <meta http-equiv="refresh" content="1"/>
    </head>
    <body>
        <img src="/screen.php?board=<?php echo $selectedBoard; ?>" />
        <a href="/reset.php">Reset game</a>
    </body>
</html>