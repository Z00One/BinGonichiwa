export default class Bingo {
    constructor() {
        this.usersBoard = [];
        this.bingoId = "";
        this.boardSize = 0;
        this.mappingValue = "";
        this.standardOfBingo = 0;
    }

    init = (data) => {
        this.mappingValue = "*";
        this.usersBoard = data.usersBoard;
        this.bingoId = data.bingoId;
        this.boardSize = data.boardSize;
        this.standardOfBingo = 3;
    };

    mapping = (value) => {
        // 행
        for (let row = 0; row < this.usersBoard.length; row++) {
            // 열
            for (let col = 0; col < this.usersBoard[row].length; col++) {
                if (this.usersBoard[row][col] == value) {
                    this.usersBoard[row][col] = this.mappingValue;
                }
            }
        }
    };

    isBingo = () => {
        let allBingo = 0;
        // 대각선
        let backslash = 0;
        let slash = 0;

        for (let i = 0; i < this.usersBoard.length; i++) {
            backslash += this.usersBoard[i][i] == this.mappingValue ? 1 : 0;
            slash +=
                this.usersBoard[i][this.usersBoard.length - 1 - i] ===
                this.mappingValue
                    ? 1
                    : 0;
        }

        // 빙고 발생
        if (slash == this.boardSize) allBingo++;
        if (backslash == this.boardSize) allBingo++;

        // 가로, 세로
        for (let row = 0; row < this.usersBoard.length; row++) {
            let colBingo = 0;
            let rowBingo = 0;

            for (let col = 0; col < this.usersBoard[row].length; col++) {
                colBingo +=
                    this.usersBoard[col][row] === this.mappingValue ? 1 : 0;
                rowBingo +=
                    this.usersBoard[row][col] === this.mappingValue ? 1 : 0;
            }

            // 빙고 발생
            if (colBingo === this.boardSize) allBingo++;
            if (rowBingo === this.boardSize) allBingo++;
        }

        return allBingo >= this.standardOfBingo ? true : false;
    };

    getRandomNumber = () => {
        const randomNumber =
            Math.floor(Math.random() * this.boardSize ** 2) + 1;

        return randomNumber;
    };
}
