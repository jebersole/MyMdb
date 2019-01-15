<?php
# update user's wish list upon checkbox toggle
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
$user_name = init_session();

if (isset($_POST["id"]) && isset($_POST["checked"])) {
    $id = filter_var($_POST["id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $checked = filter_var($_POST["checked"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $db = make_db();
    $query = "";
    if ($checked == "false") { # user wishes to remove item
        $query = "DELETE FROM wish_list WHERE movie_id = ? AND user_id IN
            (SELECT user_id FROM users WHERE user_name = ?)";
    } else {
        $query = "INSERT INTO wish_list (movie_id, user_id) VALUES
            (?, (SELECT user_id FROM users WHERE user_name = ?))";
    }
    $pdb = $db->prepare($query);
    $pdb->execute(array($id, $user_name));
}
?>
