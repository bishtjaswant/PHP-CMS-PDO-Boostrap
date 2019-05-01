<?php require_once 'admin/config/db.php'; ?> 
					<div class="col-md-4">
						<div class="side">
							<div class="side_main">
								<h2>Recent News</h2>
							</div>
						</div>
						<div class="overflow">
							
						  <?php 
							
									$query = "SELECT * FROM `news` ORDER BY `news`.`id` DESC LIMIT 0,3";
									$stmt = $conn->prepare($query);
									$stmt->execute();

									if ($stmt->rowCount()>0) {
										    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

										    foreach ($rows  as $key=> $value) {
										    	
										 
                                      ?>
		                    
		                    <div class="row mt-3">
								<div class="col-md-4">
									<img src="admin/images/<?= $rows[$key]['image']; ?>" alt="latest post" class="img-thumbnail"
									style="height: 80px; width: 100px;">
								</div>
								<div class="col-md-8">
									<p  class="text-justify"> <a href="view-news.php?id=<?= $rows[$key]['id'];  ?>"> <?= substr($rows[$key]['descriptions'],0,100); ?> </a>  </p>
								</div>
							</div>
							 
				

							<?php 
							   } // foreach loop
									}
									else {
										echo '	<h4 class="text-center mt-5 text-danger text-uppercase">no recent news </h4> ';
									}

									 ?>




						</div>
						<br><br><br>
						<!--  -->
						<div class="side">
							<div class="side_main">
								<h4>Latest Categories</h4>
							</div>
						</div>
						
						<div class="category">

							<?php
	                              $query = "SELECT * FROM `categories` ORDER BY `categories`.`id` DESC LIMIT 0,10 ";
									$stmt = $conn->prepare($query);
									$stmt->execute();

									if ($stmt->rowCount()>0) {
										    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($rows as $key =>$value) {
                                                	
                                            
							 ?>
							<a href="all-news.php?id=<?= $rows[$key]['id'];?>">  <?= $rows[$key]['name']; ?></a> 

							<?php     }//FOREACCH LOOP
                                     }else {
                                     	echo 'no categories available now';
                                     }
                                   ?>
						</div>
						
					</div> 