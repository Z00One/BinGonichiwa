export default class Game {
    constructor() {
        this.turn = false;
        this.channel = "";
        this.usersBoard = [];
        this.bingoId = "";
        this.button = null;
        this.turnInfo = null;
        this.usersTurnText = "";
        this.opponentsTurnText = "";
        this.boardSize = 0;
        this.notAvailableValuesMessage = "";
        this.notUsersTurnMessage = "";
        this.opponentHasLeftMessage = "";
        this.opponentNotParticipatedMessage = "";
        this.opponent = "";
        this.errorMessage = "";
        this.areOpponent = false;
        this.submitedValues = [];
        this.mappingValue = "*";
        this.timer = null;
        this.timeOut = 11;
        this.countdown = this.timeOut;
        this.countdownElement = null;
    }

    startTimer() {
        this.countdown = this.timeOut;
        this.timer = setInterval(() => this.countDown(), 1100);
    }

    countDown() {
        if (this.countdown > 1) {
            this.countdown--;
            this.countdownElement.innerText = this.countdown;
            // this.countdownElement.innerText = `Time Left: ${this.countdown}`;
        } else {
            this.button.disabled = true;
            this.submit(true);
            this.countdown = this.timeOut;
            clearInterval(this.timer);
        }
    }

    setTurn(button) {
        this.turn = !this.turn;
        button.disabled = !this.turn;

        this.turnInfo.innerText = this.turn
            ? this.usersTurnText
            : this.opponentsTurnText;

        if (this.turn) {
            this.countdownElement.style.opacity = 1;
            this.countdown = this.timeOut; // 카운트다운 리셋
            this.startTimer(); // 타이머 시작
        } else {
            this.countdownElement.style.opacity = 0.1;
            this.countdownElement.innerText = "";
            clearInterval(this.timer); // 타이머 정지
            this.timer = null;
        }
    }

    isMyTurn() {
        if (!this.turn) {
            window.alert(this.notUsersTurnMessage);
        }
        return this.turn;
    }

    isVailableValue(value) {
        const boardSize = this.boardSize ** 2; // 이 값은 예시이므로 실제 설정값으로 변경해야 합니다.
        const isAvailable = value && value >= 1 && value <= boardSize;
        return isAvailable;
    }

    setValue(value = "none") {
        const inputValue = document.querySelector("#inputValue");

        if (value === "none") {
            inputValue.value = "";
            return;
        } else if (!this.isVailableValue(value)) {
            window.alert(this.notAvailableValuesMessage);
            inputValue.value = "";
            return;
        }

        inputValue.value = value;
    }

    getValue() {
        const inputValue = Number(document.querySelector("#inputValue").value);
        return inputValue;
    }

    leave(isUnload = false) {
        const areOpponent = window.confirm(this.leaveConfirmMessage);

        if (areOpponent || isUnload) {
            window.Echo.leave(this.channelName);
        }
    }

    getRandomNumber() {
        let randomNumber = Math.floor(Math.random() * this.boardSize ** 2) + 1;

        console.log(`randomNumber: ${randomNumber}`);

        return randomNumber;
    }

    async submit(isTimeOut = false) {
        clearInterval(this.timer);
        const value = isTimeOut ? this.getRandomNumber() : this.getValue();

        if (!isTimeOut && !this.isMyTurn()) {
            return;
        }

        if (!this.isVailableValue(value)) {
            window.alert(this.notAvailableValuesMessage);
            return;
        }

        const isSubmitedValue = this.submitedValues.includes(value);

        if (isSubmitedValue) {
            console.log("isSubmitedValue");
            // 판 돌리기
        }

        try {
            await window.axios.post(`/games/bingos/${this.channel}`, {
                bingoId: this.bingoId,
                value: value,
            });

            // value 가 이미 제출된 값이면 '벌칙' 출력
        } catch (error) {
            console.error(error);
            window.Echo.leave(this.channelName);
            window.alert(this.errorMessage);
            return;
        }

        this.countdown = this.timeOut; // 카운트다운 리셋
        if (this.turn) {
            this.startTimer(); // 타이머 시작
        }
    }

    handleUnload = (event) => {
        event.preventDefault();
        window.Echo.leave(this.channelName);
        this.leave(true);
    };

    mapping(value) {
        // 행
        for (let row = 0; row < this.usersBoard.length; row++) {
            // 열
            for (let col = 0; col < this.usersBoard[row].length; col++) {
                if (this.usersBoard[row][col] == value) {
                    this.usersBoard[row][col] = this.mappingValue;
                }
            }
        }
    }

    isBingo() {
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
        if (slash == this.boardSize || backslash == this.boardSize) {
            return true;
        }

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
            if (colBingo === this.boardSize || rowBingo === this.boardSize) {
                return true;
            }
        }
    }

    handleSubmit = (event) => {
        const value = event["submitValue"];

        if (!this.isVailableValue(value)) {
            return;
        }

        if (!this.submitedValues.includes(value)) {
            this.submitedValues.push(value);
        }

        const block = document.querySelectorAll(`.block${value}`);

        for (let i = 0; i < block.length; i++) {
            block[i].classList.add("bg-myGreen");
        }

        this.mapping(value);
        const isBingo = this.isBingo();

        if (isBingo) {
            console.log("bingo");
        }
        this.setValue();
        this.setTurn(this.button);
    };

    /**
     * Initializes the game with the provided data.
     *
     * @param {object} data - The data object containing the game information.
     */
    init(data) {
        this.channel = data.channel;
        this.usersBoard = data.usersBoard;
        this.bingoId = data.bingoId;
        this.turn = data.turn;
        this.button = data.button;
        this.turnInfo = data.turnInfo;
        this.usersTurnText = data.usersTurnText;
        this.opponentsTurnText = data.opponentsTurnText;
        this.boardSize = data.boardSize;
        this.notAvailableValuesMessage = data.notAvailableValuesMessage;
        this.notUsersTurnMessage = data.notUsersTurnMessage;
        this.opponentHasLeftMessage = data.opponentHasLeftMessage;
        this.opponentNotParticipatedMessage =
            data.opponentNotParticipatedMessage;
        this.errorMessage = data.errorMessage;
        this.submitedValues = [];
        this.countdownElement = data.countdownElement;

        console.log(`--${this.channel}--`);

        if (!this.channel) {
            window.alert(this.errorMessage);
            window.location.href = "/";
        }

        window.Echo.join(this.channel)
            .here((users) => {
                if (users.length === 2) {
                    this.areOpponent = true;
                }
            })
            .joining((user) => {
                this.areOpponent = true;
            })
            .leaving((user) => {
                window.alert(this.opponentHasLeftMessage);
            })
            .listen("BingoValueSubmitEvent", this.handleSubmit)
            .error((error) => {
                console.error(error);
                window.alert(this.errorMessage);
                window.location.href = "/";
            });

        // 2명인지 아닌지 5 초뒤에 areOpponent 로 확인하고 아닐 경우 승리로 제출
        setTimeout(() => {
            if (!this.areOpponent) {
                window.alert(this.opponentHasLeftMessage);
            }
        }, this.timeOut);

        window.addEventListener("beforeunload", this.handleUnload);

        window.addEventListener("unload", this.handleUnload);
    }
}
