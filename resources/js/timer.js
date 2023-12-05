export default class Timer {
    constructor() {
        this.timer = null;
        this.timeOut = 11;
        this.countdown = this.timeOut;
        this.countdownElement = null;
        this.timerElement = null;
        this.submit = null;
        this.button = null;
    }

    init = (data, submit, button) => {
        this.timer = null;
        this.timeOut = 11;
        this.countdown = this.timeOut;
        this.countdownElement = data.countdownElement;
        this.timerElement = data.timerElement;
        this.submit = submit;
        this.button = button;
    };

    startTimer = () => {
        this.countdown = this.timeOut;
        this.timer = setInterval(() => this.countDown(), 1000);
    };

    countDown = () => {
        if (this.countdown >= 1) {
            this.countdown--;
            this.countdownElement.innerText = this.countdown;
        } else {
            this.button.disabled = true;
            clearInterval(this.timer);
            this.submit(true);
            this.countdown = this.timeOut;
        }
    };

    setTurn = (turn) => {
        if (turn) {
            this.timerElement.style.opacity = 1;
            this.countdown = this.timeOut;
            this.startTimer();
        } else {
            this.timerElement.style.opacity = 0.01;
            this.countdownElement.innerText = "";
            clearInterval(this.timer);
            this.timer = null;
        }
    };
}
