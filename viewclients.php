<?php 
include __DIR__."/assets/includes/top_cms.php";


    $query = $db->query('SELECT COUNT(id) FROM clients');
	$query->execute();
	$num_rows = $query->fetch();


	$amountPerPage = 5;

	$rowsPerPage = ceil($num_rows['COUNT(id)'] / $amountPerPage);

    if (!isset($_GET['page']) || !ctype_digit($_GET['page']) || $_GET['page'] <= 0 || $_GET['page'] > $rowsPerPage) {
        $page1 = 0;
    } else {
        $page1 = ($_GET['page'] * $amountPerPage) - $amountPerPage;
    }

	$query2 = $db->prepare('SELECT id, first_name, last_name, email, date_modified FROM clients ORDER BY date_modified DESC LIMIT :page, :amount');
	$query2->bindValue(':page', $page1, PDO::PARAM_INT);
	$query2->bindValue(':amount', $amountPerPage, PDO::PARAM_INT);
    $query2->execute();

?>
				<h3>View Clients</h3>
				<hr>
			</div>
		</div>
	</div>
	<!-- content start -->
	<div class="row">
		<table class="unstriped small-12">
			<thead>
				<tr>
			  		<th>Name</th>
			  		<th>Email</th>
			  		<th>Last Modified</th>
		  			<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<?php while($row = $query2->fetch()): ?>
				<tr>
					<td><?= htmlspecialchars(ucwords($row['first_name'].' '.$row['last_name'])) ?></td>
					<?php if(strlen($row['email']) > 12): ?>
					<td><?= htmlspecialchars(strtolower(substr($row['email'], 0, 12).'...')) ?></td>
					<?php else: ?>
					<td><?= htmlspecialchars(strtolower($row['email'])) ?></td>
					<?php endif; ?>
					<td><?= htmlspecialchars(date("d M Y g:ia", strtotime($row['date_modified']))) ?></td>
					<td><a class="button primary table-btn" href="clientprofile.php?id=<?= htmlspecialchars($row['id']) ?>">View</a></td>
						<td><a class="button secondary table-btn" href="editclient.php?id=<?= htmlspecialchars($row['id']) ?>">Edit</a></td>
						<td><a class="button alert table-btn" href="deleteclient.php?id=<?= htmlspecialchars($row['id']) ?>">Delete</a></td>
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
