export default class Game {
    constructor() {
        this.state = null;
        this.bingoInstance = null;
        this.timerInstance = null;
    }

    setTurn = (button) => {
        this.state.turn = !this.state.turn;
        button.disabled = !this.state.turn;

        this.state.turnInfo.innerText = this.turn
            ? this.state.usersTurnText
            : this.state.opponentsTurnText;

        this.timerInstance.setTurn(this.state.turn);
    };

    isMyTurn = () => {
        if (!this.state.turn) {
            window.alert(this.notUsersTurnMessage);
        }
        return this.state.turn;
    };

    isVailableValue = (value) => {
        const boardSize = this.bingoInstance.boardSize ** 2;
        const isAvailable = value && value >= 1 && value <= boardSize;
        return isAvailable;
    };

    setValue = (value = "none") => {
        if (value === "none") {
            this.state.inputValue.value = "";
            return;
        } else if (!this.isVailableValue(value)) {
            window.alert(this.state.notAvailableValuesMessage);
            this.state.inputValue.value = "";
            return;
        }

        inputValue.value = value;
    };

    submit = (isTimeOut = false) => {
        clearInterval(this.timerInstance.timer);

        const value = isTimeOut
            ? this.bingoInstance.getRandomNumber()
            : this.state.inputValue.value;

        if (!isTimeOut && !this.isMyTurn()) {
            return;
        }

        if (!this.isVailableValue(value)) {
            window.alert(this.state.notAvailableValuesMessage);
            return;
        }

        const isSubmitedValue = this.state.submitedValues.includes(value);

        if (isSubmitedValue) {
            console.log("isSubmitedValue");
            // 판 돌리기
        }

        try {
            window.axios.post(`/games/bingos/${this.state.channel}`, {
                bingoId: this.bingoInstance.bingoId,
                value: value,
            });
        } catch (error) {
            console.error(error);
            window.alert(this.state.errorMessage);
            return;
        }

        this.timerInstance.countdown = this.timerInstance.timeOut;

        if (this.state.turn) {
            this.timerInstance.startTimer();
        }
    };

    handleBingoValueSubmit = (event) => {
        const value = event["submitValue"];

        if (!this.state.submitedValues.includes(value)) {
            this.state.submitedValues.push(value);
        }

        const block = document.querySelectorAll(`.block${value}`);

        for (let i = 0; i < block.length; i++) {
            block[i].classList.add("bg-myGreen");
        }

        this.bingoInstance.mapping(value);

        if (this.bingoInstance.isBingo()) {
            this.state.bingoSubmitButton.disabled = false;
            this.state.bingoSubmitButton.classList.remove("hidden");
        }

        this.setValue();
        this.setTurn(this.state.button);
    };

    bingoSubmit = () => {
        try {
            window.axios.post(`/games/${this.state.channel}`);
        } catch (error) {
            console.log(error);
            window.alert(this.state.errorMessage);
            return;
        }
    };

    handleBingoSubmit = (event) => {
        const { winnerId } = event;

        if (this.state.userId === winnerId) {
            window.alert(this.state.winMessage);
        } else {
            window.alert(this.state.loseMessage);
        }

        this.state.areOpponent = false;

        window.location.href = "/";
    };

    init = (data) => {
        this.state = data.state;

        this.bingoInstance = window.Bingo;
        this.bingoInstance.init(data.bingoState);

        this.timerInstance = window.Timer;
        this.timerInstance.init(
            data.timerState,
            this.submit,
            this.state.button
        );

        window.Echo.channel(this.state.bingoChannel).listen(
            "BingoSubmitEvent",
            this.handleBingoSubmit
        );

        window.Echo.join(this.state.channel)
            .here((users) => {
                if (users.length === 2) {
                    this.state.areOpponent = true;
                }
            })
            .joining((user) => {
                this.state.areOpponent = true;
            })
            .leaving((user) => {
                if (this.state.areOpponent) {
                    window.alert(this.state.opponentHasLeftMessage);
                    this.state.areOpponent = false;
                    this.bingoSubmit();
                }
            })
            .listen("BingoValueSubmitEvent", this.handleBingoValueSubmit)
            .error((error) => {
                window.alert(this.state.errorMessage);
                window.location.href = "/";
            });

        // 2명인지 아닌지 10 초뒤에 areOpponent 로 확인하고 아닐 경우 승리로 제출
        setTimeout(() => {
            if (!this.state.areOpponent) {
                window.alert(this.state.opponentHasLeftMessage);
                this.bingoSubmit();
            }
        }, this.timerInstance.timeOut * 1000);

        this.state.button.disabled = !this.state.turn;

        if (this.state.turn) {
            this.timerInstance.startTimer();
        } else {
            this.timerInstance.timerElement.style.opacity = 0.01;
        }
    };
}
