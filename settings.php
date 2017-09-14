<?php 
include __DIR__."/assets/includes/top_cms.php";

	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$existingPwd = $_POST['existingPwd'];
		$email 		 = $_POST['email'];
		$newPwd		 = $_POST['newPwd'];

		if(!empty($existingPwd)) {
			if(password_verify($existingPwd, $usersRow['password'])) {

				// change email & password if both entered
				if(!empty($email) && !empty($newPwd)) {

					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

						$query = $db->prepare('UPDATE users SET email=:email, email_confirmed=NULL WHERE login_token=:token');
						$query->execute(array(
							':email' => $email,
							':token' => $login_token
						));

						$stmt = $db->prepare('SELECT * FROM users WHERE login_token=:token');
						$stmt->bindParam(':token', $_SESSION['login_token']);
						$stmt->execute();
						$usersRow = $stmt->fetch();

						$emailChanged=true;
					} else {
						$error=3;
					}

					if(validate_pwd($newPwd)) {

						$newPwd = password_hash($newPwd, PASSWORD_DEFAULT);

						$query = $db->prepare('UPDATE users SET password=:pwd WHERE login_token=:token');
						$query->execute(array(
							':pwd' => $newPwd,
							':token' => $login_token
						));

						$pwdChanged=true;						
					} else {
						$error=4;
					}


				} else {}

				// change email if email entered
				if(!empty($email) && empty($newPwd)) {
					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

						$query = $db->prepare('UPDATE users SET email=:email, email_confirmed=NULL WHERE login_token=:token');
						$query->execute(array(
							':email' => $email,
							':token' => $login_token
						));

						$stmt = $db->prepare('SELECT * FROM users WHERE login_token=:token');
						$stmt->bindParam(':token', $_SESSION['login_token']);
						$stmt->execute();
						$usersRow = $stmt->fetch();

						$emailChanged=true;
					} else {
						$error=3;
					}
				} else {}

				// change password if password entered
				if(empty($email) && !empty($newPwd)) {
					if(validate_pwd($newPwd)) {

						$newPwd = password_hash($newPwd, PASSWORD_DEFAULT);

						$query = $db->prepare('UPDATE users SET password=:pwd WHERE login_token=:token');
						$query->execute(array(
							':pwd' => $newPwd,
							':token' => $login_token
						));

						$pwdChanged=true;					
					} else {
						$error=4;
					}
				} else {}

			} else {
				$error=2;
			}
		} else {
			$error=1;
		}
	}

?>
				<h3>Settings</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<form class="small-8 small-offset-2 medium-6 medium-offset-3" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

			<div class="row">
				<div class="medium-6 columns">
					<label>First Name
						<input name="firstName" type="text" placeholder="<?= htmlspecialchars(ucwords($usersRow['first_name'])) ?>" readonly>
					</label>
				</div>
				<div class="medium-6 columns">
					<label>Last Name
						<input name="lastName" type="text" placeholder="<?= htmlspecialchars(ucwords($usersRow['last_name'])) ?>" readonly>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<?php if($error===3): ?>
					<div class="label alert">
			  			<h6>Please enter a valid email address.</h6>
					</div>
					<?php endif; ?>
					<?php if($emailChanged): ?>
					<div class="label primary">
			  			<h6>Your email successfully changed to <?= $usersRow['email'] ?>.</h6>
					</div>
					<?php endif; ?>
					<label>New Email
						<input name="email" type="text" placeholder="<?= htmlspecialchars($usersRow['email']) ?>">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<?php if($error===4): ?>
					<div class="label alert">
			  			<h6>Your password must contain letters, numbers and special chars.</h6>
					</div>
					<?php endif; ?>
					<?php if($pwdChanged): ?>
					<div class="label primary">
			  			<h6>Your password was successfully changed.</h6>
					</div>
					<?php endif; ?>
					<label>New Password
						<input name="newPwd" type="password">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<?php if($error===1): ?>
					<div class="label alert">
			  			<h6>Enter your existing password.</h6>
					</div>
					<?php endif; ?>
					<?php if($error===2): ?>
					<div class="label alert">
				  		<h6>Your existing password was incorrect.</h6>
					</div>
					<?php endif; ?>
					<label>Existing Password
						<input name="existingPwd" type="password" placeholder="">
					</label>
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
