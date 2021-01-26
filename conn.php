<?php

$dbhost = 'etabetaaka.c1m0a5xa0ixp.us-east-2.rds.amazonaws.com';
$dbuname = 'EtaBetaAka';
$dbpass = 'EtaBeta1972!';
$dbname = 'aka';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);


?>
