_argonLoadedHooks.push(function ArgonStartupSeekbar() {
    document.getElementById("player-seekbar").addEventListener('mousedown', () => {
        log("Started seeking");
        ArgonPlayer._seekbar = false;
    });

    document.getElementById("player-seekbar").addEventListener('mouseup', () => {
        log("Stopped seeking");
        ArgonPlayer._player.currentTime = document.getElementById("player-seekbar").value / 1000;
        ArgonPlayer._seekbar = true;
    });

    document.getElementById("player-seekbar").addEventListener('touchstart', () => {
        log("Started seeking");
        ArgonPlayer._seekbar = false;
    });

    document.getElementById("player-seekbar").addEventListener('touchend', () => {
        log("Stopped seeking");
        ArgonPlayer._player.currentTime = document.getElementById("player-seekbar").value / 1000;
        ArgonPlayer._seekbar = true;
    });

    document.getElementById("player-seekbar").addEventListener('touchcancel', () => {
        log("Stopped seeking");
        ArgonPlayer._player.currentTime = document.getElementById("player-seekbar").value / 1000;
        ArgonPlayer._seekbar = true;
    });
})