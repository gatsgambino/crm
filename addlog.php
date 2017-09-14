<?php 
include __DIR__."/assets/includes/top_cms.php";

	$query = $db->query("SELECT id, first_name, last_name FROM clients");
	$query->execute();
	$clientsRow = $query->fetchAll();

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$client = $_POST['client'];
		$title  = $_POST['title'];
		$desc   = $_POST['desc'];
		$body   = $_POST['content'];
		$notes  = $_POST['notes'];

		// check if dropdown select is existing id in clients table
		$match = false;
		foreach ($clientsRow as $row) {
			if($client == $row['id']) {
				$match = true;
			}
		}

		// title validation
		if (empty($title)) {
			$error['title']=1;
		} elseif(strlen($title) < 10) {
			$error['title']=2;
		} elseif(strlen($title) > 32) {
			$error['alert']=1;
		} else {}

		// description validation
		if (empty($desc)) {
			$error['desc']=1;
		} elseif (strlen($desc) < 10) {
			$error['desc']=2;
		} elseif(strlen($desc) > 150) {
			$error['alert']=1;
		} else {}

		// content validation
		if (empty($body)) {
			$error['body']=1;
		} elseif (strlen($body) < 10) {
			$error['body']=2;
		} elseif(strlen($body) > 1000) {
			$error['alert']=1;
		} else {}

		if (empty($error) && $match) {
			if(!empty($notes)) {
				$query = $db->prepare("INSERT INTO logs(title, description, body, notes, client_assigned_to, user_who_created)
										VALUES (:title, :description, :body, :notes, :client, :user)");
				$query->execute(array(
					':title' 	   => $title,
					':description' => $desc,
					':body'		   => $body,
					':notes' 	   => $notes,
					':client' 	   => (int)$client,
					':user'		   => strtolower($usersRow['username'])
				));

			} else {
				$query = $db->prepare("INSERT INTO logs(title, description, body, client_assigned_to, user_who_created)
										VALUES (:title, :description, :body, :client, :user)");
				$query->execute(array(
					':title' 	   => $title,
					':description' => $desc,
					':body'		   => $body,
					':client' 	   => (int)$client,
					':user'		   => strtolower($usersRow['username'])
				));
			}
			header('Location: viewlogs.php');
		}
	}


?>
				<h3>Add New Log</h3>
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
			<?php if($error['alert']===1): ?>
			<div class="label alert">
	  			<h6>We encountered an error. Please contact system administrator.</h6>
			</div>
			<?php endif; ?>
			<?php if(isset($match) && !$match): ?>
			<div class="label alert">
	  			<h6>You did not select a client.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Who is this log about?
						<!-- dropdown list of clients -->
						<select name="client">
							<option value="#">Select a client</option>
							<?php foreach ($clientsRow as $row): ?>
							<option value="<?= htmlspecialchars($row['id'])?>"><?= htmlspecialchars(ucwords($row['first_name'].' '.$row['last_name'])) ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				</div>
			</div>

			<?php if($error['title'] === 1): ?>
			<div class="label alert">
	  			<h6>You did not enter a title.</h6>
			</div>
			<?php endif; ?>
			<?php if($error['title'] === 2): ?>
			<div class="label alert">
	  			<h6>You must enter at least 10 characters.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Title
						<input maxlength="32" name="title" type="text" value="<?php if(!empty($_POST['title'])) echo htmlspecialchars($_POST['title'])?>">
					</label>
				</div>
			</div>

			<?php if($error['desc'] === 1): ?>
			<div class="label alert">
	  			<h6>You did not enter a description.</h6>
			</div>
			<?php endif; ?>
			<?php if($error['desc'] === 2): ?>
			<div class="label alert">
	  			<h6>You must enter at least 10 characters.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Description
						<textarea rows="3" maxlength="150" name="desc" type="text"><?php if(!empty($_POST['desc'])) echo htmlspecialchars($_POST['desc'])?></textarea>
					</label>
				</div>
			</div>

			<?php if($error['body'] === 1): ?>
			<div class="label alert">
	  			<h6>You did not enter any log details.</h6>
			</div>
			<?php endif; ?>
			<?php if($error['body'] === 2): ?>
			<div class="label alert">
	  			<h6>You must enter at least 10 characters.</h6>
			</div>
			<?php endif; ?>
			<div class="row">

				<div class="medium-12 columns">

					<label>Log Details
						<textarea rows="10" maxlength="1000" name="content" type="text"><?php if(!empty($_POST['content'])) echo htmlspecialchars($_POST['content'])?></textarea>
					</label>
				</div>
			</div>

			<div class="row">

				<div class="medium-12 columns">

					<label>Additional Notes
						<textarea maxlength="255" name="notes" type="text"><?php if(!empty($_POST['notes'])) echo htmlspecialchars($_POST['notes'])?></textarea>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<input type="submit" class="button secondary expanded" value="Create Log">
				</div>
			</div>
		</form>
		

	</div>



<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
