document.addEventListener("DOMContentLoaded", () => {
    const updateWinningRate = () => {
        const waveBefore = document.querySelector(".wave_before");
        const waveAfter = document.querySelector(".wave_after");
        const winningRate = document
            .querySelector("#winning_rate")
            .getAttribute("data-winning-rate");
        const TOP = -100;

        if (waveBefore) {
            const topValue = TOP - winningRate;
            waveBefore.style.top = `${topValue}%`;
        }

        if (waveAfter) {
            const topValue = TOP - winningRate;
            waveAfter.style.top = `${topValue}%`;
        }
    };

    updateWinningRate();
});
