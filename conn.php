<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

try {
  $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  exit;
}

if ($dbo->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
