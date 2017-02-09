<?php

class GameView
{
    protected $game;
    protected $screen;

    public function __construct(Game $game, \Screen\ScreenInterface $screen)
    {
        $this->game = $game;
        $this->screen = $screen;

        $this->screen->initialize($this->game->getBoardSize(), $this->game->getBoardSize());
    }

    public function transformItemStateToCharacter($itemState)
    {
        switch($itemState)
        {
            case Game::STATE_LIFE:
                return '↟';
                break;
            case Game::STATE_DEAD:
                return '░';
                break;
        }

        return '_';
    }

    public function update()
    {
        $this->game->update();

        $board = $this->game->getBoard();
        $boardLines = $board;

        foreach($boardLines as $numLine => $boardLine)
        {
            foreach($boardLine as $numColumn => $celluleItem)
            {
                $this->screen->putPixel($numColumn, $numLine, $this->transformItemStateToCharacter($celluleItem));
            }
        }
    }

    public function show()
    {
        $this->screen->show();
    }

    public function clean()
    {
        $this->screen->clean();
    }
}