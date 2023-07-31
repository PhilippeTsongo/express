<?php
require_once 'core/init.php';
require_once CTRL;
if (!$session_user->isLoggedIn())
  require_once _PATH_VIEWS_ . 'login/login.layout' . PL;
else
  Redirect::to(DNADMIN);
