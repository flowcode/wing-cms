<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><? echo flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?> - Admin Panel</title>
        <meta NAME="robots" CONTENT="noindex, nofollow" />
        <link rel="icon" type="image/png" href="/images/flowcode-fav.png" />
        <link rel="stylesheet" href="/css/admin.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/bootstrap-admin/bootstrap.min.css" type="text/css" media="screen" />
        <script src="/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script src="/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-dropdown.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-affix.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-tooltip.js" type="text/javascript" ></script>
        <script type="text/javascript">
            $(document).ready(function(){
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
                            Panel de Control
                        </a>
                        <?php if (isset($_SESSION['user']['username'])): ?>
                            <ul class="nav">
                                <li>
                                    <a href="/admin"><i class="icon-home icon-white"></i></a>
                                </li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown" id="menu-blog">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-blog">
                                        Blog
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminBlog/tags">Tags</a></li>
                                        <li><a href="/adminBlog/index">Posts</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-pages">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-pages">
                                        Paginas
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminPage/pages">Paginas</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-menues">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-menues">
                                        Menus
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminMenu/index">Administrar</a></li>
                                    </ul>
                                </li>

                            </ul>
                            <ul class="nav pull-right">
                                <li class="dropdown" id="menu1">
                                    <a class="dropdown-toggle brand" data-toggle="dropdown" href="#menu1">
                                        <?php echo $_SESSION['user']['username'] ?>
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
        <div id="content" class="container-fluid">
            <div class="row-fluid">
                <!-- Menu principal  -->
                <div class="span2">
                    <div id="main-menu-fix" class="well sidebar" data-offset-top="100" style="width: 110px;">
                        <ul class="nav nav-list">
                            <li class="nav-header">Configuracion</li>
                            <li><a href="/adminConfig/index">Administrar</a></li>
                            <li class="divider"></li>
                        </ul>
                        <ul class="nav nav-list">
                            <li class="nav-header">Usuarios</li>
                            <li><a href="/adminUsuario/lista">Administrar</a></li>
                            <li class="divider"></li>
                        </ul>
                    </div>
                </div>
                <div class="span9">
                    <?php echo $content ?>
                </div>
            </div>
        </div>

    </body>
</html>