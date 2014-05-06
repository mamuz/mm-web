/**
 * remove pager for jump to prev page
 * bind jscroll plugin to list container
 */
$(document).ready(function () {
    $('.list').jscroll({
        nextSelector: 'a.next',
        loadingHtml : '',
        callback    : function () {
            $('a.prev').remove()
        }
    });
});
