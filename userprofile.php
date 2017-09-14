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

	$username = $_GET['uname'];

	$query = $db->prepare("SELECT * FROM users WHERE username=:uname");
	$query->bindValue(':uname', $username, PDO::PARAM_STR);
	$query->execute();
	$userRow = $query->fetch();

	if (empty($userRow)) 
	{
		header('Location: dashboard.php');
		exit;
	} 

?>
				<h3>User Profile</b></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<table class="small-12 medium-6 medium-offset-3">
			<thead>
				<tr>
					<th colspan="2" class="text-center"><h4><b><?= htmlspecialchars(ucwords($userRow['first_name'].' '.$userRow['last_name'])) ?></b></h4></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Username:</td>
					<td><?= htmlspecialchars(strtolower($userRow['username'])) ?></td>
				</tr>
				<tr>
					<td>Privilege:</td>
					<td><?= htmlspecialchars(ucwords($userRow['privilege'])) ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?= htmlspecialchars(strtolower($userRow['email'])) ?></td>
				</tr>
				<tr>
					<td>Last Login:</td>
					<?php if(!empty($userRow['login_token'])): ?>
						<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($userRow['last_login']))) ?></td>
					<?php else: ?>
						<td>No previous login</td>
					<?php endif; ?>
				</tr>
				<tr>
					<td>Date Created:</td>
					<td><?= htmlspecialchars(date("d M Y", strtotime($userRow['created']))) ?></td>
				</tr>
			</tbody>
		</table>
		<div class="small-6 small-offset-3">
			<a class="button warning medium-6 columns" href="deleteuser.php?uname=<?= htmlspecialchars($userRow['username']) ?>">Delete</a>
			<a class="button secondary medium-6 columns" href="edituser.php?uname=<?= htmlspecialchars($userRow['username']) ?>">Edit User</a>
		</div>
	</div>


<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
