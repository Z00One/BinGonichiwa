export default class Waiting {
    constructor() {
        this.channel = "";
        this.leaveForm = null;
        this.leaveConfirmMessage = "";
        this.opponentleaveMessage = "";
        this.gameStartMessage = "";
        this.errorMessage = "";
        this.playerCount = 0;
        this.opponentLeave = false;
    }

    start() {
        window.location.pathname = `/games/${this.channel}`;
    }

    leave(isUnload = false) {
        const flag = window.confirm(this.leaveConfirmMessage);

        if (flag || isUnload) {
            window.Echo.leave(this.channel);
            this.leaveForm.submit();
        }
    }

    handleUnload = (event) => {
        event.preventDefault();
        window.Echo.leave(this.channel);
        this.leave(true);
    };

    init(data) {
        this.channel = data.channel;
        this.leaveForm = data.leaveForm;
        this.leaveConfirmMessage = data.leaveConfirmMessage;
        this.opponentleaveMessage = data.opponentleaveMessage;
        this.gameStartMessage = data.gameStartMessage;
        this.errorMessage = data.errorMessage;
        this.playerCount = data.playerCount;

        console.log(`--${this.channel}--`);

        if (!this.channel) {
            window.alert(this.errorMessage);
            window.location.href = "/";
        }

        window.Echo.join(this.channel)
            .leaving((user) => {
                this.opponentLeave = true;
                window.alert(this.opponentleaveMessage);
            })
            .here((users) => {
                if (users.length === this.playerCount) {
                    window.alert(`${this.gameStartMessage}`);
                    this.start();
                }
            })
            .joining((user) => {
                window.alert(this.gameStartMessage);
                this.start();
            })
            .error((error) => {
                window.alert(this.errorMessage);
                window.Echo.leave(this.channelName);
                window.location.href = "/";
            });

        window.addEventListener("beforeunload", this.handleUnload);

        window.addEventListener("unload", this.handleUnload);
    }
}
