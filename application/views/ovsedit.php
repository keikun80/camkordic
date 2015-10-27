<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="<?php echo $actionUpdUrl;?>" method="post">
        <table class="table">
          <col width="15%" />
          <col width="85%" />
          <tr>
            <td>Customer Name</td>
            <td><input type="text" name="cusName" id="cusName" class="" required /></td>
          </tr>
          <tr>
            <td>Customer Email</td>
            <td><input type="email"  name="cusEmail" id="cusEmail" required /></td>
          </tr>
          <tr>
            <td>Customer Mobile</td>
            <td><input type="text" name="cusMobile" id="cusMobile" required /></td>
          </tr>
          <tr>
            <td>Departure Date</td>
            <td><input type="text" name="departDate" id="departDate" required /></td>
          </tr>
          <tr>
            <td>Return Date</td>
            <td><input type="text" name="returnDate" id="returnDate" required /></td>
          </tr>
          <tr>
            <td>Payment Date</td>
            <td><input type="text" name="paymentDate" id="paymentDate" /></td>
          </tr>
          <tr>
            <td>Booking Date</td>
            <td><input type="text" name="bookingDate" id="bookingDate" required /></td>
          </tr>
          <tr>
            <td>Open Date</td>
            <td><input type="text" name="openDate" id="openDate" /></td>
          </tr>
          <tr>
            <td>Tour Service</td>
            <td><input type="text" name="torKey" id="torKey" required />
                <button id="torsearch"> Find Tour </button>
            </td>
          </tr>
          <tr>
            <td>Organiztion</td>
            <td><input type="text" name="orgKey" id="orgKey" required />
                <button id="torsearch"> Find Organization </button>
              </td>
          </tr>
          <tr>
            <td>Amount</td>
            <td><input type="text" name="amount" id="amount" required /></td>
          </tr>
          <tr>
            <td>Number of People</td>
            <td><input type="text" name="nop" id="nop" required /></td>
          </tr>
          <tr>
            <td>Payment</td>
            <td><select name="isPayment" id="isPayment">
                <option value="n" selected>UN-PAID</option>
                <option value="y">PAID</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Open</td>
            <td><select name="isOpen" id="isOpen">
                <option value="n" selected>Close</option>
                <option value="y">Open</option>
              </select>
            </td>
          </tr>
        </table>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit"><?php echo $buttonDesc;?>  </button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready( function (){
  $('#departDate').datepicker({ dateFormat : "d M, y"});
  $('#returnDate').datepicker({ dateFormat : "d M, y"});
  $('#paymentDate').datepicker({ dateFormat : "d M, y"});
  $('#openDate').datepicker({ dateFormat : "d M, y"});
  $('#bookingDate').datepicker( { dateFormat :"d M, y"});
});
</script>
