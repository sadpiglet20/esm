<table class="table table-hover tablesorter">
              	<?php if (!empty($dataItem)) { ?>
                <thead>
                  <tr>
                  	<th class="header">Id<!--<i class="fa fa-sort"></i> --></th>
                    <th class="header">Group Name</th>
                    <th class="header">Description</th>
                    <th class="header"></th>
                  </tr>
                </thead>
                <tbody>
                   <?php                        
                       foreach($dataItem as $item) {?>
	                  <tr>
	                  	<td><?php echo $item['id'];?></td>
	                    <td><?php echo $item['group_name'];?></td>
	                    <td><?php echo $item['description'];?></td>
	                    <td></td>
	                    <td>
	                    	<button type="button" class="btn btn-primary" id="em_<?php echo $item['id'];?>">Manage Emails</button>
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