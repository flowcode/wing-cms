<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" type="image/png" href="/images/flowcode-fav.png" />
        <title><? echo ucfirst($viewData['page']->getName()) . " | " . \flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?></title>
        <meta name="description" content="<? echo $viewData['page']->getDescription() ?>" />

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
                <p class="powered">Powered by <span class="logo-small">Wing</span></p>
            </div>
        </div>

    </body>
</html>