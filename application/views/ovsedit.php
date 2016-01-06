<?php
// Edit data implement 
$ttypeSet =   array ('tour' => 'tour'
			     ,'rentcar' =>'rentcar'
			    , 'hotel' => 'hotel'
			    ,'train' => 'train'
			    ,'openbus' => 'openbus'); 

$htmlItems = array ('refer' => 'hidden|refer'
                   ,'seq' => 'hidden|seq'
                   ,'cname' => 'text|cname'
                   ,'cemail' =>'text|cemail'
                   ,'cmobile' =>'text|cmobile'
                   ,'departDate' =>'text|departDate'
                   ,'returnDate' =>'text|returnDate'
                   ,'paymentDate' =>'text|paymentDate'
                   ,'regDate' =>'text|regDate'
                   ,'openDate' => 'text|openDate' 
				   ,'pickup' => 'text|pickup'
                   ,'trcode' => 'text|trcode'
                   ,'orgemail' => 'text|orgemail'
                   ,'amount' => 'text|amount' 
		           ,'totamount' => 'text|totamount'  
		           ,'single_charge' => 'text|single_charge' 
				   ,'child_ratio' => 'text|child_ratio'
                   ,'nopadult' =>'text|nopadult'
                   ,'nopchild' =>'text|nopchild'
                   ,'isPaid' => 'select|isPaid'
                   ,'isOpen' => 'select|isOpen');

/* initialize vars */ 
$seq = NULL;
$cname = NULL;
$cemail = NULL;
$cmobile = NULL; 
$strDepartDate = date('Y-m-d');
$strReturnDate = $strDepartDate;
$strPaymentDate =  $strDepartDate;
$strRegDate= $strDepartDate;
$strOpenDate = $strDepartDate;

$ttype = NULL;
$pickup = NULL;
$trcode = NULL;
$orgemail = NULL;
$amount = NULL; 
$totamount = NULL;
$nopadult = NULL; 
$child_ratio =NULL;
$nopchild = NULL;
$isPaid = array ('y|PAID|','n|UN-PAID|selected' );
$isOpen = array ('y|OPEN|','n|CLOSE|selected' );
$remark = NULL;

