<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><? echo flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?> - Admin Panel</title>
        <meta NAME="robots" CONTENT="noindex, nofollow" />
        <link rel="icon" type="image/png" href="/images/flowcode-fav.png" />
        <link rel="stylesheet" href="/css/admin.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/overcast/jquery-ui-1.8.18.custom.css" type="text/css" media="screen" />
        <script src="/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script src="/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-dropdown.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-affix.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-tooltip.js" type="text/javascript" ></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.dropdown-toggle').dropdown();
                $('#main-menu-fix').affix();
            });
        </script>
    </head>

    <body>
        <!--          Aca va el contenido del header  -->
        <div id="header">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand">
                            <? echo flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?>
                        </a>
                        <?php if (isset($_SESSION['user']['username'])): ?>
                            <ul class="nav">
                                <li><a href="/admin"><i class="icon-home icon-white"></i></a></li>
                                <li class="dropdown" id="menu-content">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-content">
                                        Content
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" tabindex="-1">Blog</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/adminBlog/tags">Tags</a></li>
                                                <li><a href="/adminBlog/index">Posts</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="/adminPage/pages">Pages</a></li>
                                        <li><a href="/adminMenu/index">Menus</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-settings">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-settings">
                                        Settings
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminConfig/index">System</a></li>
                                        <li><a href="/adminUsuario/lista">users</a></li>
                                    </ul>
                                </li>

                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown" id="menu1">
                                    <a class="dropdown-toggle brand" data-toggle="dropdown" href="#menu1">
                                        <i class="icon-user icon-white"></i> <?php echo $_SESSION['user']['username'] ?>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Perfil</a></li>
                                        <li><a href="#">Preferencias</a></li>
                                        <li class="divider"></li>
                                        <li><a href="/adminLogin/logout">Salir</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php else: ?>
                            <ul class="nav nav-pills">
                                <li class="active"><a href="/">Volver al portal</a></li>
                            </ul>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido  -->
        <div id="content" class="container">
            <?php echo $content ?>
        </div>

    </body>
</html>