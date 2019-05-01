<!-- site header -->
<?php include_once 'includes/header.php'; ?>
<div class="row mt-3">
	<div class="col-md-8" >
		 
		<div class="postside mt-5">
			<div class="post_side_main">
				<h4>News</h4>
			</div>
		</div>
		
		<!-- post -->
		<div class="post mt-5 mb-2">
			
			<?php
			require_once 'admin/config/db.php';
			@$read_more_id = $_GET['id'];

			$query = "SELECT * FROM `news` WHERE `news`.`id` = :id";
			$stmt = $conn->prepare($query);
			$stmt->execute([':id'=>$read_more_id]);
			if ($stmt->rowCount()>0) {
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   foreach ($rows as $key=>$values) {
                      
               
			?>
			<div class="row mb-4">


             <div>
             	<h3 class="p-5" ><?= $rows[$key]['title']; ?></h3> 
             </div>
					<br> <br> <hr>

				<div class="col-md-12" >
					<img src="admin/images/<?= $rows[$key]['image']; ?>" class="img-fluid img-thumbnail" alt="<?= $rows[$key]['title']; ?>">
				</div>
				
				<div class="col-md-12">
					
					<span class="d-flex justify-content-end">Date: <?=$rows[$key]['date']; ?></span>
					<p class="mt-2 text-justify"> <?= $rows[$key]['descriptions'] ; ?></p>
					 
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