$refer= (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

if(isset($result))
{
	$seq= $result->row()->seq;
	$cname = $result->row()->cname;
	$cemail = $result->row()->cemail;
	$cmobile = $result->row()->cmobile;

	//$departDate = date_parse_from_format('y-m-d', $result->row()->departDate);
	//$strDepartDate = $departDate['year'].'-'.$departDate['month'].'-'.$departDate['day']; 

	//$returnDate = date_parse_from_format('y-m-d', $result->row()->returnDate);
	//$strReturnDate = $returnDate['year'].'-'.$returnDate['month'].'-'.$returnDate['day'];

	//$paymentDate = date_parse_from_format('y-m-d', $result->row()->paymentDate);
	//$strPaymentDate = $paymentDate['year'].'-'.$paymentDate['month'].'-'.$paymentDate['day'];

	//$regDate= date_parse_from_format('y-m-d', $result->row()->regDate);
	//$strRegDate= $regDate['year'].'-'.$regDate['month'].'-'.$regDate['day'];

	//$openDate = date_parse_from_format('Y-m-d', $result->row()->openDate);
	//$strOpenDate = $openDate['year'].'-'.$openDate['month'].'-'.$openDate['day'];

	$strDepartDate = $result->row()->departDate; 
	$strReturnDate = $result->row()->returnDate;
	$strOpenDate = $result->row()->openDate;
	$strPaymentDate = $result->row()->paymentDate;
	$strRegDate = $result->row()->regDate; 
	
	$ttype = $result->row()->ttype;
	$pickup = $result->row()->pickup;
	$trcode = $result->row()->trcode;
	$orgemail = $result->row()->orgemail;
	$amount = $result->row()->amount;
	$totamount = $result->row()->totamount;
	$nopadult = $result->row()->nopadult;
	$nopchild = $result->row()->nopchild; 
	$child_ratio = $result->row()->child_ratio; 
	$remark = $result->row()->remark;
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
} // if($result) 
/* initialize tour set */
$trCodeArr = array();
foreach ($tourSet->result() as $row)
{ 
	if($trcode == $row->ID) {
		$trCodeArr[] = $row->ID.'|'.$row->post_title.'|selected';
	} else {
		$trCodeArr[] = $row->ID.'|'.$row->post_title;
	}
} 
$ttypeArr = array(); 
foreach ($ttypeSet as $key => $value)
{ 
	if($value == $ttype)
	{
		$ttypeArr[] = $key.'|'.$value.'|selected';
	} else {
		$ttypeArr[] = $key.'|'.$value;	
	}
}

/* end of initialize tour set */
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
  //$optionList = '<option value="%value%" %selected%>%item%</option>';

  for ($i=0; $i < count($itemSet); $i++)
  { 
    $optionVars = explode('|',$itemSet[$i]); 
    if(isset($optionVars[2])) //isset selected
    { 
    	@$selectBox .= '<option value="'.$optionVars[0].'" '.$optionVars[2].'>'.$optionVars[1].'</option>'; 
    } else {
		@$selectBox .= '<option value="'.$optionVars[0].'" >'.$optionVars[1].'</option>'; 
    } 
    //@$selectBox .= '<option value="'.$optionVars[0].'" >'.$optionVars[1].'</option>'; 
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
            <?php echo createTextItem('seq', $seq, $htmlItems, TRUE, FALSE); ?>
            <?php echo createTextItem('refer', $refer, $htmlItems, TRUE, FALSE); ?>
        <table class="table">
          <col width="15%" />
          <col width="85%" />
          <tr>
            <td>Customer Name</td>
            <td><?php echo createTextItem('cname', $cname, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Voucher type</td>
               <td><?php echo createSelectBox('ttype',$ttypeArr, TRUE, FALSE); ?> </td>
          </tr>
          <tr>
            <td>Tour Service</td>
               <td><?php echo createSelectBox('trcode',$trCodeArr, TRUE, FALSE); ?> </td>
          </tr>
          <tr>
            <td>Organiztion</td>
            <td><input type="text" name="orgemail" id="orgemail" value="<?php echo $orgemail; ?>" required />
           </td>
          </tr>
          <tr>
            <td>Customer Email</td>
            <td><?php echo createTextItem('cemail', $cemail, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Customer Mobile</td>
            <td><?php echo createTextItem('cmobile', $cmobile, $htmlItems, TRUE, FALSE); ?></td>
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
            <td><?php echo createTextItem('regDate', $strRegDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Open Date</td>
            <td><?php echo createTextItem('openDate', $strOpenDate, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <tr>
            <td>Pickup Location</td>
            <td><input type="text" name="pickup" id="pickup" value="<?php echo $pickup; ?>" required /> 
            </td>
          </tr> 
          <tr>
            <td>Amount</td>
            <td><?php echo createTextItem('amount', $amount, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Total Amount</td>
            <td><?php echo createTextItem('totamount', $totamount, $htmlItems, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Number of People</td>
            <td>성인 : <?php echo createTextItem('nopadult', $nopadult, $htmlItems, TRUE, FALSE); ?>
                                     소아 :<?php echo createTextItem('nopchild', $nopchild, $htmlItems, TRUE, FALSE); ?>
                (할인율 : <?php echo $child_ratio; ?>%) </td>
          </tr>
          <tr>
            <td>Payment</td>
              <td><?php echo createSelectBox('isPaid', $isPaid, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Open</td>
              <td><?php echo createSelectBox('isOpen', $isOpen, TRUE, FALSE); ?></td>
          </tr>
          <tr>
            <td>Remark</td>
              <td><textarea row="4" cols="23" name="remark"><?php echo $remark; ?></textarea></td>
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
  $('#regDate').datepicker( { dateFormat :"yy-mm-dd"});

  $('#goList').click( function () {
      window.location="<?php echo $refer;?>";
  }); 

  
});
</script>
