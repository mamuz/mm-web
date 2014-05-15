$(document).ready(function () {
    $('pre code').each(function (i, e) {
        hljs.highlightBlock(e)
    });
    $('.list').jscroll({
        nextSelector: 'a.next',
        loadingHtml : '',
        callback    : function () {
            $('a.prev').remove()
        }
    });
});
