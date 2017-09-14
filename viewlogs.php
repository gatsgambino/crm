<?php 
include __DIR__."/assets/includes/top_cms.php";


    $query = $db->query('SELECT COUNT(id) FROM logs');
	$query->execute();
	$num_rows = $query->fetch();


	$amountPerPage = 5;

	$rowsPerPage = ceil($num_rows['COUNT(id)'] / $amountPerPage);

    if (!isset($_GET['page']) || !ctype_digit($_GET['page']) || $_GET['page'] <= 0 || $_GET['page'] > $rowsPerPage) {
        $page1 = 0;
    } else {
        $page1 = ($_GET['page'] * $amountPerPage) - $amountPerPage;
    }

	$query2 = $db->prepare('SELECT id, title, description, date_modified, client_assigned_to FROM logs ORDER BY date_modified DESC LIMIT :page, :amount');
	$query2->bindValue(':page', $page1, PDO::PARAM_INT);
	$query2->bindValue(':amount', $amountPerPage, PDO::PARAM_INT);
    $query2->execute();

?>
				<h3>View Logs</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
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
				<?php while($row = $query2->fetch()): ?>
				<?php 
					$stmt = $db->prepare("SELECT id, first_name, last_name FROM clients WHERE id=:id");
					$stmt->bindValue(':id', $row['client_assigned_to']);
					$stmt->execute();
					$clientsRow = $stmt->fetch();
				?>
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
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($row['date_modified']))) ?></td>
					<td><a class="button primary table-btn" href="logprofile.php?id=<?= htmlspecialchars($row['id']) ?>">View</a></td>
					<td><a class="button secondary table-btn" href="editlog.php?id=<?= htmlspecialchars($row['id']) ?>">Edit</a></td>
					<td><a class="button alert table-btn" href="deletelog.php?id=<?= htmlspecialchars($row['id']) ?>">Delete</a></td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
		
		<ul class="pagination text-center" role="navigation" aria-label="Pagination">
			<?php
                for ($x = 1; $x <= $rowsPerPage; ++$x) {
                	echo "<li><a href='viewclients.php?page=$x'>$x</a></li>";
                }
            ?>
		</ul>

	</div>



<?php include __DIR__."/assets/includes/footer.php"; ?>
</div>
<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>
