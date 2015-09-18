<table class="table table-hover tablesorter">
              	<?php if (!empty($dataItem)) { ?>
                <thead>
                  <tr>
                  	<th class="header">Id<!--<i class="fa fa-sort"></i> --></th>
                    <th class="header">User Name</th>
                    <th class="header">Full Name</th>
                    <th class="header">Email</th>
                    <th class="header">Mobile</th>
                    <th class="header">Company Name</th>
                    <th class="header"></th>
                  </tr>
                </thead>
                <tbody>
                   <?php 
                       
                       foreach($dataItem as $item) {?>
	                  <tr>
	                  	<td><?php echo $item['id'];?></td>
	                    <td><?php echo $item['username'];?></td>
	                    <td><?php echo $item['fullname'];?></td>
	                    <td><?php echo $item['email'];?></td>
	                    <td><?php echo $item['mobile'];?></td>
	                    <td><?php echo $item['company_name'];?></td>
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