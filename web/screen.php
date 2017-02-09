<?php

require __DIR__.'/../vendor/autoload.php';


$session = new \Symfony\Component\HttpFoundation\Session\Session(
    new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage()
);
$session->start();

if ($session->has('game')) {
    /** @var \GameRunner\WebGameRunner $gameRunner */
    $gameRunner = $session->get('game');

    $gameRunner->run();
} else {
    $boardLoader = new \BoardLoader\FileLoader();
    $board = $boardLoader->load(__DIR__.'/../board/standard.board');

    $game       = new \Game();
    $screen     = new \Screen\ImageScreen();
    $gameRunner = new \GameRunner\WebGameRunner($game, $screen);
    $gameRunner->setBoard($board);

    $gameRunner->run();

    $session->set('game', $gameRunner);
}