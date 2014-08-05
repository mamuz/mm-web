$(document).ready(function () {

    // code highlight
    $('pre code').each(function (i, e) {
        hljs.highlightBlock(e)
    });

    // infinite list
    $('.scroll-list').jscroll({
        nextSelector: 'a.next',
        loadingHtml : '',
        callback    : function () {
            $('a.prev').remove()
        }
    });

    // dynamic sidebar
    if (!$.trim($('#sidebar').html())) {
        $('#sidebar').append('<ul class="nav sidenav hidden-print"></ul>');
        $("#main-content h2").each(function (index) {
            $(this).attr('id', 'section-' + index);
            $(".sidenav").append(
                '<li><a href="#section-' + index + '">' + $(this).html() + '</a></li>'
            );
        });
    }
    $('body').scrollspy({target: '#sidebar'});

    // copy&paste plugin
    ZeroClipboard.config({moviePath: window.location.protocol + '//' + window.location.host + '/js/vendor/ZeroClipboard.swf'});
    $("pre code").each(function (index) {
        $(this).attr('id', 'copy-cnt-' + index).parent().prepend(
            '<span title="copy to clipboard" data-clipboard-target="copy-cnt-' + index + '" class="clip glyphicon glyphicon-share"></span>'
        );
    });
    var client = new ZeroClipboard($(".clip"));
    client.on('complete', function (client, args) {
        $('.clip').removeClass("glyphicon-ok").addClass('glyphicon-share');
        $(this).toggleClass("glyphicon-share glyphicon-ok");
    });
});
