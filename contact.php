
<!-- site header -->

<?php include_once 'includes/header.php'; ?>

			<div class="row mt-3">
				<div class="col-md-8" >
					 
					<div class="postside mt-5">
						<div class="post_side_main">
				             <h4>Contact us </h4>
						</div>
					</div>
					
					 <div class="row">
					    <div class="col-md-12">
					    	<form action="" method="POST" id="sendmessage">
					    	         <div class="form-group">
									    <label for="name">Name:</label>
									    <input type="text" class="form-control" id="name" name="name" placeholder="your name" required>
									  </div>

									    <div class="form-group">
											    <label for="email">Email address:</label>
											    <input type="email" class="form-control" name="email" id="email" placeholder="email address" required>
											    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
									    </div>

									      <div class="form-group">
										    <label for="contact">Contact:</label>
										    <input type="number" placeholder="valid phone number" class="form-control" id="phone" required name="phone">
										  </div>

										  <div class="form-group">
										  	<label for="message">Message:</label>
										  	<textarea required style="margin-top: 0px; margin-bottom: 0px; height: 171px;resize: none;" class="form-control" name="message" id="message" placeholder="write your message to feedback"></textarea>

										  </div>

										  <div class="d-flex justify-content-start">
					                         	<output id="displaymessage">  </output>
										  	
										  </div>

										  <div class="d-flex justify-content-end form-group">
										  	<button type="submit" name="sendmessage" class="btn btn-danger btn-lg">Send</button>
										  </div>
					    	</form>
					    </div>	
	                 </div>

					</div>
 <?php include_once 'includes/sidebar.php'; ?>
				</div>

<!-- footewer -->
<?php include_once 'footer.php'; ?>

<script>
	$(function() {
		$("#sendmessage").on('submit',  function(event) {
			event.preventDefault();
		 
			  $.ajax({
			  	url:'messagesent.php' ,
			  	method: 'POST',
			  	dataType: 'json',
			  	data: $(this).serialize(),
			  	success: function (response) { 
			  		console.log(response);
                    if (response.status==true) {
                    	$("#displaymessage").addClass('text-primary');
                    	 
                    	$("#displaymessage").html(response.message);
                    	$("#sendmessage").trigger('reset');
                    } else if (response.status==false) {
                    	$("#displaymessage").addClass('text-danger');
                    	$("#displaymessage").html(response.message);
                    }
			  	},
			  	error: function (error) {
			  		console.error(error);
			  	}
			  });
			  

		});
	});
</script>