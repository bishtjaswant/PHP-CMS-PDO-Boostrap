<?php require_once 'admin/config/db.php'; ?>

<!-- site header -->

<?php include_once 'includes/header.php'; ?>


			<div class="row mt-3">
				<div class="col-md-8" >
					 
							<div class="postside mt-5">
								<div class="post_side_main">
									<?php if (isset($_GET['search'])): ?>
										<h6> Search result for <?= $_GET['search']; ?>	</h6>
									<?php endif ?>
						             
								</div>
							</div>

					<div class="result d-flex justify-content-end mt-3">
						<?php 
            $query = "SELECT * FROM `news` WHERE `news`.`title` LIKE :search_text  ";
			$stmt = $conn->prepare($query);
			$search = $_GET['search'];
			$stmt->execute(array(':search_text' => '%'.$search.'%'));
			 
             $count = $stmt->rowCount();  
               if ($stmt->rowCount()>0) {
               	 echo '<span class="badge badge-danger">'. $count .'</span><p>Search Result Found</p>';
                               
                               $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                               foreach ($rows as $key=>$value) {
                        

						 ?>
						
					</div>
					
					<!-- post -->
					<div class="post mt-5 mb-2">
					 
					 
						<div class="row">
							<div class="col-md-6" >
								<img src="admin/images/<?=  $rows[$key]['image']; ?>" class="img-fluid img-thumbnail" alt="admin post">
							</div>
							<div class="col-md-6">
								 	<h3><?= $rows[$key]['title']; ?></h3>
					<span class="d-flex justify-content-end">Date: <?= $rows[$key]['date']; ?></span>
					<p class="mt-2 text-justify"> <?= substr($rows[$key]['descriptions'],0,289); ?></p>
					<div class="d-flex justify-content-end">
						<a href="view-news.php?id=<?= $rows[$key]['id']; ?>" class="btn btn-sm btn-outline-primary ">Read more</a>
					</div>
							</div>
							</div>				<!--  -->
					 
						<?php 	
                       }
			          }	else {
               	 echo '<script> window.location.assign("http://localhost/NEWS/search.php?error=result not found for <strong>'.$search.'</strong> please try another keyword")</script>';
               }

                ?>
					

</div>

</div>
 	<?php include_once 'includes/sidebar.php'; ?>

				</div>

<!-- footewer -->
<?php include_once 'footer.php'; ?>