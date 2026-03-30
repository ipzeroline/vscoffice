<?php header('Content-type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en-th">
<head>
    <meta charset="utf-8">
    <title>Vessuwan Construction (1984) PaySlip</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- The styles -->
    <link id="bs-css" href="../template/css/bootstrap-cerulean.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    <link type="image/ico" rel="shortcut icon" href="../template/img/favicon.ico">
    <link href="../template/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../template/css/charisma-app.css" rel="stylesheet">
    <link href="../template/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href='../template/css/fullcalendar.css' rel='stylesheet'>
    <link href='../template/css/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='../template/css/chosen.css' rel='stylesheet'>
    <link href='../template/css/uniform.default.css' rel='stylesheet'>
    <link href='../template/css/colorbox.css' rel='stylesheet'>
    <link href='../template/css/jquery.cleditor.css' rel='stylesheet'>
    <link href='../template/css/jquery.noty.css' rel='stylesheet'>
    <link href='../template/css/noty_theme_default.css' rel='stylesheet'>
    <link href='../template/css/elfinder.min.css' rel='stylesheet'>
    <link href='../template/css/elfinder.theme.css' rel='stylesheet'>
    <link href='../template/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='../template/css/opa-icons.css' rel='stylesheet'>
    <!-- jQuery -->
    <script src="../template/js/jquery-1.7.2.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse"
                   data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand"><?php echo WEB_PROJECT; ?></span>

                <!-- theme selector starts -->
                <div class="btn-group pull-right theme-container">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-tint"></i><span class="hidden-phone"> Change Theme / Skin</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" id="themes">
                        <li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
                        <li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
                        <li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
                        <li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
                        <li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
                        <li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
                        <li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
                        <li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
                        <li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
                    </ul>
                </div>
                <!-- theme selector ends -->

                <!-- user dropdown starts -->
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-user"></i><span
                                class="hidden-phone"><?php echo $_SESSION['LOGIN']['USER']; ?></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="divider"></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </ul>
                </div>
                <!-- user dropdown ends -->

                <!--<div class="top-nav nav-collapse">
                    <ul class="nav">
                        <li><a href="#">Visit Site</a></li>
                        <li></li>
                    </ul>
                </div>--><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="container-fluid">
    <div class="row-fluid">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div class="span2 main-menu-span">
            <div class="well nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <?php
                    $menu = $db->result(DB_PREFIX . 'menu', "ref_menu_id='0'", 'menu_sort asc');
                    if ($menu) {
                        foreach ($menu as $m) {
                            echo '<li class="nav-header hidden-tablet">' . $m->menu_name . '</li>';
                            $sub_menu = $db->result(DB_PREFIX . 'menu', "ref_menu_id='" . $m->menu_id . "'", 'menu_sort asc');
                            if ($sub_menu) {
                                foreach ($sub_menu as $sm) {
                                    echo '<li><a class="ajax-link" href="../' . $sm->menu_link . '/"><i class="' . $sm->menu_icon . '"></i><span class="hidden-tablet">' . $sm->menu_name . '</span></a></li>';
                                }
                            }
                        }
                    } ?>
                </ul>
                <!--<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>-->
            </div><!--/.well -->
        </div><!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block span10">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="span10">
            <!-- content starts -->
            <?php } ?>
