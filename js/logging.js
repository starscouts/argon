function log(message) {
    console.log('%c[' + new Date().toISOString() + "]%c " + message, 'font-family: monospace; background: rgba(0, 0, 0);', 'opacity: 1;');
}