<?php 
include __DIR__."/assets/includes/top_cms.php";
include __DIR__."/assets/includes/countrydropdownlist.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: dashboard.php');
		exit;
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$query = $db->prepare("SELECT * FROM clients WHERE id=:id");
	$query->bindValue(':id', $GET_ID);
	$query->execute();
	$clientRow = $query->fetch();

	if (empty($clientRow)) {
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
			$firstName     = $_POST['fname'];
			$lastName      = $_POST['lname'];
			$company   	   = $_POST['company'];
			$email 		   = $_POST['email'];
			$contactNumber = $_POST['contactNum'];
			$addressNumber = $_POST['addressNum'];
			$streetName    = $_POST['streetName'];
			$postcode 	   = $_POST['postcode'];
			$city     	   = $_POST['city'];
			$country   	   = $_POST['country'];

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
				$query = $db->prepare('UPDATE clients SET first_name=:fname, last_name=:lname, company=:comp, email=:email, contact_number=:cnum, address_number=:anum, street_name=:sname, postcode=:pcode, city=:city, country=:country, user_who_modified=:uwc, date_modified=Now() WHERE id=:id');
				$query->execute(array(
					':fname'   => strtolower($firstName),
					':lname'   => strtolower($lastName),
					':comp'    => strtolower($company),
					':email'   => strtolower($email),
					':cnum'    => strtolower($contactNumber),
					':anum'    => strtolower($addressNumber),
					':sname'   => strtolower($streetName),
					':pcode'   => strtolower($postcode),
					':city'    => strtolower($city),
					':country' => strtolower($country),
					':uwc'     => strtolower($usersRow['username']),
					':id'      => $GET_ID
				));


				$query = $db->prepare("SELECT * FROM clients WHERE id=:id");
				$query->bindValue(':id', $GET_ID);
				$query->execute();
				$clientRow = $query->fetch();

				// $successMessage = true;
				header('Location: viewclients.php');
			}

		}
	}


?>
				<h3>Edit Client</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<form class="small-8 small-offset-2 medium-6 medium-offset-3" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . htmlspecialchars($GET_ID) ?>">
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
	  			<h6>Client credentials successfully changed.</h6>
			</div>
			<?php endif; ?>
			<?php if($error===6): ?>
			<div class="label alert">
	  			<h6>Client <?= htmlspecialchars(ucwords($_POST['fname'].' '.$_POST['lname'])) ?> already exists.</h6>
			</div>
			<?php endif; ?>

			<div class="row">

				<div class="medium-6 columns">

					<label>First Name
						<input maxlength="32" name="fname" type="text" value="<?php echo (!empty($_POST['fname'])) ? htmlspecialchars($_POST['fname'])
								: ucwords(htmlspecialchars($clientRow['first_name'])); ?>">
					</label>
				</div>
				<div class="medium-6 columns">
					<label>Last Name
						<input maxlength="32" name="lname" type="text" value="<?php echo (!empty($_POST['lname'])) ? htmlspecialchars($_POST['lname'])
								: ucwords(htmlspecialchars($clientRow['last_name'])); ?>">
					</label>
				</div>
			</div>

			<div class="row">

				<div class="medium-12 columns">

					<label>Company
						<input maxlength="24" name="company" type="text" value="<?php echo (!empty($_POST['company'])) ? htmlspecialchars($_POST['company'])
								: ucwords(HTML($clientRow['company'])); ?>">
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
						<input maxlength="1024" name="email" type="text" value="<?php echo (!empty($_POST['email'])) ? htmlspecialchars($_POST['email'])
								: strtolower(htmlspecialchars($clientRow['email'])); ?>">
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
						<input maxlength="16" name="contactNum" type="text" value="<?php echo (!empty($_POST['contactNum'])) ? htmlspecialchars($_POST['contactNum'])
								: ucwords(htmlspecialchars($clientRow['contact_number'])); ?>">
					</label>
				</div>
			</div>
			<div class="row">

				<div class="medium-12 columns">

					<label>Address Number / Building Name
						<input maxlength="24" name="addressNum" type="text" value="<?php echo (!empty($_POST['addressNum'])) ? htmlspecialchars($_POST['addressNum'])
								: ucwords(htmlspecialchars($clientRow['address_number'])); ?>">
					</label>
				</div>
			</div>

			<div class="row">

				<div class="medium-12 columns">

					<label>Street Name
						<input maxlength="24" name="streetName" type="text" value="<?php echo (!empty($_POST['streetName'])) ? htmlspecialchars($_POST['streetName'])
								: ucwords(htmlspecialchars($clientRow['street_name'])); ?>">
					</label>
				</div>
			</div>
			<div class="row">

				<div class="medium-6 columns">

					<label>Post Code
						<input maxlength="16" name="postcode" type="text" value="<?php echo (!empty($_POST['postcode'])) ? htmlspecialchars($_POST['postcode'])
								: ucwords(htmlspecialchars($clientRow['postcode'])); ?>">
					</label>
				</div>
				<div class="medium-6 columns">

					<label>City
						<input maxlength="16" name="city" type="text" value="<?php echo (!empty($_POST['city'])) ? htmlspecialchars($_POST['city'])
								: ucwords(htmlspecialchars($clientRow['city'])); ?>">
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
