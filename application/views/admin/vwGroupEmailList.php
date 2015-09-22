<table class="table table-hover tablesorter">
              	<?php if (!empty($dataItem)) { ?>
                <thead>
                  <tr>
                    <th class="header">Customer Name</th>
                    <th class="header">Customer Email</th>
                    <th class="header">Customer Phone</th>
                    <th class="header"></th>
                  </tr>
                </thead>
                <tbody>
                   <?php 
                       
                       foreach($dataItem as $item) {?>
	                  <tr>
	                  	<td><?php echo $item['customer_name'];?></td>
	                  	<td><?php echo $item['customer_email'];?></td>
	                  	<td><?php echo $item['customer_phone'];?></td>
	                    <td>
	                    	<button type="button" class="btn btn-primary" id="edit_<?php echo $item['id'];?>">Edit</button>
	                    	<button type="button" class="btn btn-primary" id="delete_<?php echo $item['id'];?>">Delete</button>
	                    </td>
	                  </tr>
                  <?php } ?> 
                </tbody>
                <?php } else {?>
                  		<tr>
		                  	<td></td>
		                    <td>No data found</td>
		                    <td>
	                    </td>
	                  </tr>
                  <?php } ?>
              </table>