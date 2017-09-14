<?php 
include __DIR__."/assets/includes/top_cms.php";
?>
				<h3>Dashboard</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
	
		<table class="small-12 medium-6 medium-offset-3">
			<thead>
				<tr>
					<?php if(!empty($usersRow['login_token'])): ?>
						<th colspan="2" class="text-center"><h4><b>Welcome back <?= htmlspecialchars(ucwords($usersRow['first_name'])); ?></b></h4></th>
					<?php else: ?>
						<th colspan="2" class="text-center"><h4><b><i>Welcome to your dashboard!</i></b></h4></th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Name:</td>
					<td><?= htmlspecialchars(ucwords($usersRow['first_name'].' '.$usersRow['last_name'])) ?></td>
				</tr>
				<tr>
					<td>Username:</td>
					<td><?= htmlspecialchars(strtolower($usersRow['username'])) ?></td>
				</tr>
				<tr>
					<td>Privilege:</td>
					<td><?= htmlspecialchars(ucwords($usersRow['privilege'])) ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?= htmlspecialchars(strtolower($usersRow['email'])) ?></td>
				</tr>
				<tr>
					<td>Date Created:</td>
					<td><?= htmlspecialchars(date("d M Y", strtotime($usersRow['created']))) ?></td>
				</tr>
				<tr>
					<td>Last Login:</td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($usersRow['last_login']))) ?></td>
				</tr>
			</tbody>
		</table>

		<div class="small-6 small-offset-3">
			<a class="button secondary expanded" href="settings.php">Settings</a>
		</div>

	</div>


<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
