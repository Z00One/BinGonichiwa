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

    start = () => {
        setTimeout(() => {
            window.location.pathname = `/games/${this.channel}`;
        }, 0);
    };

    leave = (isUnload = false) => {
        const flag = window.confirm(this.leaveConfirmMessage);

        if (flag || isUnload) {
            window.Echo.leave(this.channel);
            this.leaveForm.submit();
        }
    };

    handleUnload = (event) => {
        event.preventDefault();
        this.leave(true);
    };

    init = (data) => {
        this.channel = data.channel;
        this.leaveForm = data.leaveForm;
        this.leaveConfirmMessage = data.leaveConfirmMessage;
        this.opponentleaveMessage = data.opponentleaveMessage;
        this.gameStartMessage = data.gameStartMessage;
        this.errorMessage = data.errorMessage;
        this.playerCount = data.playerCount;

        if (!this.channel) {
            window.alert(this.errorMessage);
            window.location.href = "/";
        }

        window.Echo.join(this.channel)
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
    };
}
