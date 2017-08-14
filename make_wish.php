<?php
# query database for wish list. if it exists, split on commas. if not, create array,
# then join with commas and insert into database
include("common_php.php");
$user_name = init_session();

if (isset($_POST["id"]) && isset($_POST["checked"])) {
    $id = filter_var($_POST["id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $checked = filter_var($_POST["checked"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $db = make_db();
    $query = "SELECT wish_list FROM users u WHERE u.user_name = ?";
    $rows = get_results($db, $query, $user_name, 0);
    $wished = $rows[0][0] == NULL ? array() : preg_split('/,(?={)/', $rows[0][0]);
    if ($checked == "false") { # user wishes to remove item
        for ($i = 0; $i < count($wished); $i++) {
            $wish = json_decode($wished[$i], true);
            if ($wish['id'] == $id) {
                array_splice($wished, $i, 1);
                break;
            }
        }
        if (count($wished) < 1) $wished = NULL;
        else $wished = implode(",", $wished);
    } else {
        # find film and add it
        $query = "SELECT m.id, m.name, m.year FROM movies m WHERE m.id = ?";
        $rows = get_results($db, $query, $id, 0);
        $new = json_encode(array('id'=>$rows[0][0],'name'=>$rows[0][1],'year'=>$rows[0][2]));
        array_push($wished, $new);
        if (count($wished) > 1) $wished = implode(",", $wished);
        else $wished = $new;
    }
    $query = "UPDATE users u SET wish_list = ? WHERE u.user_name = ?";
    get_results($db, $query, $wished, $user_name);
}
?>
