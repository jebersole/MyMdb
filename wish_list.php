<?php
# Wish list page queries db for films already added. Those displayed can be removed by unchecking.
include("common.php");
include("common_php.php");
include("common_session.php");

$db = make_db();
$query = "SELECT wish_list FROM users u WHERE u.user_name = ?";
$rows = get_results($db, $query, $user_name, 0);
if ($rows[0][0] != NULL) {
    $wished = preg_split('/,(?={)/', $rows[0][0]);
    $count = 1;
?>
    <a id="top" href="#"></a>
    <h1>Your Wish List</h1>
    <table>
        <tr><th>#</th><th>Title</th><th>Year</th><th>Include?</th></tr>
        <?php foreach ($wished as $row) {
            $row = preg_split('/,(?=\")/', $row); ?>
            <tr id="<?=substr($row[0], 7, -1)."tr";?>">
                <td class="count"><?=$count?></td><td><?=substr($row[1], 8, -1);?></td>
                <td><?=substr($row[2], 8, -2);?></td>
                <td><input type="checkbox" id="<?=substr($row[0], 7, -1);?>" class="check" checked /></td>
            </tr>
        <?php $count++;
              } ?>
    </table>
<?php
} else { ?>
    <div>
    <h3>Nothing here yet. How about running a search to add some?</h3>
    </div>
<?php
} ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="mymdb.js"></script>
<?php include("common2.php"); ?>
