<?php
$this->load->view('admin/vwHeader');
?>
<!--  
Author : Abhishek R. Kaushik 
Downloaded from http://devzone.co.in
-->

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Customer <small>Add Customer Module</small></h1>
            <ol class="breadcrumb">
              <li><a href="/admin/customer/"><i class="icon-dashboard"></i> Customer</a></li>
              <li class="active"><i class="icon-file-alt"></i> Insert/Update</li>
              <div style="clear: both;"></div>
            </ol>
          </div>
        </div><!-- /.row -->
            <div class="table-responsive">
            	<?php 
            		$error = validation_errors();
					if (!empty($error)) {
            	?>
            	<div class="alert alert-danger">
            	  <?php 
					 echo validation_errors();
				  ?>
				</div>
				<?php } ?>
				<?php if (!empty($sucessMsg)) {?>
					<div class="alert alert-success">
						<?php echo $sucessMsg;?>
					</div>
				<?php } ?>
				<?php ?>
				<?php if (!empty($errorMsg)) {?>
					<div class="alert alert-danger">
						<?php echo $errorMsg;?>
					</div>					
				<?php } ?>
				<?php if (empty($notAllowed)) {?>
	               <form role="form" action="" method="post">
					  <div class="form-group">
					  	<input type="hidden" value="<?php echo @$id;?>" id="id" name="id">
					    <label for="customer_name">Name:</label>
					    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo @$customer_name;?>">
					    <label for="customer_email">Email:</label>
					    <input type="text" class="form-control" id="customer_email" name="customer_email" value="<?php echo @$customer_email;?>">
					    <label for="customer_phone">Phone:</label>
					    <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo @$customer_phone;?>">
					    <label for="description">Description:</label>
					    <input type="text" class="form-control" id="description" name="description" value="<?php echo @$description;?>">				    
					  </div>
					  <button type="submit" class="btn btn-default" name="submit" value="Submit">Submit</button>
					</form>
				<?php } ?>
            </div>
      </div><!-- /#page-wrapper -->

<?php
$this->load->view('admin/vwFooter');
?>
<script type="text/javascript" language="javaScript">
		$(document).ready(function() {
			
		});
		
</script>