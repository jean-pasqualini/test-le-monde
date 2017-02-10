<?php

if (!file_exists(__DIR__.'/../cache/board.php')) {
    // Retreive board available
    $boards = array_map(
        function($filePath) { return basename($filePath, '.board'); },
        glob(__DIR__.'/../board/*.board')
    );

    file_put_contents(__DIR__.'/../cache/board.php', '<?php return '.var_export($boards, true).';');
}

$boards = require __DIR__.'/../cache/board.php';

?>

<ul>
    <?php foreach ($boards as $board) { ?>
        <li><a href="/game.php?board=<?php echo $board; ?>"><?php echo $board; ?></a></li>
    <?php } ?>
</ul>
