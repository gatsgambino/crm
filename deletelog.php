<?php 
include __DIR__."/assets/includes/top_cms.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: viewlogs.php');
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$query = $db->prepare('SELECT * FROM logs WHERE id=:id');
	$query->bindValue(':id', $GET_ID, PDO::PARAM_STR);
	$query->execute();
	$logsRow = $query->fetch();

	$query2 = $db->prepare('SELECT id, first_name, last_name FROM clients WHERE id=:id');
	$query2->bindValue(':id', $logsRow['client_assigned_to']);
	$query2->execute();
	$clientsRow = $query2->fetch();

	if (isset($_POST['choiceNo'])) {
		header('Location: logprofile.php?id='.$GET_ID.'');
	} 

	if (isset($_POST['choiceYes'])) {

		$query = $db->prepare('DELETE FROM logs WHERE id=:id');
		$query->bindValue(':id', $GET_ID, PDO::PARAM_STR);
		$query->execute();

		$userDeleted = true;
	}

?>
				<h3>Delete Log</i></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<?php if($userDeleted): ?>
		<div class="medium-4 medium-offset-4 text-center">
  			<label class="label success"><h6>Account successfully deleted.</h6></label>
  			<br>
  			<a href="viewlogs.php">Return to view users page</a>
		</div>
		<?php endif; ?>
		<?php if(!$userDeleted && !$error): ?>
		<table class="unstriped small-12">
			<thead>
				<tr>
			  		<th>Title</th>
			  		<th>Description</th>
			  		<th>Client</th>
			  		<th>Last Modified</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= htmlspecialchars(ucwords($logsRow['title'])) ?></td>
					<td><?= htmlspecialchars($logsRow['description']) ?></td>
					<td><a href="clientprofile.php?id=<?= htmlspecialchars($clientsRow['id']) ?>"><?= htmlspecialchars(ucwords($clientsRow['first_name'].' '.$clientsRow['last_name'])) ?></a></td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($logsRow['date_modified']))) ?></td>
				</tr>
			</tbody>
		</table>

		<form class="" method="post" action="">
			<div class=" small-12 medium-6 medium-offset-3 columns">
				<label class=""><h5>Are you sure you want to delete this log?</h5></label>
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
