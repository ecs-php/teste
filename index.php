<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Teste"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized';
    exit;
}else{
?>
<!DOCTYPE html>
<html>
<head>
<title>Teste</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="viewport"
	content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no; target-densityDpi=device-dpi" />
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet"
	href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script
	src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script src="js/index.js"></script>
</head>
<body>
	<form id="login" >
      <input type="hidden" name="username" id="username" value="<?php echo "{$_SERVER['PHP_AUTH_USER']}";?>"/>
      <input type="hidden" name="password" id="password" value="<?php echo "{$_SERVER['PHP_AUTH_PW']}";?>"/>
	</form>
	<div data-role="page" id="index" data-theme="a">
		<div data-role="header">
			<h3>Teste (Login: <?php echo "{$_SERVER['PHP_AUTH_USER']}";?>)</h3>
			<a href="#insert" class="ui-btn-left">Insert new People</a>
		</div>

		<div data-role="content">
			<ul data-role="listview" id="person-list">

			</ul>
		</div>
		<div data-role="footer" data-position="fixed"></div>
	</div>
	<div data-role="page" id="update" data-theme="a">
		<div data-role="header">
			<h3>Update Page</h3>
			<a href="#index" class="ui-btn-left">Back</a>
		</div>

		<div data-role="content">
			<form id="formUpdate" action="" method="post">
				<ul data-role="listview" id="person-data" data-theme="a">
	
				</ul>
			</form>
		</div>

		<div data-role="footer" data-position="fixed"></div>
	</div>
	<div data-role="page" id="insert" data-theme="a">
		<div data-role="header">
			<h3>Insert Page</h3>
			<a href="#index" class="ui-btn-left">Back</a>
		</div>

		<div data-role="content">
			<form id="formInsert" action="" method="post">
				Name: <input type="text" id="iname"><br>
				Age: <input type="text" id="iage"><br>
				Email: <input type="text" id="iemail"><br>
				Gender: <select id="igender">
					<option value="M">M</option>
					<option value="F">F</option>
				</select>
				
				Phone: <input type="text" id="iphone"><br>
				<input id="submitInsert" type="button" name="submit" value="submit">
			</form>
		</div>

		<div data-role="footer" data-position="fixed"></div>
	</div>
</body>
</html>
<?php
}
?>