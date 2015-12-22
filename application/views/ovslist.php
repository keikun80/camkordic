<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">Open Voucher Management</div>
    <div class="panel-body">
      <div class="wall">
        SEARCH OPTION
        <form>
          <label for="keydate" class="sr-only">date type</label>
          Date Type :
            <select id="keydate" name="keydate">
                <option value="pdate">Payment</option>
                <option value="bdate">Booking</option>
                <option value="ddate">Departure</option>
                <option value="odate">Open</option>
            </select>
            <input type="text" name="fromdt" id="fromdt" /> ~ <input type="text" name="todt" id="todt" />
          information :
          <select id="keytype" name="keytype">
              <option value="name">Name</option>
              <option value="email">email</option>
              <option value="mobile">mobile</option>
          </select>
          <input type="text" name="keyword" id="keyword" />
          TOUR:
            <select id="torKey" name="torKey">
            </select>
          ORG :
            <select id="orgKey" name="orgKey">
            </select>
        </form>
      </div>
        <table class="table">
          <tr>
              <td>ID</td>
              <td>Open</td>
              <td>Departure</td>
              <td>Book</td>
              <td>Payment</td>
              <td>Name</td>
              <td>Mobile</td>
              <td>Tour</td>
              <td>ORG</td>
              <td>PAID</td>
          </tr>
          <?php
          foreach ($result->result() as $row)
          {
            echo '<tr>';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->seq.'</a></td>';
              echo '<td>'. ($row->isOpen == 'y' ? 'open' : 'close').'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->departDate)).'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->regDate)).'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->paymentDate)).'</td>';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->cname.'</a></td>';
              echo '<td>'.$row->cmobile.'</td>';
              echo '<td>'.$row->trcode.'</td>';
              echo '<td>'.$row->orgcode.'</td>';
              echo '<td>'. ($row->isPaid == 'y' ? 'PAID' : 'UN-PAID').'</td>';
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
    $('#fromdt').datepicker({
        defaultDate:"+1W",
        changeMonths: true,
        numberOfMonths:3 ,
        dateFormat: "d M, y",
        onClose :function (selectedDate){
          $("#todt").datepicker("option","minDate", selectedDate);
        }
    });
    $('#todt').datepicker({
        defaultDate:"+1W",
        changeMonths: true,
        numberOfMonths:3 ,
        dateFormat: "d M, y",
        onClose :function (selectedDate){
          $("#fromdt").datepicker("option","maxDate", selectedDate);
        }
    });

});
</script>
