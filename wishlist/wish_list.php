<?php
# Wish list page queries db for films already added. Those displayed can be removed by unchecking.
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/user/common_session.php');

$db = make_db();
$wished = get_wished($db, $user_name);
if (count($wished) > 0) {
    $count = 1;
?>
    <a id="top" href="#"></a>
    <h1>Your Wish List</h1>
    <table>
        <tr><th>#</th><th>Title</th><th>Year</th><th>Include?</th></tr>
        <?php foreach ($wished as $row) { ?>
            <tr id="<?=$row[0].'tr';?>">
                <td class="count"><?=$count?></td><td><?=$row[1]?></td>
                <td><?=$row[2]?></td>
                <td><input type="checkbox" id="<?=$row[0]?>" class="check" checked /></td>
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
<script src="/mymdb/js/mymdb.js"></script>
<? include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/search_forms.php'); ?>
