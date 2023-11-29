<?php

namespace App\Services;

class BingoService
{
	private $size;

    public function getBingoBoardSize()
    {
        $size = config('broadcast.game.boardSize', 5);

		$this->size = $size;
    }

    public function createBingoBoards()
    {
		$this->getBingoBoardSize();

        $board1 = $this->shuffleArray();
        $board2 = $this->shuffleArray();
		
        while (!$this->areArraysDifferent($board1, $board2)) {
			$board1 = $this->shuffleArray();
			$board2 = $this->shuffleArray();
        };

		return [
			$this->convertToBingo($board1),
			$this->convertToBingo($board2)
        ];
    }

    private function shuffleArray()
    {
		$SIZE = $this->size;
		
		$numbers = range(1, $SIZE * $SIZE);
		shuffle($numbers);

		return $numbers;
    }

    private function areArraysDifferent($arr1, $arr2)
    {
		$SIZE = $this->size;

    	for ($i = 0; $i < $SIZE * $SIZE; $i++) {
			if ($arr1[$i] !== $arr2[$i]) {
				return true;
			}
		}
	
		return false;
    }

    private function convertToBingo($array)
    {
		$SIZE = $this->size;

		$bingoBoard = [];

		for ($row = 0; $row < $SIZE; $row++) {
			$bingoBoard[$row] = array_slice($array, $row * $SIZE, $SIZE);
		}

		return $bingoBoard;
    }
}
