<?php
# query database for wish list. if it exists, split on commas. if not, create array,
# then join with commas and insert into database
include("common_php.php");
$user_name = init_session();

if (isset($_POST["id"]) && isset($_POST["checked"])) {
    $id = filter_var($_POST["id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $checked = filter_var($_POST["checked"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $db = make_db();
    $query;
    if ($checked == "false") { # user wishes to remove item
        $query = "DELETE FROM wish_list WHERE movie_id = ? AND user_id IN
            (SELECT user_id FROM users WHERE user_name = ?)";
    } else {
        $query = "INSERT INTO wish_list (movie_id, user_id) VALUES
            (?, (SELECT user_id FROM users WHERE user_name = ?))";
    }
    get_results($db, $query, $id, $user_name);
}
?>
