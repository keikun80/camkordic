<?php
// Edit data implement
$htmlItems = array ('refer' => 'hidden|refer'
                   ,'usrKey' => 'hidden|usrKey'
                   ,'usrName' => 'text|usrName'
                   ,'usrEmail' =>'text|usrEmail'
                   ,'usrDomain' =>'text|usrDomain' 
		           ,'usrPass' => 'password|usrPass'
		           ,'usrPass2'=> 'password|usrPass2' 
                   ,'isDel' =>'select|isDel');

/* initialize vars */
$usrKey = NULL;
$usrName = NULL;
$usrEmail= NULL;
$usrDomain = NULL; 
$usrPass = NULL;
$usrPass2 = NULL;
$isDel = array ('y|DELETE|','n|ACTIVE|selected' );


$refer= (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

if(isset($result))
{
	$usrKey = $result->row()->usrKey;
	$usrName= $result->row()->usrName;
	$usrEmail= $result->row()->usrEmail;
	$usrDomain= $result->row()->usrDomain;
	$usrPass= $result->row()->usrPass;
	$isDel = array ('y|DELETE|','n|ACTIVE|selected' );

	if($result->row()->isDel== 'y')
	{
		$isPaid = array('y|DELETE|selected', 'n|ACTIVE');
	} else if($result->row()->isDel == 'n') {
		$isPaid = array('y|DELETE|', 'n|ACTIVE|selected');
	} else {
		$isPaid = array('y|DELETE|', 'n|ACTIVE|selected');
	}
} // if($result) 

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
      USER Detail
    </div>
    <div class="panel-body">
      <form action="<?php echo $actionUpdUrl;?>" method="post">
            <?php echo createTextItem('usrKey', $usrKey, $htmlItems, true, false); ?>
            <?php echo createTextItem('refer', $refer, $htmlItems, true, false); ?>
        <table class="table">
          <col width="15%" />
          <col width="85%" />
          <tr>
            <td>NAME</td>
            <td><?php echo createTextItem('usrName', $usrName, $htmlItems, true, false); ?></td>
          </tr>
          <tr>
            <td>EMAIL</td>
            <td><?php echo createTextItem('usrEmail', $usrEmail, $htmlItems, false, true); ?></td>
          </tr>
          <tr>
            <td>DOMAIN</td>
            <td><?php echo createTextItem('usrDomain', $usrDomain, $htmlItems, true, false); ?></td>
          </tr> 
          <tr>
            <td>Password</td> 
            <td><?php echo createTextItem('usrPass', $usrPass, $htmlItems, false, true); ?> 
            change password : <input type="checkbox" name="chgPass"  id="chgPass"> 
            <span id="test"></span>
            </td> 
          </tr>
          <tr>
            <td>Repeat Password</td>
            <td><?php echo createTextItem('usrPass2', $usrPass2, $htmlItems, false, true); ?></td>
          </tr>
          <tr>
            <td>ACTIVE</td>
              <td><?php echo createSelectBox('isDel', $isDel, TRUE, FALSE); ?></td>
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

	function activateChgPassword(bool)
	{ 
		$('#usrPass').attr('required', bool);  
		$('#usrPass2').attr('required', bool);  
		
		if(bool === 'true')
		{ 
			$('#usrPass').removeAttr('disabled');
			$('#usrPass2').removeAttr('disabled');
		} else { 
			$('#usrPass').attr('disabled','true');
			$('#usrPass2').attr('disabled','true');
		}
	}  
	
	$('#chgPass').change(function () {
		var attr = $(this)[0].checked;  
		if(attr === true)
		{ 
			activateChgPassword('true'); 
		} else { 
			activateChgPassword('false'); 
		}
	}); 

	$('#submit').click( function () {   
	    var hasError = false; 
		var chgPass = $('#chgPass')[0].checked;  
		if(chgPass === true) 
		{ 
			//check password 
	    	var opass = $('#usrPass').val();
	    	var vpass = $('#usrPass2').val();
		    if(opass === vpass) {
				hasError = true;
	    	} else if (opass !== vpass) {
				$('#usrPass').addClass('error');
				$('#usrPass2').addClass('error').after("<span id=\"errorTextPw\" class=\"errorText\">Password is not match</span> ");
				hasError = false;
			} else {
				hasError = false;
			}
		} else { // check password   
			hasError = true;
		}	
		return hasError;			
	});

	$('input[type=password]').click(function (){   
		  $('#errorTextPw').remove();
	      $(this).val('');
	      $(this).removeClass('error');
	});	  
	
	$('#goList').click( function () {
		window.location="<?php echo $refer;?>";
	}); 

  
});
</script>
