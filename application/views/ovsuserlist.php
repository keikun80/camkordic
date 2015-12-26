<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">Open Voucher Management</div>
    <div class="panel-body">
 		<table class="table">
     	<tr>
      		<td>NAME </td>
         	<td>Email</td>
         	<td>Domain</td>
			<td>Active</td>
       	</tr>
          <?php
          foreach ($result->result() as $row)
          {
            echo '<tr>';
              echo '<td><a href="'.$linkurl.'/'.$row->usrKey.'">'.$row->usrName.'</a></td>';
              echo '<td><a href="'.$linkurl.'/'.$row->usrKey.'">'.$row->usrEmail.'</a></td>';
              echo '<td>'.$row->usrDomain.'</td>';
              echo '<td>'. ($row->isDel == 'y' ? 'DELETE' : 'ACTIVE').'</td>'; 
            echo '</tr>';
          }
          ?>
        </table>
    </div>
  </div>
  <?php echo $this->pagination->create_links(); ?>
</div>
<script>
$(document).ready(function(){
});
</script>
