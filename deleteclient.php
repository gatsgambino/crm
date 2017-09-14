<?php 
include __DIR__."/assets/includes/top_cms.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: viewclients.php');
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	$query = $db->prepare('SELECT * FROM clients WHERE id=:id');
	$query->bindValue(':id', $GET_ID, PDO::PARAM_INT);
	$query->execute();
	$row = $query->fetch();


	if (isset($_POST['choiceNo'])) {
		header('Location: clientprofile.php?id='.$GET_ID.'');
	} 

	if (isset($_POST['choiceYes'])) {

		$query = $db->prepare('DELETE FROM clients WHERE id=:id');
		$query->bindValue(':id', $GET_ID, PDO::PARAM_INT);
		$query->execute();

		$clientDeleted = true;
	}

?>
				<h3>Delete Client</i></h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<?php if($clientDeleted): ?>
		<div class="medium-4 medium-offset-4 text-center">
  			<label class="label success"><h6>Client successfully deleted.</h6></label>
  			<br>
  			<a href="viewclients.php">Return to view clients page</a>
		</div>
		<?php endif; ?>
		<?php if(!$clientDeleted && !$error): ?>
		<table class="unstriped small-12">
			<thead>
				<tr>
			  		<th>Name</th>
			  		<th>Company</th>
			  		<th>Email</th>
			  		<th>Last Modified</th>
			  		<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= htmlspecialchars(ucwords($row['first_name'].' '.$row['last_name'])) ?></td>
					<td><?= HTML(strtolower($row['company'])) ?></td>
					<td><?= htmlspecialchars(strtolower($row['email'])) ?></td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($row['date_modified']))) ?></td>
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
