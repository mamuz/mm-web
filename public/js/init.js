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
    $("#main-content h2").each(function (index) {
        $(this).attr('id', 'section-' + index);
        $("#affix-nav").append(
            '<li><a href="#section-' + index + '">' + $(this).html() + '</a></li>'
        );
    });
    $("#affix-nav").affix();
    $('body').scrollspy({target: '#sidebar'});
});
