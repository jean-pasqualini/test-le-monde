<?php
namespace BoardLoader;


class FileLoader
{
    protected function getStateByCharacter($character)
    {
        switch ($character) {
            case '↟':
                return \Game::STATE_LIFE;
                break;
            case '░':
                return \Game::STATE_DEAD;
                break;
        }

        return -1;
    }

    public function load($file)
    {
        $board = array();

        $lines = file($file);
        foreach ($lines as $y => $line) {

            $line = trim($line);

            $board[$y] = array();

            $characters = preg_split('/(?!^)(?=.)/u', $line);
            foreach($characters as $x => $character) {
                $board[$y][$x] = $this->getStateByCharacter($character);
            }
        }

        return $board;
    }
}