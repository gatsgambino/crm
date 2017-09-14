<?php 
include __DIR__."/assets/includes/top_cms.php";

	if ($usersRow['privilege'] != "admin") {
		header('Location: dashboard.php');
		exit;
	}

	if (empty($_GET['uname']) || !is_string($_GET['uname'])) {
		header('Location: dashboard.php');
		exit;
	}

	$GET_USERNAME = filter_var(strtolower($_GET['uname']), FILTER_SANITIZE_STRING);

	$query = $db->prepare("SELECT * FROM users WHERE username=:uname");
	$query->bindValue(':uname', $GET_USERNAME, PDO::PARAM_STR);
	$query->execute();
	$userRow = $query->fetch();

	if (empty($userRow)) 
	{
		header('Location: dashboard.php');
		exit;
	} 

	if ($GET_USERNAME == $usersRow['username']) {
		$error = 7;
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		$emptyPost = false;
		foreach ($_POST as $key => $val) {
			if (empty($val)) $emptyPost = true;
		}

		if (!$emptyPost) {

			$firstName = strtolower($_POST['fname']);
			$lastName  = strtolower($_POST['lname']);
			$privilege = strtolower($_POST['privilege']);

			if (!ctype_alpha($firstName)) {
				$error=1;
			}

			if (strlen($firstName) < 3) {
				$error=3;
			}

			if (strlen($firstName) > 32) {
				$error=999;
			}

			if (!ctype_alpha($lastName)) {
				$error=1;
			}

			if (strlen($lastName) < 3) {
				$error=3;
			}

			 if (strlen($lastName) > 32) {
				$error=999;
			}

			if (empty($error)) {
				$password = random_str(8);

				$query2 = $db->prepare("UPDATE users SET first_name=:fname, last_name=:lname, privilege=:priv WHERE username=:uname");
				$query2->execute(array(
					':fname'    => $firstName,
					':lname'    => $lastName,
					':priv'     => $privilege,
					':uname' => $GET_USERNAME
				));

				$query = $db->prepare("SELECT * FROM users WHERE username=:username");
				$query->bindValue(':username', $GET_USERNAME, PDO::PARAM_STR);
				$query->execute();
				$userRow = $query->fetch();

				// add mail function here to send email alerting user to changed account credentials
				// including login details $GET_USERNAME, $password, $email, $firstName, $lastName
				//

				$successMessage=true;
			}
		}
	}


?>
				<h3>Edit User <b><?= htmlspecialchars(strtolower($userRow['username'])) ?></b></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<form class="small-8 small-offset-2 medium-6 medium-offset-3" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?uname=' . htmlspecialchars($GET_USERNAME) ?>">
			<?php if($error===7): ?>
			<div class="label warning">
	  			<h6>You can edit your own account in <a href="settings.php">settings</a>.</h6>
			</div>
			<?php endif; ?>
			<?php if($emptyPost): ?>
			<div class="label alert">
	  			<h6>Please complete all fields.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===1): ?>
			<div class="label alert">
	  			<h6>Your name can only contain alphabetical letters.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===999): ?>
			<div class="label alert">
	  			<h6>We encountered an error. Please contact system administrator.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===3): ?>
			<div class="label alert">
	  			<h6>Your name must be at least 3 characters long.</h6>
			</div>
			<?php endif; ?>
			<?php if($successMessage): ?>
			<div class="label success">
	  			<h6>User account was successfully changed.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-6 columns">

					<label>First Name
						<input maxlength="32" name="fname" type="text" value="<?php echo (!empty($_POST['fname'])) ? htmlspecialchars($_POST['fname']) : htmlspecialchars(ucwords($userRow['first_name'])) ?>">
					</label>
				</div>
				<div class="medium-6 columns">
					<label>Last Name
						<input maxlength="32" name="lname" type="text" value="<?php echo (!empty($_POST['lname'])) ? htmlspecialchars($_POST['lname']) : htmlspecialchars(ucwords($userRow['last_name'])) ?>">
					</label>
				</div>
			</div>
			<?php if($error===6): ?>
			<div class="label alert">
	  			<h6>Please select a privilege level.</h6>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="medium-12 columns">
					<label>Privilege</label>
					<select name="privilege">
					    <option value="consultant">Consultant</option>
					    <option value="admin">Admin</option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="medium-12 columns">
					<input type="submit" class="button secondary expanded" value="Submit Changes">
				</div>
			</div>
		</form>
		

	</div>



<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
