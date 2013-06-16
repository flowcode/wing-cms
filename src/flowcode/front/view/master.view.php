<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" type="image/png" href="/images/flowcode-fav.png" />
        <? if (isset($viewData['page']) && strlen($viewData['page']->getName()) > 0): ?>
            <title><? echo ucfirst($viewData['page']->getName() . " | ") . \flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?></title>
        <? else: ?>
            <title><? echo ucfirst(\flowcode\wing\mvc\Config::getByModule("front", "site", "name")) ?></title>
        <? endif; ?>
        <? if (isset($viewData['page']) && strlen($viewData['page']->getDescription()) > 0): ?>
            <meta name="description" content="<? echo $viewData['page']->getDescription() ?>" />
        <? endif; ?>

        <link rel="stylesheet" href="/css/global.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" media="screen" />
        <script src="/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-dropdown.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-affix.js" type="text/javascript" ></script>
        <script src="/js/global.js" type="text/javascript" ></script>
    </head>

    <body>
        <!--          Aca va el contenido del header  -->
        <div id="header">
            <div class="container">
                <div id="blogTitle">
                    <span><h1>Wing CMS</h1></span>
                </div>
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <ul class="nav">
                                <?php $menu = \flowcode\cms\controller\MenuController::getMenu("1"); ?>
                                <?php $items = $menu->getMainItems(); ?>
                                <?php foreach ($items as $item): ?>
                                    <? if ($item->getSubItems()->count() > 0): ?>
                                        <li class="dropdown" id="menu-<?php echo $item->getId(); ?>">
                                            <?php if ($item->getLinkUrl() != ""): ?>
                                                <a class="dropdown-toggle" href="<?php echo $item->getLinkUrl(); ?>" ><?php echo $item->getName(); ?></a>
                                            <?php else: ?>
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-<?php echo $item->getId(); ?>">
                                                    <?php echo $item->getName(); ?>
                                                    <b class="caret"></b>
                                                </a>
                                            <?php endif; ?>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($item->getSubItems() as $subitem): ?>
                                                    <li>
                                                        <?php if ($subitem->getPage() != NULL): ?>
                                                            <a href="/<?php echo $subitem->getUrl() ?>"><?php echo $subitem->getName() ?></a>
                                                        <?php else: ?>
                                                            <?php if ($subitem->getLinkUrl() != ""): ?>
                                                                <a href="<?php echo $subitem->getLinkUrl(); ?>" ><?php echo $subitem->getName(); ?></a>
                                                            <?php else: ?>
                                                                <a><?php echo $subitem->getName(); ?></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>

                                    <? else: ?>
                                        <li>
                                            <a href="<?php echo $item->getLinkUrl(); ?>" ><?php echo $item->getName(); ?></a>
                                        </li>
                                    <? endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
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