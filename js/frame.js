_argonLoadedHooks.push(function ArgonStartupFrame() {
    try {
        log("Processing initial hash");
        original = location.hash.substring(1);
        document.getElementById("frame-inner").src = "/_frame" + original;
    } catch (e) {
        console.error(e);
        location.hash = "";
    }

    window.addEventListener('hashchange', () => {
        log("Processing hash change");
        try {
            original = location.hash.substring(1);
            document.getElementById("frame-inner").src = "/_frame" + original;
        } catch (e) {
            console.error(e);
        }
    });

    document.getElementById("frame-inner").addEventListener('load', () => {
        log("Changing hash as per iframe URL");
        location.hash = document.getElementById("frame-inner").contentDocument.location.href.split(location.host)[1].substring(7);
    })
})