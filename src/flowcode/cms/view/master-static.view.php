<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" type="image/png" href="/images/flowcode-fav.png" />
        <title>Error</title>

        <link rel="stylesheet" href="/css/global.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/bootstrap-front/bootstrap.min.css" type="text/css" media="screen" />
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/global.js" type="text/javascript" ></script>
    </head>

    <body>
        <!--          Aca va el contenido del header  -->
        <div id="header">
            <div class="container">
                <div id="blogTitle">
                    <span>Wing CMS</span>
                </div>
                <div id="main-menu">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenido  -->
        <div id="content">
            <?php echo $content ?>
        </div>

        <!--                  Aca va el contenido del footer  -->
        <div id="footer" class="footer">
            <div class="container">
                <p class="powered">Powered by <span class="logo-small">Wing</span></p>
            </div>
        </div>

    </body>
</html>