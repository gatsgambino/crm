<?php 
include __DIR__."/assets/includes/top_cms.php";

	if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
		header('Location: dashboard.php');
		exit;
	}

	$GET_ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = $db->prepare('SELECT COUNT(id) FROM logs WHERE client_assigned_to=:id');
    $query->bindValue(':id', $GET_ID);
	$query->execute();
	$num_rows = $query->fetch();


	$amountPerPage = 5;

	$rowsPerPage = ceil($num_rows['COUNT(id)'] / $amountPerPage);

    if (!isset($_GET['page']) || !ctype_digit($_GET['page']) || $_GET['page'] <= 0 || $_GET['page'] > $rowsPerPage) {
        $page1 = 0;
    } else {
        $page1 = ($_GET['page'] * $amountPerPage) - $amountPerPage;
    }

	$query2 = $db->prepare('SELECT * FROM logs WHERE client_assigned_to=:id ORDER BY date_added DESC LIMIT :page, :amount');
	$query2->bindValue(':id', $GET_ID);
	$query2->bindValue(':page', $page1, PDO::PARAM_INT);
	$query2->bindValue(':amount', $amountPerPage, PDO::PARAM_INT);
    $query2->execute();
    $logsRow = $query2->fetchAll();


	$query3 = $db->prepare('SELECT * FROM clients WHERE id=:id');
	$query3->bindValue(':id', $GET_ID);
    $query3->execute();
    $clientsRow = $query3->fetch();

    if(empty($logsRow) || empty($clientsRow)) {
    	header('Location: dashboard.php');
    }
?>
				<h3>View Client Logs</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<h5 class="text-center">Showing logs for <?= htmlspecialchars(ucwords($clientsRow['first_name'].' '.$clientsRow['last_name'])) ?></h5>
		<br>
		<table class="unstriped small-12">
			<thead>
				<tr>
			  		<th>Title</th>
			  		<th>Description</th>
			  		<th>Client</th>
			  		<th>Last Modified</th>
		  			<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($logsRow as $row): ?>
				<tr>
					<?php if(strlen($row['title']) > 16): ?>
					<td><?= HTML(ucwords(substr($row['title'], 0, 16).'...')) ?></td>
					<?php else: ?>
					<td><?= HTML(ucwords(filter_var($row['title'], FILTER_SANITIZE_STRING))) ?></td>
					<?php endif; ?>
					<?php if(strlen($row['description']) > 24): ?>
					<td><?= HTML(ucwords(substr($row['description'], 0, 24).'...')) ?></td>
					<?php else: ?>
					<td><?= HTML($row['description']) ?></td>
					<?php endif; ?>
					<td><a href="clientprofile.php?id=<?= htmlspecialchars($clientsRow['id']) ?>"><?= htmlspecialchars(ucwords($clientsRow['first_name'].' '.$clientsRow['last_name'])) ?></a></td>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($row['date_added']))) ?></td>
					<td><a class="button primary table-btn" href="logprofile.php?id=<?= htmlspecialchars($row['id']) ?>">View</a></td>
					<td><a class="button secondary table-btn" href="editlog.php?id=<?= htmlspecialchars($row['id']) ?>">Edit</a></td>
					<td><a class="button alert table-btn" href="deletelog.php?id=<?= htmlspecialchars($row['id']) ?>">Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<ul class="pagination text-center" role="navigation" aria-label="Pagination">
			<?php
                for ($x = 1; $x <= $rowsPerPage; ++$x) {
                	echo "<li><a href='viewclientlogs.php?id=$GET_ID&page=$x'>$x</a></li>";
                }
            ?>
		</ul>

	</div>



<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
