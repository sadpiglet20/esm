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
            <h1>Company <small>Add Company Module</small></h1>
            <ol class="breadcrumb">
              <li><a href="/admin/company/"><i class="icon-dashboard"></i> Company</a></li>
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
               <form role="form" action="" method="post">
				  <div class="form-group">
				  	<input type="hidden" value="<?php echo @$id;?>" id="id" name="id">
				    <label for="company_name">Company Name:</label>
				    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo @$company_name;?>">
				  </div>
				  <button type="submit" class="btn btn-default" name="submit" value="Submit">Submit</button>
				</form>
            </div>
      </div><!-- /#page-wrapper -->

<?php
$this->load->view('admin/vwFooter');
?>
<script type="text/javascript" language="javaScript">
		$(document).ready(function() {
			
		});
		
</script>