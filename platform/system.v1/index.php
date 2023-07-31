<?php
require_once 'core/init.php';
if ($session_user->isLoggedIn()):
  require_once CTRL;
  require_once ROUTES;
else:
  Redirect::to(DNSIGNIN);
endif;
?>
