<?php 
include __DIR__."/assets/includes/top_cms.php";

	if (empty($_GET['uname']) || !is_string($_GET['uname'])) {
		header('Location: viewusers.php');
	}

	$GET_USERNAME = filter_var($_GET['uname'], FILTER_SANITIZE_STRING);

	$query = $db->prepare('SELECT * FROM users WHERE username=:uname');
	$query->bindValue(':uname', $GET_USERNAME, PDO::PARAM_STR);
	$query->execute();
	$row = $query->fetch();


	if (isset($_POST['choiceNo'])) {
		header('Location: userprofile.php?uname='.$GET_USERNAME.'');
	} 

	if (isset($_POST['choiceYes'])) {
		if ($row['username'] != $usersRow['username']) {

			$query = $db->prepare('DELETE FROM users WHERE username=:uname');
			$query->bindValue(':uname', $GET_USERNAME, PDO::PARAM_STR);
			$query->execute();

			$userDeleted = true;
		} else {
			$error = 1;
		}
	}

?>
				<h3>Delete User</i></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<?php if($error===1): ?>
		<div class="medium-4 medium-offset-4 text-center">
  			<label class="label alert"><h6>You can not delete your own account.</h6></label>
  			<br>
  			<a href="viewusers.php">Return to view users page</a>
		</div>
		<?php endif; ?>
		<?php if($userDeleted): ?>
		<div class="medium-4 medium-offset-4 text-center">
  			<label class="label success"><h6>Account successfully deleted.</h6></label>
  			<br>
  			<a href="viewusers.php">Return to view users page</a>
		</div>
		<?php endif; ?>
		<?php if(!$userDeleted && !$error): ?>
		<table class="unstriped small-12">
			<thead>
				<tr>
			  		<th>Name</th>
			  		<th>Username</th>
			  		<th>Email</th>
			  		<th>Date Created</th>
			  		<th>Privilege</th>
			  		<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= htmlspecialchars(ucwords($row['first_name'].' '.$row['last_name'])) ?></td>
					<td><?= htmlspecialchars(strtolower($row['username'])) ?></td>
					<td><?= htmlspecialchars(strtolower($row['email'])) ?></td>
					<td><?= htmlspecialchars(date("d M Y", strtotime($row['created']))) ?></td>
					<td><b><?= htmlspecialchars(ucwords(strtolower($row['privilege']))) ?></b></td>
				</tr>
			</tbody>
		</table>

		<form class="" method="post" action="">
			<div class=" small-12 medium-6 medium-offset-3 columns">
				<label class=""><h5>Are you sure you want to delete this user?</h5></label>
				<button class="button alert medium-6 columns" name="choiceYes">Yes</button>
				<button class="button primary medium-6 columns" name="choiceNo">No</button>
			</div>
		</form>
		<?php endif; ?>

	</div> <!-- end row -->


<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
