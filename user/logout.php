<?php
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
session_start();
session_destroy();
header("Location:".baseUrl()."start.php");
?>
