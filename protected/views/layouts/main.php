<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>发布系统</title>
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css">

        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="/public/js/jqueryui/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="/public/js/notty/jquery.notty.js"></script>
        <script type="text/javascript" src="/public/js/chosen/chosen.jquery.js"></script>

        <link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/public/js/jqueryui/jquery-ui-1.8.17.custom.css" rel="stylesheet"/>
        <link href="/public/js/notty/jquery.notty.css" rel="stylesheet" type="text/css" rel="stylesheet"/>
        <link href="/public/js/chosen/chosen.css" type="text/css" rel="stylesheet"/>
        <style type="text/css">
            body {padding-top: 70px;}
            .help-inline {margin-left: 20px;}
            .sidenav {background: #f7f5fa;}
            .sidenav .active a {border-right: 1px solid #080808;font-weight: bold;color: #080808;}
            #nottys {top: 70px;}
            .nav-pills, .nav-tabs {margin-bottom: 10px;}
        </style>
        <script type="text/javascript">
            (function() {
                function p(type, message) {
                    if (typeof message == 'object') {
                        var tm = '';
                        for (var t in message) {
                            tm = message[t];
                            break;
                        }
                        message = tm;
                    }
                    $.notty({
                        title: type.toUpperCase(),
                        content: message,
                        timeout: 5000,
                        showTime: false
                    });
                }

                Prompt = {
                    info: function(msg) {
                        p('info', msg);
                    },
                    error: function(msg) {
                        p('error', msg);
                    }
                };
            })();

            $(function() {
                $('.buttonset').buttonset();
                $("select.chzn-select").chosen();
            });
        </script>
    </head>
    <body>
        <?php echo $this->renderPartial('/shared/_header') ?>
        <div class="main container">
            <?php echo $content ?>
        </div>
        <footer>

        </footer>
    </body>
</html>