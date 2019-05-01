<!-- site header -->
<?php include_once 'includes/header.php'; ?>
<div class="row mt-3">
	<div class="col-md-8" >
		<img src="assets/image/scotland.jpg" style="height: 400px; width: 100%" class="img-thumbnail img-fluid" alt="posts">
		<div class="postside mt-5">
			<div class="post_side_main">
				<h4>Latest Posts</h4>
			</div>
		</div>
		
		<!-- post -->
		<div class="post mt-5 mb-2">
			
			<?php
			require_once 'admin/config/db.php';
			$query = "SELECT * FROM `news` ORDER BY `news`.`id` DESC LIMIT 0,3";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			if ($stmt->rowCount()>0) {
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   foreach ($rows as $key=>$values) {
                      
               
			?>
			<div class="row mb-4">
				<div class="col-md-6" >
					<img src="admin/images/<?= $rows[$key]['image']; ?>" class="img-fluid img-thumbnail" alt="<?= $rows[$key]['title']; ?>">
				</div>
				<div class="col-md-6">
					<h3><?= $rows[$key]['title']; ?></h3>
					<span class="d-flex justify-content-end">Date: <?=$rows[$key]['date']; ?></span>
					<p class="mt-2 text-justify"> <?= substr($rows[$key]['descriptions'],0,289); ?></p>
					<div class="d-flex justify-content-end">
						<a href="view-news.php?id=<?= $rows[$key]['id']; ?>" class="btn btn-sm btn-outline-primary ">Read more</a>
					</div>
				</div>
			</div>
			<?php
		} // foreach end
			} else{
				 echo '<h3 class="text-center" >No news available yet......</h3>';
			}
			?>
			
			
			<!--  -->
		</div>
	</div>
	<?php include_once 'includes/sidebar.php'; ?>
</div>
<!-- footewer -->
<?php include_once 'footer.php'; ?>