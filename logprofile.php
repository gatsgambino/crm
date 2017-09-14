<?php 
include __DIR__."/assets/includes/top_cms.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: dashboard.php');
		exit;
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$query = $db->prepare("SELECT * FROM logs WHERE id=:id");
	$query->bindValue(':id', $GET_ID, PDO::PARAM_INT);
	$query->execute();
	$logsRow = $query->fetch();

	$query2 = $db->prepare("SELECT id, first_name, last_name, company FROM clients WHERE id=:id");
	$query2->bindValue(':id', $logsRow['client_assigned_to']);
	$query2->execute();
	$clientsRow = $query2->fetch();

	if (empty($logsRow)) 
	{
		header('Location: dashboard.php');
		exit;
	} 

?>
				<h3>Log Profile</b></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<table class="small-12 medium-6 medium-offset-3">
			<thead>
				<tr>
					<th colspan="2" class="text-center"><h4><b><?= html($logsRow['title']) ?></b></h4></th>
				</tr>
			</thead>
			<tbody>

				<tr>
					<td>Client assigned to:</td>
					<td><a href="clientprofile.php?id=<?= htmlspecialchars($clientsRow['id']) ?>"><?= HTML(ucwords($clientsRow['first_name'].' '.$clientsRow['last_name'])) ?></a></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><?= HTML($logsRow['description']) ?></td>
				</tr>
				<tr>
					<td>Body:</td>
					<td><?= HTML($logsRow['body']) ?></td>
				</tr>
				<?php if(!empty($logsRow['notes'])): ?>
				<tr>
					<td>Notes:</td>
					<td><?= HTML($logsRow['notes']) ?></td>
				</tr>
				<?php else: ?>
				<tr>
					<td>Notes:</td>
					<td>None added</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>Created:</td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($logsRow['date_added']))) ?> by <?= htmlspecialchars(strtolower($logsRow['user_who_created'])) ?></td>
				</tr>
				<?php if(!empty($logsRow['user_who_modified'])): ?>
				<tr>
					<td>Last Modified:</td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($logsRow['date_modified'])))?> by <?= htmlspecialchars(ucwords($logsRow['user_who_modified'])) ?></td>
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
			<a href="viewlogs.php" class="button primary medium-12 columns">View Logs</a>
			<?php if($usersRow['privilege'] == "admin"): ?>
				<a class="button warning medium-6 columns" href="deletelog.php?id=<?= htmlspecialchars($logsRow['id']) ?>">Delete</a>
				<a class="button secondary medium-6 columns" href="editclient.php?id=<?= htmlspecialchars($logsRow['id']) ?>">Edit Log</a>
			<?php endif; ?>
		</div>
	</div>


<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
