(function($) {
    $.fn.flowhistory = function(params) {
        var hashPattern = "#!";
        var containerId = "content";
        var controllerHistory = true;
        var controllerDefault = "adminDashboard";
        var fileextension = ".html";
        var methods = {
            init: function() {
                $(window).bind("hashchange", function(e) {
                    methods.handleUrl(document.URL);
                });
                methods.handleUrl(document.URL);
            },
            reload: function() {
                methods.handleUrl(document.URL);
            },
            handleUrl: function(urlstr) {
                methods.refresh();
                if (controllerHistory) {
                    var controllerUrl = methods.parseUrl(urlstr);
                    if (controllerUrl != null) {
                        methods.dispatchToController(controllerUrl);
                    } else {
                        methods.dispatchToController(controllerDefault);
                    }
                } else {
                    var filename = methods.parseFile(urlstr);
                    if (filename === null) {
                        filename = "inicio";
                    }
                    methods.loadFile(filename);
                }

            },
            parseUrl: function(urlstr) {
                var patternIndex = urlstr.indexOf(hashPattern);
                if (patternIndex > -1) {
                    var from = urlstr.indexOf(hashPattern) + hashPattern.length;
                    var controllerName = urlstr.substring(from, urlstr.length);
                    var urlBase = urlstr.substring(0, (from - hashPattern.length)).slice(0, -5);
                    return (urlBase + controllerName);
                } else {
                    return null;
                }
            },
            parseFile: function(urlstr) {
                var patternIndex = urlstr.indexOf(hashPattern);
                if (patternIndex > -1) {
                    var from = patternIndex + hashPattern.length;
                    var filename = urlstr.substring(from, urlstr.length);
                    return filename;
                } else {
                    return null;
                }
            },
            dispatchToController: function(controllerUrl) {
                $.ajax({
                    url: controllerUrl,
                    dataType: "html",
                    success: function(htmlPage) {
                        $("#" + containerId).html(htmlPage);
                    },
                    error: function(a, b, c) {
                        console.log(a);
                    }
                });
            },
            loadFile: function(filename) {
                $('#' + containerId).load(filename + fileextension);
            },
            refresh: function() {
                $('#' + containerId).empty();
                $('#' + containerId).append('<img class="history-spin" src="/images/ajax-loader.gif">');
            }
        };
        methods.init();
    };
})(jQuery);