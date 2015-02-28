(function (e, c, a, g) {
    var d = "initializer", f = {};

    function b(i, h) {
        this.element = i;
        this.options = e.extend({}, f, h);
        this._defaults = f;
        this._name = d;
        this.init()
    }

    b.prototype = {init: function () {
        this.highlightCode(this.element);
        this.infinitizeList(this.element);
        this.createClipboards(this.element)
    }, highlightCode   : function (i, h) {
        e("pre code", i).each(function (j, k) {
            hljs.highlightBlock(k)
        })
    }, infinitizeList  : function (i, h) {
        if (e("a.next", i).length > 0) {
            e(".scroll-list", i).jscroll({nextSelector: "a.next", loadingHtml: "", callback: function () {
                e("a.prev").remove()
            }})
        }
    }, createClipboards: function (j, i) {
        ZeroClipboard.config({moviePath: c.location.protocol + "//" + c.location.host + "/js/vendor/ZeroClipboard.swf"});
        e("pre code", j).each(function (k) {
            var l = e("<span>").attr({title: "copy to clipboard", "data-clipboard-target": "copy-cnt-" + k}).addClass("clip glyphicon glyphicon-share");
            e(this).attr("id", "copy-cnt-" + k).parent().prepend(l)
        });
        var h = new ZeroClipboard(e(".clip"));
        h.on("complete", function (k, l) {
            e(".clip").removeClass("glyphicon-ok").addClass("glyphicon-share");
            e(this).toggleClass("glyphicon-share glyphicon-ok")
        })
    }};
    e.fn[d] = function (h) {
        return this.each(function () {
            if (!e.data(this, "plugin_" + d)) {
                e.data(this, "plugin_" + d, new b(this, h))
            }
        })
    }
})(jQuery, window, document);
