<?php
	session_start();
	include "connect.php";
	include "functions.php";

	if(!empty($_SESSION['login_token']))
	{
		$stmt = $db->prepare('SELECT * FROM users WHERE login_token=:token');
		$stmt->bindValue(':token', $_SESSION['login_token'], PDO::PARAM_STR);
		$stmt->execute();
		$usersRow = $stmt->fetch();

		if(!empty($usersRow)) {
			$login_token = random_str(32);

			$stmt = $db->prepare('UPDATE users SET login_token=:token WHERE username=:name');
			$stmt->bindValue(':token', $login_token, PDO::PARAM_STR);
			$stmt->bindValue(':name', $usersRow['username'], PDO::PARAM_STR);
			$stmt->execute();

			$_SESSION['login_token'] = $login_token;
		} else {
			header('Location: signout.php');
		}

	} else {
		header('Location: signout.php');
		exit;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?= htmlspecialchars(ucwords($usersRow['first_name'].' '.$usersRow['last_name'])); ?> | HR System</title>
<?php include "head.php"; ?>
</head>
<body>

<div class="top-bar">
	<div class="top-bar-title">
		<span data-responsive-toggle="responsive-menu" data-hide-for="medium">
		<button class="menu-icon dark" type="button" data-toggle></button>
    </span>
    	<a id="dashboard" href="dashboard.php"><strong>Dashboard</strong></a>
	</div>

	<div id="responsive-menu">
		<div class="top-bar-left">
        	<ul class="dropdown menu" data-dropdown-menu>
				<li>
		        	<a href="viewclients.php">Manage Clients</a>
	       			<ul class="menu vertical">
		         	 	<li><a href="viewclients.php">View Clients</a></li>
		          		<li><a href="addclient.php">Add New Client</a></li>
		            </ul>
				</li>

				<li>
		        	<a href="viewlogs.php">Manage Logs</a>
	       			<ul class="menu vertical">
		          		<li><a href="viewlogs.php">View Logs</a></li>
		          		<li><a href="addlog.php">Add New Log</a></li>
		            </ul>
				</li>

				<li class="<?php if($usersRow['privilege'] != "admin") echo "hide"; ?>">
		        	<a href="viewusers.php">Manage Users</a>
	       			<ul class="menu vertical">
		            	<li><a href="viewusers.php">View Users</a></li>
		            	<li><a href="adduser.php">Add New User</a></li>
		            </ul>
				</li>
			</ul>
		</div>
    	<div class="top-bar-right">
	  		<ul class="dropdown menu" data-dropdown-menu>
		        <li>
		        	<a href="#"><i class="fa fa-user hffa-custom" aria-hidden="true"></i><?= htmlentities(strtolower($usersRow['username'])) ?></a>
	       			<ul class="menu vertical">
		            	<li><a href="settings.php"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</a></li>
		            	<li><a href="signout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Signout</a></li>
		            </ul>
		        </li>
	    	</ul>
    	</div>
  	</div>
</div>

<div class="container small-10 small-offset-1">
	<div class="row">
		<div class="small-4 small-offset-4">
			<div class="row text-center">
				<img id="hr-logo" src="assets/images/human_resources.png">	



