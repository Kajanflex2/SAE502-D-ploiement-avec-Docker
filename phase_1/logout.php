<?php

require 'con_db/conexdb.php';

session_destroy();

header('location: ' . $base_url);

die();

?>