<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pasha EA | CONTROL PANEL</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/bootstrap/css/bootstrap.min.css"); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url("assets/fontAwesome/css/font-awesome.min.css"); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/dist/css/AdminLTE.min.css"); ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/dist/css/skins/_all-skins.min.css"); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/plugins/iCheck/flat/blue.css"); ?>">

    <!-- Date Picker -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/plugins/datepicker/datepicker3.css"); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/plugins/daterangepicker/daterangepicker-bs3.css"); ?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/plugins/summernote/summernote.css"); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-black-light sidebar-mini">

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?=site_url("cms"); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><small>ADMIN</small></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><small>Control Panel</small></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=$_SESSION["user_image"]; ?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?=$_SESSION["Name"]; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?=$_SESSION["user_image"]; ?>" class="img-circle" alt="User Image">
                                <p>
                                    <?=$_SESSION["Name"]; ?><!-- - <?=@$_SESSION["Designation"]; ?> -->

                                </p>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?=site_url("logout"); ?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>