<?php
# display these links if user has logged in
$user_name = init_session(); ?>
<div id="user_session">
    <?=ucfirst($user_name)?>: <a href="wish_list.php">Wish List</a> or <a href="logout.php">Logout</a>.
</div>
