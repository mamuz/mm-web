;
(function ($, window, document, undefined) {

    var pluginName = "initializer",
        defaults = {};

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function () {
            this.highlightCode(this.element);
            this.infinitizeList(this.element);
            this.createClipboards(this.element);
        },

        highlightCode: function (el, options) {
            $('pre code', el).each(function (i, e) {
                hljs.highlightBlock(e)
            });
        },

        infinitizeList: function (el, options) {
            $('.scroll-list', el).jscroll({
                nextSelector: 'a.next',
                loadingHtml : '',
                callback    : function () {
                    $('a.prev').remove()
                }
            });
        },

        createClipboards: function (el, options) {
            ZeroClipboard.config({
                moviePath: window.location.protocol + '//' + window.location.host + '/js/vendor/ZeroClipboard.swf'
            });
            $("pre code", el).each(function (index) {
                var icon = $('<span>').attr({
                    title                  : "copy to clipboard",
                    "data-clipboard-target": "copy-cnt-" + index
                }).addClass('clip glyphicon glyphicon-share');
                $(this).attr('id', 'copy-cnt-' + index).parent().prepend(icon);
            });
            var client = new ZeroClipboard($(".clip"));
            client.on('complete', function (client, args) {
                $('.clip').removeClass("glyphicon-ok").addClass('glyphicon-share');
                $(this).toggleClass("glyphicon-share glyphicon-ok");
            });
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
