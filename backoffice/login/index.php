<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <!-- The styles -->
    <link id="bs-css" href="../template/css/bootstrap-cerulean.css" rel="stylesheet">
    <link type="image/ico" rel="shortcut icon" href="../template/img/favicon.ico">
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
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
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<div class="container-fluid">
    <div class="row-fluid">

        <div class="row-fluid">
            <div class="span12 center login-header">
                <h2>Vessuwan Construction(1984) (PAY SLIP)</h2>
            </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid">
            <div class="well span5 center login-box">
                <div class="alert alert-info">
                    กรอกชื่อผู้ใช้และรหัสผ่านเพื่อลงชื่อเข้าใช้
                </div>
                <form class="form-horizontal" id="login" name="login" onsubmit="return false;" method="post">
                    <fieldset>
                        <div class="input-prepend" title="Username" data-rel="tooltip">
                            <span class="add-on"><i class="icon-user"></i></span><input autofocus
                                                                                        class="input-large span10"
                                                                                        name="username" id="username"
                                                                                        type="text"
                                                                                        placeholder="ชื่อผู้ใช้"
                                                                                        autocomplete="off"/>
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend" title="Password" data-rel="tooltip">
                            <span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10"
                                                                                        name="password" id="password"
                                                                                        type="password"
                                                                                        placeholder="รหัสผ่าน"
                                                                                        autocomplete="off"/>
                        </div>
                        <div class="clearfix"></div>
                        <p class="center span5">
                            <input type="submit" class="btn btn-primary" value="เข้าสู่ระบบ">
                        </p>
                    </fieldset>
                </form>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/fluid-row-->

</div><!--/.fluid-container-->

<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery -->
<script src="../template/js/jquery-1.7.2.min.js"></script>
<!-- jQuery UI -->
<script src="../template/js/jquery-ui-1.8.21.custom.min.js"></script>
<!-- transition / effect library -->
<script src="../template/js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="../template/js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="../template/js/bootstrap-modal.js"></script>
<!-- custom dropdown library -->
<script src="../template/js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="../template/js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="../template/js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="../template/js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="../template/js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="../template/js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="../template/js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="../template/js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="../template/js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="../template/js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="../template/js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='../template/js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='../template/js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="../template/js/excanvas.js"></script>
<script src="../template/js/jquery.flot.min.js"></script>
<script src="../template/js/jquery.flot.pie.min.js"></script>
<script src="../template/js/jquery.flot.stack.js"></script>
<script src="../template/js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="../template/js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="../template/js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="../template/js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="../template/js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="../template/js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="../template/js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="../template/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="../template/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="../template/js/jquery.autogrow-textarea.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="../template/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="../template/js/charisma.js"></script>
<!--<script src="tm.script.js"></script>-->
<script>
    $("#login").submit(function () {
        $.post('init.php?Mode=Login', $("#login").serialize(), function (data) {

            if (data.status == 'COMPLETE') {

                window.location.href = "../index";

            } else {
                $('.alert').html('ชื่อผู้ใช้หรือรหัสผ่านผิดพลาด!!');
                $('.alert').attr('class', 'alert alert-error');
            }


        });
    });
</script>

</body>
</html>
