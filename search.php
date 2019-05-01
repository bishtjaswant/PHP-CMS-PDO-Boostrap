<!-- site header -->
<?php include_once 'includes/header.php'; ?>

<div class="row mt-3">
	<div class="col-md-12 mb-5" >
		
		 
			 
				<form action="result.php" method="GET">
					<div class="card">
						<div class="card-header"><h2>Search news</h2></div>
						<div class="card-body">
							<input type="text" name="search" class="form-control" placeholder="search news" id="" required>
							<br>
							<input style="float: right;" type="submit" value="Search" class="btn btn-outline-primary" >
							<?php if (isset($_GET['error'])): ?>
								<p class="text-danger text-capitalize text-center"> <?= $_GET['error'] ?> </p>
							<?php endif ?>
						</div>
					</div>
				</form>
			 
	</div>
</div>
<!-- footewer -->
<?php include_once 'footer.php'; ?>