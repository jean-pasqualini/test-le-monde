<?php

/**
 * Created by PhpStorm.
 * User: aurore
 * Date: 09/02/2017
 * Time: 18:10
 */
class GameRunner
{
    protected $game;
    protected $screen;
    protected $board;

    public function __construct(Game $game, \Screen\ScreenInterface $screen)
    {
        $this->game = $game;
        $this->screen = $screen;
    }

    protected function showGame(GameView $gameView)
    {
        $gameView->show();
    }

    public function run(array $board, $loop = 1, $clean = true, $sleep = 1)
    {
        $this->game->initialize($board);
        $gameView = new GameView($this->game, $this->screen);

        if ($clean) {
            $gameView->clean();
        }

        for ($loopIteration = 1; $loopIteration <= $loop; $loopIteration++) {
            $gameView->update();
            $this->showGame($gameView);
            if ($sleep) {
                sleep(1);
            }

            if ($clean) {
                $gameView->clean();
            }
        }
    }
}