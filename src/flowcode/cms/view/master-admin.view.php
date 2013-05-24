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
        <link rel="stylesheet" href="/css/jquery.toastmessage.css" type="text/css" media="screen" />
        <script src="/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
        <script src="/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-dropdown.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-affix.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-tooltip.js" type="text/javascript" ></script>
        <script src="/js/bootstrap-modal.js" type="text/javascript" ></script>
        <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/js/icrop.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>
        <script src="/js/jquery.toastmessage.js" type="text/javascript" ></script>
        <script type="text/javascript" src="/js/jquery.flowhistory.js"></script>
        <script type="text/javascript" src="/js/admin.js"></script>
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
                                                <li><a href="#!adminBlog/tags">Tags</a></li>
                                                <li><a href="#!adminBlog/index">Posts</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#!adminPage/pages">Pages</a></li>
                                        <li><a href="#!adminMenu/index">Menus</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown" id="menu-settings">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-settings">
                                        Settings
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#!adminConfig/index">System</a></li>
                                        <li class="dropdown-submenu">
                                            <a href="#" tabindex="-1">Users</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#!adminPermission/index">Permissions</a></li>
                                                <li><a href="#!adminRole/index">Roles</a></li>
                                                <li><a href="#!adminUser/index">Users</a></li>
                                            </ul>
                                        </li>
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
            <img class="history-spin" src="/images/ajax-loader.gif">
        </div>
        <div class="modal hide fade" id="dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3></h3>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="modal-save">Save changes</a>
                <a class="btn" data-dismiss="modal">Close</a>
            </div>
        </div>
    </body>
</html>