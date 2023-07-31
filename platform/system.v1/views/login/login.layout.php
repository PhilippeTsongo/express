<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Page title -->
    <title>Afriexpress Global | System</title>
    <link rel="icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" sizes="32x32" />
    <link rel="icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= DNADMIN ?>/build/images/logo/afri1.png" />
    <meta name="msapplication-TileImage" content="<?= DNADMIN ?>/build/images/logo/afri1.png" />
    
    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?=DNADMIN?>/build/vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="<?=DNADMIN?>/build/vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="<?=DNADMIN?>/build/vendor/bootstrap/css/bootstrap.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="<?=DNADMIN?>/build/styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="<?=DNADMIN?>/build/styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="<?=DNADMIN?>/build/styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="<?=DNADMIN?>/build/styles/style.css">
    
	<link rel="icon" href="<?=DNADMIN?>/build/images/IMG_4742.PNG" sizes="32x32" />
    <link rel="icon" href="<?=DNADMIN?>/build/images/IMG_4742.PNG" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?=DNADMIN?>/build/images/IMG_4742.PNG" />
    <meta name="msapplication-TileImage" content="<?=DNADMIN?>/build/images/IMG_4742.PNG" />
    <style>
      /* .brand-wrapper .logo {
            height: 40px;
      }
      .login-card form {
          max-width: 350px;
      } */
      .notif-lg-info {
          background: #40a9f2;
          padding: 10px;
          width: auto;
          color: white;
          border-radius: 5px;
          margin-bottom: 15px !important;
      }
      .notif-lg-success {
          background: #51a56d;
          padding: 10px;
          width: auto;
          color: white;
          border-radius: 5px;
          margin-bottom: 15px !important;
      }
      .notif-lg-error {
          background: #f22020b8;
          padding: 10px;
          color: white;
          border-radius: 5px;
          margin-bottom: 10px !important;
      }
      .hidden{
        display: none;
      }
      /* .login-card .card-body {
          padding: 30px 60px 35px 51px;
      } */
  </style>
</head>
<body class="blank">

<!-- Wrapper-->
<div class="wrapper">


    <!-- Main content-->
    <section class="content">

        <div class="container-center animated slideInDown">


            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Login | AFRIEXPRESS</h3>
                    <small>
                        Please enter your valid credentials to login.
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form method="post" id="loginForm" novalidate>
                        <div class="notif hidden">
                            You have logged in success.
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="username">Username</label>
                            <input type="text" placeholder="example@gmail.com" title="Please enter your username" name="email" id="username" class="form-control">
                            <span class="form-text small">Your unique username</span>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="password">Password</label>
                            <input type="password" title="Please enter your password" placeholder="******" name="password" id="password" class="form-control">
                            <span class="form-text small">Your strong password</span>
                        </div>
                        <div>
                            <!-- <input type="hidden" name="webToken" value="256">
                            <input type="hidden" name="request" value="user_login"> -->
                            <button type="submit" class="btn btn-accent">Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="<?=DNADMIN?>/build/vendor/pacejs/pace.min.js"></script>
<script src="<?=DNADMIN?>/build/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?=DNADMIN?>/build/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="<?=DNADMIN?>/build/scripts/luna.js"></script>
<script src="views/login/scripts/script.js" type="module"></script>

</body>


</html>