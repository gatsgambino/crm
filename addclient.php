<?php 
include __DIR__."/assets/includes/top_cms.php";
// included to display dropdown list of countries
include __DIR__."/assets/includes/countrydropdownlist.php";

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$emptyPost = false;
		foreach ($_POST as $key => $val) {
			if (empty($val)) $emptyPost = true;
		}

		if (!$emptyPost) {
			$firstName 	   = $_POST['fname'];
			$lastName      = $_POST['lname'];
			$company       = $_POST['company'];
			$email 	       = $_POST['email'];
			$contactNumber = $_POST['contactNum'];
			$addressNumber = $_POST['addressNum'];
			$streetName    = $_POST['streetName'];
			$postcode      = $_POST['postcode'];
			$city          = $_POST['city'];
			$country       = $_POST['country'];

			// first name validation
			if (!ctype_alpha($firstName)) {
				$error=1;
			}

			if (strlen($firstName) < 3) {
				$error=2;
			} 

			if (strlen($firstName) > 32) {
				$error=999;
			}
			// last name validation
			if (!ctype_alpha($lastName)) {
				$error=1;
			}

			if (strlen($lastName) < 3) {
				$error=2;
			}

			if (strlen($lastName) > 32) {
				$error=999;
			}
			// company validation
			if (strlen($company) > 24) {
				$error=999;
			}
			// email validation
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error=3;
			}

			if (strlen($email) > 1024) {
				$error=999;
			}
			// contact number validation
			if (strlen($contactNumber) > 16) {
				$error=999;
			}
			if (!ctype_digit($contactNumber)) {
				$error=4;
			} 

			// address number / building name validation
			if (strlen($addressNumber) > 24) {
				$error=999;
			}
			// street name validation
			if (strlen($streetName) > 24) {
				$error=999;
			}
			// postcode validation
			if (strlen($postcode) > 16) {
				$error=999;
			}
			// city validation
			if (strlen($city) > 24) {
				$error=999;
			}
			// country validation
			if(empty($countries[$country])) {
				$error=999;
			}
			if (strlen($country) > 24) {
				$error=999;
			}

			if (empty($error)) {
				// check if first && last name already exist in database for a single client
				$query = $db->prepare('SELECT * FROM clients WHERE first_name=:fname && last_name=:lname');
				$query->execute(array(
					':fname' => $firstName,
					':lname' => $lastName
				));
				$row = $query->fetch();

				if (empty($row)) {
					$query = $db->prepare('INSERT INTO clients(first_name, last_name, company, email, contact_number, address_number, street_name, postcode, city, country, user_who_created)
						VALUES(:fname, :lname, :comp, :email, :cnum, :anum, :sname, :pcode, :city, :country, :uwc)');
					$query->execute(array(
						':fname'   => strtolower($firstName),
						':lname'   => strtolower($lastName),
						':comp'	   => strtolower($company),
						':email'   => strtolower($email),
						':cnum'    => strtolower($contactNumber),
						':anum'    => strtolower($addressNumber),
						':sname'   => strtolower($streetName),
						':pcode'   => strtolower($postcode),
						':city'    => strtolower($city),
						':country' => strtolower($country),
						':uwc'     => strtolower($usersRow['username'])
					));

					$successMessage = true;
				} else {
					$error=6;
				}
			}

		}
	}


?>
				<h3>Add New Client</h3>
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
	  			<h6>Name field must only contain alphabetical letters.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===999): ?>
			<div class="label alert">
	  			<h6>We encountered an error. Please contact system administrator.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===2): ?>
			<div class="label alert">
	  			<h6>Name field must be at least 3 characters long.</h6>
			</div>
			<?php endif; ?>
			<?php if($successMessage): ?>
			<div class="label success">
	  			<h6>Client successfully added.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===6): ?>
			<div class="label alert <?php if ($error!=6) echo 'hide'; ?>">
	  			<h6>Client <?= htmlspecialchars(ucwords($_POST['fname'].' '.$_POST['lname'])) ?> already exists.</h6>
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

			<div class="row">

				<div class="medium-12 columns">

					<label>Company
						<input maxlength="24" name="company" type="text" value="<?php if(!empty($_POST['company'])) echo htmlspecialchars($_POST['company'])?>">
					</label>
				</div>
			</div>
			<?php if($error===3): ?>
			<div class="label alert">
	  			<h6>Please enter a valid email address.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Email
						<input maxlength="1024" name="email" type="text" value="<?php if(!empty($_POST['email'])) echo htmlspecialchars($_POST['email'])?>">
					</label>
				</div>
			</div>
			<?php if($error===4): ?>
			<div class="label alert">
	  			<h6>This field must only contain numbers.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Contact Number
						<input maxlength="16" name="contactNum" type="text" value="<?php if(!empty($_POST['contactNum'])) echo htmlspecialchars($_POST['contactNum'])?>">
					</label>
				</div>
			</div>
			<div class="row">

				<div class="medium-12 columns">

					<label>Address Number / Building Name
						<input maxlength="24" name="addressNum" type="text" value="<?php if(!empty($_POST['addressNum'])) echo htmlspecialchars($_POST['addressNum'])?>">
					</label>
				</div>
			</div>

			<div class="row">

				<div class="medium-12 columns">

					<label>Street Name
						<input maxlength="24" name="streetName" type="text" value="<?php if(!empty($_POST['streetName'])) echo htmlspecialchars($_POST['streetName'])?>">
					</label>
				</div>
			</div>
			<div class="row">

				<div class="medium-6 columns">

					<label>Post Code
						<input maxlength="16" name="postcode" type="text" value="<?php if(!empty($_POST['postcode'])) echo htmlspecialchars($_POST['postcode'])?>">
					</label>
				</div>
				<div class="medium-6 columns">

					<label>City
						<input maxlength="16" name="city" type="text" value="<?php if(!empty($_POST['city'])) echo htmlspecialchars($_POST['city'])?>">
					</label>
				</div>
			</div>

			<div class="row">

				<div class="medium-12 columns">

					<label>Country
						<select name="country">
							<?php foreach($countries as $abbrev => $country): ?>
							<option value="<?= $abbrev ?>"><?= $country ?></option>
							<?php endforeach; ?>
						</select>
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
