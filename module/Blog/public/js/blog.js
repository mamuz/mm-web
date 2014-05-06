/**
 * remove pager for jump to prev page
 * bind jscroll plugin to list container
 */
$(document).ready(function () {
    $('a.prev').remove();
    $('.list').jscroll({nextSelector: 'a.next', loadingHtml: ''});
});
