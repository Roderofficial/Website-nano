<?php
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
var_dump($_POST) ?>