<?php

// Check selected board is available
$selectedBoard = $_GET['board'];
$boards = require __DIR__.'/../cache/board.php';
if (!in_array($selectedBoard, $boards)) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

// Run game
require __DIR__.'/../vendor/autoload.php';

$session = new \Symfony\Component\HttpFoundation\Session\Session(
    new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage()
);
$session->start();

$gameStorageKey = 'game_'.$selectedBoard;

if ($session->has($gameStorageKey)) {
    /** @var \GameRunner\WebGameRunner $gameRunner */
    $gameRunner = $session->get($gameStorageKey);

    $gameRunner->run();
} else {
    $boardLoader = new \BoardLoader\FileLoader();
    $board = $boardLoader->load(__DIR__.'/../board/'.$selectedBoard.'.board');

    $game       = new \Game();
    $screen     = new \Screen\ImageScreen();
    $gameRunner = new \GameRunner\WebGameRunner($game, $screen);
    $gameRunner->setBoard($board);

    $gameRunner->run();

    $session->set($gameStorageKey, $gameRunner);
}