<?php

namespace App\Services;

class BingoService
{
	private $size;

    /**
     * Retrieves the size of the bingo board.
     *
     * @return void
     */
    public function getBingoBoardSize()
    {
        $size = config('broadcast.game.boardSize', 5);

		$this->size = $size;
    }

    /**
     * Generate the function comment for the createBingoBoards function.
     *
     * This function creates two bingo boards by shuffling an array and converting it to bingo format.
     * @return array An array containing two bingo boards
     */
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

    /**
     * Shuffles an array of numbers and returns the shuffled array.
     *
     * @return array The shuffled array of numbers.
     */
    private function shuffleArray()
    {
		$SIZE = $this->size;
		
		$numbers = range(1, $SIZE * $SIZE);
		shuffle($numbers);

		return $numbers;
    }

    /**
     * Check if two arrays are different.
     *
     * @param array $arr1 The first array to compare.
     * @param array $arr2 The second array to compare.
     * @return bool Returns true if the arrays are different, false otherwise.
     */
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

    /**
     * Converts a given array into a bingo board.
     *
     * @param array $array The input array to be converted.
     * @return array The converted two dimensional array.
     */
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
