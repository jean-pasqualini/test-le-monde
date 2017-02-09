<?php

require __DIR__.'/../vendor/autoload.php';

$session = new \Symfony\Component\HttpFoundation\Session\Session(
    new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage()
);
$session->invalidate();

header('Location: /game.php');
exit();