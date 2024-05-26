onmessage = (event) => {
    importScripts('../lib/highlight/highlight.min.js');
    if(event.data[2] == 'auto')
        result = self.hljs.highlightAuto(event.data[1]);
    else try{
        result = self.hljs.highlight(event.data[2], event.data[1]);
    }catch(e){
        result = self.hljs.highlightAuto(event.data[1]);
    }
    postMessage([event.data[0],result.value]);
};