<?php
// Edit data implement
$htmlItems = array ('refer' => 'hidden|refer'
                   ,'vocKey' => 'hidden|vocKey'
                   ,'cusName' => 'text|cusName'
                   ,'cusEmail' =>'text|cusEmail'
                   ,'cusMobile' =>'text|cusMobile'
                   ,'departDate' =>'text|departDate'
                   ,'returnDate' =>'text|returnDate'
                   ,'paymentDate' =>'text|paymentDate'
                   ,'bookingDate' =>'text|bookingDate'
                   ,'openDate' => 'text|openDate'
                   ,'torKey' => 'select|tour'
                   ,'orgKey' => 'select|org'
                   ,'amount' => 'text|amount'
                   ,'numofpeo' =>'text|nop'
                   ,'isPaid' => 'select|isPaid'
                   ,'isOpen' => 'select|isOpen');

/* initialize vars */
$vocKey = NULL;
$cusName = NULL;
$cusEmail = NULL;
$cusMobile = NULL;
$departDate = date_parse_from_format('Y-m-d', date('Y-m-d'));
$strDepartDate = $departDate['year'].'-'.$departDate['month'].'-'.$departDate['day'];

$returnDate = date_parse_from_format('Y-m-d', date('Y-m-d'));
$strReturnDate = $returnDate['year'].'-'.$returnDate['month'].'-'.$returnDate['day'];

$paymentDate = date_parse_from_format('Y-m-d', date('Y-m-d'));
$strPaymentDate = $paymentDate['year'].'-'.$paymentDate['month'].'-'.$paymentDate['day'];

$bookingDate = date_parse_from_format('Y-m-d',date('Y-m-d'));
$strBookingDate= $bookingDate['year'].'-'.$bookingDate['month'].'-'.$bookingDate['day'];

$openDate = date_parse_from_format('Y-m-d', date('Y-m-d'));
$strOpenDate = $openDate['year'].'-'.$openDate['month'].'-'.$openDate['day'];

$torKey = NULL;
$orgKey = NULL;
$amount = NULL;
$nop = NULL;
$isPaid = array ('y|PAID|','n|UN-PAID|selected' );
$isOpen = array ('y|OPEN|','n|CLOSE|selected' );


