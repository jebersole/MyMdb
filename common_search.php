<?php
# common search result code
$count = 1;
$wished = get_wished($db, $user_name);
?>
<a id="top" href="#"></a>
<h1>Results for <?=$firstname . " $lastname:"?></h1>
<table>
    <caption style="margin-bottom: 10px">All Films Starred in by<br /><?=$firstname . " $lastname"?></caption>
    <tr><th>#</th><th>Title</th><th>Year</th><th>Wishlisted?</th></tr>
    <?php foreach ($rows as $row) { ?>
        <tr>
            <td><?=$count?></td><td><?=$row[0]?></td><td><?=$row[1];?></td>
            <td><input type="checkbox" id="<?=$row[2]?>" class="check"
            <?php if(check_wished($wished, $row)) {?> checked <?php } ?>/></td>
        </tr>
        <?php $count++;
          } ?>
</table>
