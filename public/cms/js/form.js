document.addEventListener('DOMContentLoaded', function(){
    var css_code = document.getElementById('css_code');

    var myCodeMirror = CodeMirror.fromTextArea(css_code, {
        mode: 'css',
        lineNumbers : true,
        matchBrackets : true,
        tabMode: "indent"
    });
});