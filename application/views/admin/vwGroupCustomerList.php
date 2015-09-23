<table class="table table-hover tablesorter">
              	<?php if (!empty($dataItem)) { ?>
                <thead>
                  <tr>
                  	<th class="header">Id<!--<i class="fa fa-sort"></i> --></th>
                    <th class="header">Customer Name</th>
                    <th class="header">Customer Email</th>
                    <th class="header">Customer Phone</th>
                    <th class="header">Description</th>
                    <th class="header">Select Customer</th>
                  </tr>
                </thead>
                <tbody>
                   <?php 
                       
                       foreach($dataItem as $item) {?>
	                  <tr>
	                  	<td><?php echo $item['id'];?></td>
	                    <td><?php echo $item['customer_name'];?></td>
	                    <td><?php echo $item['customer_email'];?></td>
	                    <td><?php echo $item['customer_phone'];?></td>
	                    <td><?php echo $item['description'];?></td>
	                    <td>
	                    	<div class="checkbox">
							  <input type="checkbox" value="<?php echo $item['id'];?>" name="ids[]">
							</div>
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