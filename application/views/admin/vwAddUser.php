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
            <h1>Company <small>Add Users Module</small></h1>
            <ol class="breadcrumb">
              <li><a href="/admin/users/"><i class="icon-dashboard"></i> Users</a></li>
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
				  	<input type="hidden" id="isChangePass" name="isChangePass" value="<?php echo empty($isChangePass)? '0' : $isChangePass;?>">
				    <label for="username">User Name:</label>
				    <input type="text" class="form-control" id="username" name="username" value="<?php echo @$username;?>" maxlength='255'>
				    <?php if (empty($id)) { ?>
					    <label for="password">Password:</label>
					    <input type="password" class="form-control" id="password" name="password" value="" maxlength='255'>
					    <label for="new_password">Confirm Password:</label>
					    <input type="password" class="form-control" id="new_password" name="new_password" value="" maxlength='255'>					    
				    <?php } else {?>
				    	<br/>
				    	<button type="button" class="btn btn-primary" name="btnChangePass" id="btnChangePass" value="Change Password">Change Password</button>
				    	<br/><br/>
				    	<div id='changePass'> 
					    	<label for="old_password">Old Password:</label>
						    <input type="password" class="form-control" id="old_password" name="old_password" value="" maxlength='255'>
					    	<label for="new_password">New Password:</label>
						    <input type="password" class="form-control" id="new_password" name="new_password" value="" maxlength='255'>						    
					    	<label for="password">Confirm New Password:</label>
						    <input type="password" class="form-control" id="password" name="password" value="" maxlength='255'>
					    </div>					    
				    <?php }?>	
				    <label for="fullname">Full Name:</label>
				    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo @$fullname;?>" maxlength='255'>				    				    
				    <label for="email">Email:</label>
				    <input type="text" class="form-control" id="email" name="email" value="<?php echo @$email;?>" maxlength='255'>
				    <label for="mobile">Mobile:</label>
				    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo @$mobile;?>" maxlength='14'>
				    <label for="company_id">Company Name:</label>
				     <?php echo form_dropdown("company_id", $arrCommpany, @$company_id, " id='company_id' class='form-control' "); ?>				    				    				    
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
			<?php if (empty($isChangePass) || $isChangePass == '0') {?>
				$('#changePass').hide();
				$('#btnChangePass').html('Change Password');
			<?php } else {?>
				$('#changePass').show();
				$('#btnChangePass').html('Unchange Password');
			<?php } ?>
			$('#btnChangePass').click(function(){
				if ($('#changePass').is(':visible')) {
					$('#btnChangePass').html('Change Password');
					$('#changePass').hide();
					$('#isChangePass').val('0'); // not change pass
				} else {
					$('#btnChangePass').html('Unchange Password');
					$('#isChangePass').val('1'); // change pass
					$('#changePass').show();
				}
				
			});
		});
		
</script>