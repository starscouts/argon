_argonLoadedHooks.push(function ArgonStartupNavigation() {
    ArgonNavigation = {
        home: () => {
            document.getElementById("frame-inner").contentWindow.location.href = "/_frame/home";
        },
        library: () => {
            document.getElementById("frame-inner").contentWindow.location.href = "/_frame/library";
        },
        lyrics: () => {
            document.getElementById("frame-inner").contentWindow.location.href = "/_frame/lyrics";
        },
        settings: () => {
            document.getElementById("frame-inner").contentWindow.location.href = "/_frame/settings";
        },
        about: () => {
            document.getElementById("frame-inner").contentWindow.location.href = "/_frame/about";
        },
    }

    setInterval(() => {
        path = document.getElementById("frame-inner").contentWindow.location.pathname.substring(7);

        document.getElementById("navigation-home-icon").src = "/icons/home-off.svg";
        document.getElementById("navigation-library-icon").src = "/icons/library-off.svg";
        document.getElementById("navigation-lyrics-icon").src = "/icons/lyrics-off.svg";
        document.getElementById("navigation-settings-icon").src = "/icons/settings-off.svg";
        document.getElementById("navigation-about-icon").style.filter = "";

        if (path.startsWith("/home")) {
            document.getElementById("navigation-home-icon").src = "/icons/home-on.svg";
        } else if (path.startsWith("/library")) {
            document.getElementById("navigation-library-icon").src = "/icons/library-on.svg";
        } else if (path.startsWith("/lyrics")) {
            document.getElementById("navigation-lyrics-icon").src = "/icons/lyrics-on.svg";
        } else if (path.startsWith("/settings")) {
            document.getElementById("navigation-settings-icon").src = "/icons/settings-on.svg";
        } else if (path.startsWith("/about")) {
            document.getElementById("navigation-about-icon").style.filter = "brightness(200%)";
        }
    })
})