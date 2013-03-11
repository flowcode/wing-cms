<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" type="image/png" href="/images/pic-perfil.jpg" />
        <title><? echo ucfirst($viewData['page']->getName()) . " | " . \flowcode\smooth\mvc\Config::getByModule("front", "site", "name") ?></title>
        <meta name="description" content="<? echo $viewData['page']->getDescription() ?>" />

        <link rel="stylesheet" href="/css/global.css" type="text/css" media="screen" />
        <script src="/js/global.js" type="text/javascript" ></script>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29511419-1']);
            _gaq.push(['_setDomainName', 'juanmaaguero.com.ar']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>

    <body>
        <!--          Aca va el contenido del header  -->
        <div id="header">
            <div class="container">
                <div id="blogTitle">
                    <span>JuanMa Blog</span>
                </div>
                <div id="main-menu">
                    <ul>
                        <li>
                            <a href="/" id="home">Home</a>
                        </li>
                        <?php $menu = \flowcode\cms\controller\MenuController::getMenu("1"); ?>
                        <?php $items = $menu->getItems(); ?>
                        <?php foreach ($items as $item): ?>
                            <li>
                                <?php if ($item->getPage() != NULL): ?>
                                    <a href="/<?php echo $item->getUrl() ?>"><?php echo $item->getName() ?></a>
                                <?php else: ?>
                                    <?php if ($item->getLinkUrl() != ""): ?>
                                        <a href="<?php echo $item->getLinkUrl(); ?>" target="_blank" ><?php echo $item->getName(); ?></a>
                                    <?php else: ?>
                                        <a><?php echo $item->getName(); ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
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
                <p class="powered">Powered by <span class="logo-small">Smooth</span></p>
            </div>
        </div>

    </body>
</html>