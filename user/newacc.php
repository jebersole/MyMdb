<? include($_SERVER['DOCUMENT_ROOT'].'/mymdb/header.php'); ?>
<p>
	<h2>Start a new MyMdb account!</h2> <br />
</p>

<form id="loginform" action="/mymdb/user/login.php" method="post">
    <div>
		<input name="new" type="hidden"/>
	</div>
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

<?php if(isset($_GET["fail"])) { ?>
	<div style="color: red; ">
		Sorry, that username is already in use. Please try another.
	</div>
	<br/> <?
	  } ?>

</div> <!-- end of #main div -->

<div id="footer"></div>

</div> <!-- end of #frame div -->
</body>
</html>
