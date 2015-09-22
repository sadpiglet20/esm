<style>
	.current11{
		font-weight: bolder;
		text-decoration: none;
	}
	#paging_link a{
		text-decoration: none;
	}
</style>
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
            <h1>Customer <small>Import Customer Module</small></h1>
            <ol class="breadcrumb">
              <li><a href="/admin/customer/"><i class="icon-dashboard"></i> Customer</a></li>
              <li class="active"><i class="icon-file-alt"></i> Import</li>
              
              <div style="float:right;" >
	              <!-- <button class="btn btn-primary" type="button" id="customer_import">Import</button> -->
              </div>
              <div style="clear: both;"></div>
            </ol>
          </div>
        </div><!-- /.row -->
            <div class="table-responsive" id='box'>
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
               <form role="form" action="" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				  	<div class="alert alert-warning">
					  <strong>Warning!</strong> Only accept excel (*.xls), correct format <u><i data-toggle="tooltip" title="Colum 1:SEQ,Colum 2:Name,Colum 3:Email,Colum 4:Phone,Colum 5:Description">hover here for more details</i></u>
					</div>
		        	<input type="hidden" value="<?php echo $user_id;?>" id="user_id" name="user_id">
				    <label for="fName">File Name:</label>
				    <span class="btn btn-primary btn-file">
				        Browse <input type="file" id="fName" name="fName">
				    </span>
				  </div>
				  <button type="submit" class="btn btn-default" name="submit" value="Submit">Import</button>
				</form>
            </div>            
      </div><!-- /#page-wrapper -->

<?php
$this->load->view('admin/vwFooter');
?>
<script type="text/javascript" language="javaScript">
		$(document).ready(function() {
			if (typeof jQuery.fn.live == 'undefined' || !(jQuery.isFunction(jQuery.fn.live))) {
			  jQuery.fn.extend({
			      live: function (event, callback) {
			         if (this.selector) {
			              jQuery(document).on(event, this.selector, callback);
			          }
			      }
			  });
			}			
			/*$('#add_new_product').click(function(){
				window.location.href = '/admin/customer/add_customer';
			}); */
		});
</script>