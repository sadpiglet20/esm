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
            <h1>Group <small>Manage Group Email Module</small></h1>
            <ol class="breadcrumb">
              <li><a href="/admin/group/"><i class="icon-dashboard"></i> Group</a></li>
              <li class="active"><i class="icon-file-alt"></i> List</li>
              
              <!-- Add New/Edit must check like cus_import-->
              <button class="btn btn-primary" type="button" style="float:right;" id="add_new_product">Add New</button>
              <div style="clear: both;"></div>
            </ol>
          </div>
        </div><!-- /.row -->
            <div class="table-responsive" id='box'>
              <?php echo $this->load->view('admin/vwGroupEmailList');?>
            </div>
        <?php if (!empty($dataItem)) { ?>
        		 <ul class="pagination pagination-sm" id="paging_link">
	             <?php echo $paging_link;?>
	             </ul>
        <?php } ?>
        <form role="form" id="form" name="form" action="" method="post">
        	<input type="hidden" value="" id="id" name="id">
        	<input type="hidden" value="<?php echo $user_id;?>" id="user_id" name="user_id">
        </form>
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
			$('#add_new_product').click(function(){
				window.location.href = '/admin/group/add_group';
			});
			$('[id^="edit_"]').live('click',function() { edit_click(this); return false;});
			$('[id^="delete_"]').live('click',function() { delete_search_click(this); return false; });
			$('[id^="paging_link"] a').live('click',function() { pagination_link_click(this); return false; });
			$('[id^="em_"]').live('click',function() { em_click(this); return false; });
			
		});
		
		function pagination_link_click(elm) {
			var _offset = 0;
				_offset = $(elm).attr('href');
				_offset = _offset.replace("#/", "");
				if (isNaN(_offset)) {
					_offset = 0;
				}
		$.ajax({
				type: "POST",
				url: "<?php echo site_url('admin/ajax/get_group_list/')?>",
				data: {
					num_items: <?php echo ADMIN_PAGE_MAX_RECORD;?>,
					offset: _offset,
					user_id: $('#user_id').val()
				},
				success: function(data) {
					data = $.parseJSON(data);
						$('#box').html(data.item_list);
						$('#paging_link').html(data.paging_link);
						//$('[id^="paging_link"] .active a').each(function(elm){
							//alert(elm.html());
						//});
						// remove all current, only set current for this offset
						
		 		}
			});	
		}		
		
		function edit_click(elm)
		{
			var id = -1;
			if( $(elm).attr('id').indexOf("edit_") != -1 ) {
				id = parseInt($(elm).attr('id').replace("edit_", ""));
				if (isNaN(id)) {
					id = -1;
				}
				$('#id').val(id);
				$(location).attr('href', '/admin/group/add_group/' + $('#id').val());    
			}
		}		
		
		function em_click(elm)
		{
			var id = -1;
			if( $(elm).attr('id').indexOf("em_") != -1 ) {
				id = parseInt($(elm).attr('id').replace("em_", ""));
				if (isNaN(id)) {
					id = -1;
				}
				$('#group_id').val(id);
				$('#form').attr('action', '/admin/group/customer').submit();  
			}
		}
		
		
		function delete_search_click(elm)
		{
			var r = confirm("Do you want to delete this group?");
			if (r == true) {
				var id = -1;
				if( $(elm).attr('id').indexOf("delete_") != -1 ) {
					id = parseInt($(elm).attr('id').replace("delete_", ""));
					if (isNaN(id)) {
						id = -1;
					}
					$('#id').val(id);
					$('#form').submit();   
				}	    
			} 										
		}
</script>