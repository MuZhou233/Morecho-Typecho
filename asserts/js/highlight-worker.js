onmessage = (event) => {
    importScripts('../lib/highlight/highlight.min.js');
    const result = self.hljs.highlightAuto(event.data[1]);
    postMessage([event.data[0],result.value]);
};