$refer= (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

if(isset($result))
{
  $vocKey = $result->row()->vocKey;
  $cusName = $result->row()->cusName;
  $cusEmail = $result->row()->cusEmail;
  $cusMobile = $result->row()->cusMobile;

  $departDate = date_parse_from_format('Y-m-d', $result->row()->departDate);
  $strDepartDate = $departDate['year'].'-'.$departDate['month'].'-'.$departDate['day'];

  $returnDate = date_parse_from_format('Y-m-d', $result->row()->returnDate);
  $strReturnDate = $returnDate['year'].'-'.$returnDate['month'].'-'.$returnDate['day'];

  $paymentDate = date_parse_from_format('Y-m-d', $result->row()->paymentDate);
  $strPaymentDate = $paymentDate['year'].'-'.$paymentDate['month'].'-'.$paymentDate['day'];

  $bookingDate = date_parse_from_format('Y-m-d', $result->row()->bookingDate);
  $strBookingDate= $bookingDate['year'].'-'.$bookingDate['month'].'-'.$bookingDate['day'];

  $openDate = date_parse_from_format('Y-m-d', $result->row()->openDate);
  $strOpenDate = $openDate['year'].'-'.$openDate['month'].'-'.$openDate['day'];

  $torKey = $result->row()->torKey;
  $orgKey = $result->row()->orgKey;
  $amount = $result->row()->amount;
  $nop = $result->row()->numofpeo;
  $isPaid = array('y|PAID|', 'n|UN-PAID|selected');
  $isOpen = array('y|OPEN|', 'n|CLOSE|selected');

  if($result->row()->isPaid == 'y')
  {
      $isPaid = array('y|PAID|selected', 'n|UN-PAID');
  } else if($result->row()->isPaid == 'n') {
      $isPaid = array('y|PAID|', 'n|UN-PAID|selected');
  } else {
      $isPaid = array('y|PAID|', 'n|UN-PAID|selected');
  }

  if($result->row()->isOpen == 'y')
  {
      $isOpen= array('y|OPEN|selected', 'n|CLOSE');
  } else if($result->row()->isOpen == 'n') {
      $isOpen = array('y|OPEN|', 'n|CLOSE|selected');
  } else {
      $isOpen = array('y|OPEN|', 'n|CLOSE|selected');
  }


}

function createTextItem($item, $value, $itemSet, $required = TRUE, $disable = FALSE)
{
    $item = explode('|',$itemSet[$item]);
    $textItemSkel = '<input type="'.$item[0].'" name="'.$item[1].'" id="'.$item[1].'" value="%value%" %required% %disable% />';
    if(strlen($value) > 0 )
    {
      $textItem = preg_replace('/%value%/',  $value, $textItemSkel);
    } else {
      $textItem = preg_replace('/%value%/',  '', $textItemSkel);
    }

    if($required == TRUE)
    {
      $textItem = preg_replace('/%required%/',  'required' , $textItem);
    } else if($required == FALSE) {
      $textItem = preg_replace('/%required%/',  '' , $textItem);
    } else {
      $textItem = preg_replace('/%required%/',  '' , $textItem);
    }

    if($disable == TRUE)
    {
      $textItem = preg_replace('/%disable%/',  'disabled' , $textItem);
    } else if ($disable == FALSE){
      $textItem = preg_replace('/%disable%/',  '' , $textItem);
    } else {
      $textItem = preg_replace('/%disable%/',  '' , $textItem);
    }
    return $textItem;
}


function createSelectBox($item, $itemSet, $required = TRUE, $disable = FALSE)
{
  $selectBox = '<select id="'.$item.'" name="'.$item.'">';
  $optionList = '<option value="%value%" %selected%>%item%</option>';

  for ($i=0; $i < count($itemSet); $i++)
  {
    $optionVars = explode('|',$itemSet[$i]);
    @$selectBox .= '<option value="'.$optionVars[0].'" '.$optionVars[2].'>'.$optionVars[1].'</option>';
  }
  $selectBox .= '</select>';
  return $selectBox;
}

?>
<div class="container">
  <div class="panel panel-default">
    <div class="panel panel-heading">
      Voucher Detail
    </div>
    <div class="panel-body">
      <form action="<?php echo $actionUpdUrl;?>" method="post">
            <?php echo createTextItem('vocKey', $vocKey, $htmlItems, TRUE, FALSE); ?>
            <?php echo createTextItem('refer', $refer, $htmlItems, TRUE, FALSE); ?>
        <table class="table">
          <col width="15%" />
          <col width="85%" />
          <tr>
            <td>Customer Name</td>
            <td><?php echo createTextItem('cusName', $cusName, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Customer Email</td>
            <td><?php echo createTextItem('cusEmail', $cusEmail, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Customer Mobile</td>
            <td><?php echo createTextItem('cusMobile', $cusMobile, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Departure Date</td>
            <td><?php echo createTextItem('departDate', $strDepartDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Return Date</td>
            <td><?php echo createTextItem('returnDate', $strReturnDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Payment Date</td>
            <td><?php echo createTextItem('paymentDate', $strPaymentDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Booking Date</td>
            <td><?php echo createTextItem('bookingDate', $strBookingDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Open Date</td>
            <td><?php echo createTextItem('openDate', $strOpenDate, $htmlItems, TRUE, FALSE); ?></td>
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
            <td><?php echo createTextItem('amount', $amount, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Number of People</td>
            <td><?php echo createTextItem('numofpeo', $nop, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Payment</td>
              <td><?php echo createSelectBox('isPaid', $isPaid, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Open</td>
              <td><?php echo createSelectBox('isOpen', $isOpen, TRUE, FALSE); ?></td>
          </tr>
        </table>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit"><?php echo $buttonDesc;?>  </button>
      </form>
    </div>
  </div>
  <div class="btn-group" role="group" aria-label="...">
  <button type="button" class="btn btn-default">Prev</button>
  <button type="button" class="btn btn-default" id="goList">List</button>
  <button type="button" class="btn btn-default">Next</button>
</div>
</div>

<script>
$(document).ready( function (){
  $('#departDate').datepicker({ dateFormat : "yy-mm-dd" , defaultDate :"<?php echo $strDepartDate;?>"});
  $('#returnDate').datepicker({ dateFormat : "yy-mm-dd"});
  $('#paymentDate').datepicker({ dateFormat : "yy-mm-dd"});
  $('#openDate').datepicker({ dateFormat : "yy-mm-dd"});
  $('#bookingDate').datepicker( { dateFormat :"yy-mm-dd"});

  $('#goList').click( function () {
      window.location="<?php echo $refer;?>";
  });
});
</script>
