<?php
require 'core/init.php';


/** EMAIL */
$_DATA_ = array(
    'firstname' => 'Ezechiel',
    'email' => 'ezechielkalengya@gmail.com',
    'password' => 'jfjfj',
    'b2b' => 'bcc',
    'link' => "http://eshop.cnsplateforme.com/account",
);
CNS_EMAIL::send('CNSEMAIL.00004', $_DATA_);

?>