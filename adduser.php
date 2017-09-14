<?php 
include __DIR__."/assets/includes/top_cms.php";

	if ($usersRow['privilege'] != "admin") {
		header('Location: dashboard.php');
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$emptyPost = false;
		foreach ($_POST as $key => $val) {
			if (empty($val)) $emptyPost = true;
		}

		if (!$emptyPost) {
			$firstName = $_POST['fname'];
			$lastName  = $_POST['lname'];
			$email 	   = $_POST['email'];
			$privilege = $_POST['privilege'];

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

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error=4;
			} else if (strlen($email) > 1024) {
				$error=999;
			} else {
				$query = $db->prepare('SELECT * FROM users WHERE email=:email');
				$query->bindValue(':email', $email, PDO::PARAM_STR);
				$query->execute();
				$row = $query->fetch();

				if (!empty($row)) {
					$error=5;
				}
			}

			if (empty($error)) {
				$username  = substr($firstName, 0, 1) . $lastName . strtolower(random_str(4));
				$password  = random_str(8);
				$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

				$query = $db->prepare("INSERT INTO users(username, first_name, last_name, email, password, privilege) VALUES(:uname, :fname, :lname, :email, :pwd, :priv)");
				$query->execute(array(
					':uname' => strtolower($username),
					':fname' => strtolower($firstName),
					':lname' => strtolower($lastName),
					':email' => strtolower($email),
					':pwd'   => strtolower($hashedPwd),
					':priv'  => strtolower($privilege)
				));

				// add mail function here to send email confirmation request
				// including login details $username, $password, $email, $firstName, $lastName
				//

				$successMessage=true;
			}
		}
	}


?>
				<h3>Add New User</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<form class="small-8 small-offset-2 medium-6 medium-offset-3" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
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
	  			<h6>A confirmation email was sent to the user's address along with login details.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-6 columns">

					<label>First Name
						<input maxlength="32" name="fname" type="text" value="<?php if(!empty($_POST['fname'])) echo htmlspecialchars($_POST['fname'])?>">
					</label>
				</div>
				<div class="medium-6 columns">
					<label>Last Name
						<input maxlength="32" name="lname" type="text" value="<?php if(!empty($_POST['lname'])) echo htmlspecialchars($_POST['lname'])?>">
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
			<?php if($error===4): ?>
			<div class="label alert">
	  			<h6>Please enter a valid email address.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===5): ?>
			<div class="label alert">
	  			<h6>Email already exists in our records.</h6>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="medium-12 columns">
					<label>Email
						<input maxlength="1024" name="email" type="text" value="<?php if(!empty($_POST['email'])) echo htmlspecialchars(strtolower($_POST['email']))?>">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<input type="submit" class="button secondary expanded" value="Create User">
				</div>
			</div>
		</form>
		

	</div>



<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
