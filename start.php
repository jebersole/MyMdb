<?php include($_SERVER['DOCUMENT_ROOT'].'/mymdb/header.php'); ?>
	<p>
		<h2>Welcome to MyMdb</h2>
	</p>
	<p>
		Log in now to manage your account. (guest/123) <br />
	</p>
	<?php if(isset($_GET["fail"])) { ?>
		<div style="color: red; ">
			The username and password combination you entered is incorrect.
		</div>
		<br/>
	<?php } ?>

	<form id="loginform" action="/mymdb/user/login.php" method="post">
		<div style="margin-right: 9px">
            <strong>User Name: </strong>
			<input name="user_name" type="text" size="15" autofocus="autofocus" required />
        </div>
		<div>
			<strong>Password: </strong>
			<input name="password" type="password" size="15" required />
		</div>
		<div>
			<input style="margin-right: 12px" type="submit" value="Log in" />
		</div>
	</form>

    <p>
        Or, <a href="/mymdb/user/newacc.php">start a new account</a>.
    </p>

</div> <!-- end of #main div -->
