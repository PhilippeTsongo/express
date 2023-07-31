<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <title>Afriexpress Global | System</title>
    <link rel="icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" sizes="32x32" />
    <link rel="icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" />
    <meta name="msapplication-TileImage" content="<?= DNADMIN ?>/build/images/logo/afri1.png" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/datatables/datatables.min.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/toastr/toastr.min.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/summernote/dist/summernote-bs4.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/styles/pe-icons/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/styles/pe-icons/helper.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/styles/stroke-icons/style.css" />
    <link rel="stylesheet" href="<?= DNADMIN ?>/build/styles/style.css">


	<!-- <link href="<?= DNADMIN ?>/build/admin_assets/css/main5739.css?version=4.5.0" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="<?= DNADMIN ?>/build/vendor/toastr/toastr.min.css" /> -->





















    

    <style>
        .navbar-default .navbar-brand,
        .navbar-default .navbar-brand:focus {
            width: 200px;
            background-color: #161F62;
            height: 60px;
            padding: 17px 25px;
            font-weight: 400;
            font-style: oblique;
            letter-spacing: 0px;
            font-family: Arial, Helvetica, sans-serif;
            color: #FFFFFF;
            font-size: 1.12rem;
        }

        .view-header .header-icon {
            font-size: 60px;
            color: #f6a821;
            width: 68px;
            float: left;
            margin-top: -8px;
            line-height: 0;
        }

        .panel.panel-b-accent {
            background-color: #12453c;
            color: #ffffff;
        }

        .luna-nav.nav li.active a {
            border-left: 6px solid #12453c;
            padding-left: 19px;
            color: #c0c4c8;
        }

        .text-accent {
            color: #12453c;
        }

        table thead {
            background: #31796c73;
        }

        .form-control {
            border-radius: 0px !important;
        }

        .dropdown-item {
            cursor: pointer;
        }

        .note-editor.card.note-frame {
            border: 1px solid;
            width: 74%;
        }

        .btn-primary {
            color: #949ba2;
            background-color: transparent;
            border-color: #40877b;
        }

        .text-warning {
            color: #40877b !important;
        }

        #smartModal .text-center {
            overflow-wrap: break-word;
        }

        .hidden {
            display: none;
        }
    </style>



    <style>
        .cke_top #cke_1_top {
            height: auto;
            user-select: none;
            background: #393c45 !important;
        }

        .cke_contents iframe html {
            background: #393c45 !important;
            color: #edf1f4 !important;
        }

        .cke_contents iframe html {
            background: #393c45 !important;
            color: #edf1f4 !important;
        }



        .navigation nav {
            background-color: #161f62;
        }

        .navigation:before {
            transition: left 0.3s ease-out;
            -webkit-transition: left 0.3s ease-out;
            content: '';
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: -1;
            left: 0;
            background-color: #151f62;
            width: 200px;
        }

        .navigation {
            margin-top: 60px;
            background-color: #151f62;
            width: 200px;
            position: absolute;
            left: 0;
            bottom: 0;
            top: 0;
            transition: left 0.3s ease-out;
            -webkit-transition: left 0.3s ease-out;
        }

        .luna-nav.nav li.active a {
            border-left: 6px solid #ffffff;
            padding-left: 19px;
            color: #c0c4c8;
        }

        .view-header .header-icon {
            font-size: 60px;
            color: #f9f9fb;
            width: 68px;
            float: left;
            margin-top: -8px;
            line-height: 0;
        }

        table thead {
            background: #2e3039;
        }

        .profil-link .profile-address {
            text-transform: none;
        }
    </style>
</head>

<body>

    <div>
        <cns content="<?= Session::get(Config::get('session/session_name')) ?>"></cns>
    </div>
    <!-- Wrapper-->
    <div class="wrapper">

        <!-- Header-->
        <nav class="navbar navbar-expand-md navbar-default fixed-top">
            <div class="navbar-header">
                <div id="mobile-menu">
                    <div class="left-nav-toggle">
                        <a href="#">
                            <i class="stroke-hamburgermenu"></i>
                        </a>
                    </div>
                </div>
                <a class="navbar-brand" href="<?= DNADMIN ?>">
                    AFRIEXPRESS
                    <span style="margin-left: 0px">Global</span>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <div class="left-nav-toggle">
                    <a href="#">
                        <i class="stroke-hamburgermenu"></i>
                    </a>
                </div>
                <form class="navbar-form mr-auto">
                    <!-- <input type="text" class="form-control" placeholder="Search data for analysis" style="width: 175px"> -->
                </form>
                <ul class="nav navbar-nav">
                    <!-- <li class="nav-item uppercase-link">
                    <a href="<?= DNADMIN ?>/logout" class="nav-link">Logout <span class="pe-7s-power"></span>
                        <span class="label label-warning pull-right">2</span>
                    </a>
                </li>
                <li class="nav-item uppercase-link">
                    <a href="versions.html" class="nav-link">Versions
                        <span class="label label-warning pull-right">2</span>
                    </a>
                </li> -->
                    <li class="nav-item profil-link">
                        <a href="login.html">
                            <span class="profile-address">
                                <?= $_CNS_USER_->firstname . ' ' . $_CNS_USER_->lastname ?>
                            </span>
                            <img src="http://afriexpressglobal.cnsplateforme.com/build/web01/assets/wp-content/uploads/sites/2/2015/10/avatar-1.png" class="rounded-circle"
                                alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End header-->

        <?php
        require 'nav.menu' . PL;
        ?>