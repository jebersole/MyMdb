<?php
# Returns user's wish list
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
$user_name = init_session();
$db = make_db();
$wished = get_wished($db, $user_name);
header('Content-Type: application/json');
echo json_encode($wished);
?>
