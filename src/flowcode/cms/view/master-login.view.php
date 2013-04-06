<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><? echo flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?> - Admin Panel</title>
        <link rel="stylesheet" href="/css/admin.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/overcast/jquery-ui-1.8.18.custom.css" type="text/css" />
        <script src="/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script src="/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript" ></script>
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

    <body style="background-image: url('/images/bg-login.jpeg'); background-size: cover;">
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
                                    <a href="/admin">Home</a>
                                </li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown" id="menu-noticias">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-noticias">
                                        Noticias
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminCategoria/listaNoticia"> Administrar Categorias</a></li>
                                        <li><a href="/adminNoticia/index">Administrar Noticias</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-penias">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-penias">
                                        Penias
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminBarrio/index"> Administrar Barrios</a></li>
                                        <li><a href="/adminPenia/index">Administrar Penias</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-galerias">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-galerias">
                                        Multimedia
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminCategoria/listaGaleria">Administrar Categorías</a></li>
                                        <li><a href="/adminGaleria/listaDeFotos">Administrar Galerias de Fotos</a></li>
                                        <li><a href="/adminGaleria/listaDeVideos">Administrar Galerias de Videos</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-zona">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-zona">
                                        Zona peñista
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminCiberFlyer">Admin Ciber Flyers</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-visit">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-visit">
                                        Libro de visitas
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/adminVisit/index">Administrar mensajes</a></li>
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
                                        <li><a href="/adminLogin/salir">Salir</a></li>
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