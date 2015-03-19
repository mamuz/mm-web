(function () {
    var shr = document.createElement('script');
    shr.setAttribute('data-cfasync', 'false');
    shr.src = '//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js';
    shr.type = 'text/javascript';
    shr.async = 'true';
    shr.onload = shr.onreadystatechange = function () {
        var rs = this.readyState;
        if (rs && rs != 'complete' && rs != 'loaded') {
            return;
        }
        var site_id = 'eab66ace7c9b9709fa3702e7826a8b48';
        try {
            Shareaholic.init(site_id);
        } catch (e) {
        }
    };
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(shr, s);
})();
