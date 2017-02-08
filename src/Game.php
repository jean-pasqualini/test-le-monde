<?php

/**
 * Class Game
 */
class Game
{
    const STATE_DEAD    = 0;
    const STATE_LIFE    = 1;

    /** @var array */
    protected $board;
    protected $nextBoard;

    /** @var bool */
    protected $initialized = false;

    /**
     * @return bool return true if game is initialized with board
     */
    protected function isInitialized()
    {
        return $this->initialized;
    }

    /**
     * initialize
     *
     * @param array $board the board game
     */
    public function initialize(array $board)
    {
        $this->board = $board;
        $this->initialized = true;

        return true;
    }

    /**
     * Update the board with logic game in 1 round
     * @exception \Exception\NotInitializedGameException
     */
    public function update()
    {
        if (!$this->initialized) {
            throw new \Exception\NotInitializedGameException();
        }

        $this->nextBoard = $this->board;
        $boardLines = $this->board;

        foreach($boardLines as $numLine => $boardLine)
        {
            foreach($boardLine as $numColumn => $celluleItem)
            {
                $this->nextBoard[$numLine][$numColumn] = $this->getNextStateForCellule($numLine, $numColumn);
            }
        }

        $this->board = $this->nextBoard;
    }

    protected function getStateCellule($y, $x)
    {
        $minX = 0;
        $maxX = count($this->board[0]) - 1;
        $minY = 0;
        $maxY = count($this->board) - 1;

        if ($x < $minX || $x > $maxX) {
            return 'empty';
        }
        if ($y < $minY || $y > $maxY) {
            return 'empty';
        }

        return $this->board[$y][$x];
    }

    protected function getNextStateForCellule($numLine, $numColumn)
    {
        $currentState = $this->getStateCellule($numLine, $numColumn);

        $scope = array(
            'topLeft'       => $this->getStateCellule($numLine - 1, $numColumn - 1),
            'topMiddle'     => $this->getStateCellule($numLine - 1, $numColumn),
            'rightMiddle'   => $this->getStateCellule($numLine - 1, $numColumn + 1),

            'middleLeft'    => $this->getStateCellule($numLine,     $numColumn - 1),
            'middleRight'   => $this->getStateCellule($numLine,     $numColumn + 1),

            'bottomLeft'    => $this->getStateCellule($numLine + 1, $numColumn - 1),
            'bottomMiddle'  => $this->getStateCellule($numLine + 1, $numColumn),
            'bottomRight'   => $this->getStateCellule($numLine + 1, $numColumn + 1),
        );

        // Stats count occur for each states
        $statsValues = array_replace(array(
            self::STATE_DEAD => 0,
            self::STATE_LIFE => 0,
        ), array_count_values($scope));

        $countCelluleLife = $statsValues[self::STATE_LIFE];

        // WHen one dead cellule as 3 lifes, the cellule give life
        if (3 === $countCelluleLife)
        {
            if (self::STATE_DEAD === $currentState) {
                return self::STATE_LIFE;
            } else {
                return $currentState;
            }
        }

        // When one dead cellule as 2 lifes, the cellule give same state
        if (2 === $countCelluleLife)
        {
            return $currentState;
        }

        // When one cellule as less of 2 or more of 3 life, the cellule is dead
        if ($countCelluleLife < 2 || $countCelluleLife > 3) {
            return self::STATE_DEAD;
        }
    }

    /**
     * @return array the board
     */
    public function getBoard()
    {
        return $this->board;
    }
}