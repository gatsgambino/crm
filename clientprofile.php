<?php 
include __DIR__."/assets/includes/top_cms.php";
// included to display country in client profile
include __DIR__."/assets/includes/countrydropdownlist.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: dashboard.php');
		exit;
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$query = $db->prepare("SELECT * FROM clients WHERE id=:id");
	$query->bindValue(':id', $GET_ID, PDO::PARAM_INT);
	$query->execute();
	$clientRow = $query->fetch();

	if (empty($clientRow)) 
	{
		header('Location: dashboard.php');
		exit;
	} 

?>
				<h3>Client Profile</b></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<table class="small-12 medium-6 medium-offset-3">
			<thead>
				<tr>
					<th colspan="2" class="text-center"><h4><b><?= htmlspecialchars(ucwords($clientRow['first_name'].' '.$clientRow['last_name'])) ?></b></h4></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-center"><a href="viewclientlogs.php?id=<?= htmlspecialchars($clientRow['id']) ?>">View all logs corresponding to this client</a></td>
				</tr>
				<tr>
					<td>Company:</td>
					<td><?= html(ucwords($clientRow['company'])) ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?= htmlspecialchars(strtolower($clientRow['email'])) ?></td>
				</tr>
				<tr>
					<td>Contact Number:</td>
					<td><?= htmlspecialchars($clientRow['contact_number']) ?></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><?= htmlspecialchars(ucwords($clientRow['address_number'].' '.$clientRow['street_name'])) ?></td>
				</tr>
				<tr>
					<td>Postcode:</td>
					<td><?= htmlspecialchars(strtolower($clientRow['postcode'])) ?></td>
				</tr>
				<tr>
					<td>Location:</td>
					<td><?= htmlspecialchars(ucwords($clientRow['city'].', '.$countries[strtoupper($clientRow['country'])])) ?></td>
				</tr>
				<tr>
					<?php
						$query2 = $db->prepare('SELECT first_name, last_name FROM users WHERE username=:uname');
						$query2->bindValue(':uname', $clientRow['user_who_created']);
						$query2->execute();
						$userRow = $query2->fetch();
					?>
					<td>Date Added:</td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($clientRow['date_added']))).' by '. htmlspecialchars(ucwords($userRow['first_name'].' '.$userRow['last_name'])) ?></td>
				</tr>
				<?php if(!empty($clientRow['user_who_modified'])): ?>
					<?php
						$query2 = $db->prepare('SELECT first_name, last_name FROM users WHERE username=:uname');
						$query2->bindValue(':uname', $clientRow['user_who_modified']);
						$query2->execute();
						$userRow = $query2->fetch();
					?>
				<tr>
					<td>Last Modified:</td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($clientRow['date_modified']))) .' by '. htmlspecialchars(ucwords($userRow['first_name'].' '.$userRow['last_name'])) ?></td>
				</tr>
				<?php else: ?>
				<tr>
					<td>Last Modified:</td>
					<td>Never</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<div class="small-12 medium-6 medium-offset-3">
			<a href="viewclients.php" class="button primary medium-12 columns">View Clients</a>
			<?php if($usersRow['privilege'] == "admin"): ?>
				<a class="button warning medium-6 columns" href="deleteclient.php?id=<?= htmlspecialchars($clientRow['id']) ?>">Delete</a>
				<a class="button secondary medium-6 columns" href="editclient.php?id=<?= htmlspecialchars($clientRow['id']) ?>">Edit Client</a>
			<?php endif; ?>
		</div>
	</div>


<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
