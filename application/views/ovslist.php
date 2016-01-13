<p id="ovsprint" style="display:none"></p>
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">Open Voucher Management</div>
    <div class="panel-body">
      <div class="wall">
        <form action="<?php echo $listurl;?>" method="get" >
          <label for="cvos" class="sr-only">Booking Date :</label>
          Booking Date :
            <input type="text" name="sw_fromdt" id="sw_fromdt" /> ~ <input type="text" name="sw_todt" id="sw_todt" />
          VOUCHER NO :
          <input type="text" name="sw_vno" id="sw_vno" />
          CUSTOMER :
          <input type="text" name="sw_cname" id="sw_cname" /> 
          <button id="subbtn" name="subbtn" type="submit">SEARCH</button>
        </form> 
      </div>
        <table class="table">
          <tr>
              <td>VOUCHER NO</td>
              <td>DEPARTURE</td>
              <td>BOOK</td>
              <!-- <td>Payment</td> -->
              <td>NAME</td>
              <td>MOBILE</td>
              <td>TOUR</td>
              <td>PAID</td>
              <td>STATUS</td>
              <td>VOUCHER</td>
              <!-- <td>OPEN CMD</td> -->
          </tr>
          <?php
          foreach ($result->result() as $row)
          {   
          	$trClass = "vocclose";
          	if($row->isOpen == 'y') 
          	{
          		$trClass="vocopen";	
          	}
            echo '<tr class="'.$trClass.'">';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->cvos.'</a></td>';
              echo '<td>'.date('Y-m-d', strtotime($row->departDate)).'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->regDate)).'</td>';
              //echo '<td>'.date('Y-m-d', strtotime($row->paymentDate)).'</td>';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->cname.'</a></td>';
              echo '<td>'.$row->cmobile.'</td>';
              echo '<td>'.$row->trcode.'</td>';
              echo '<td>'. ($row->isPaid == 'y' ? 'PAID' : 'UN-PAID').'</td>';  
              echo '<td><span id="'.$row->seq."status".'">'.($row->isOpen == 'y' ? 'OPENED' : 'CLOSED').'</span></td>';  
              if($row->voucherPath != '') 
              {
              	echo '<td><a href="'.$row->voucherPath.'">VIEW</td>'; 
          	  } else {
              	echo '<td><a href="#" class="printpdf" value="'.$row->seq.'">CREATE</a></td>';
          	  }	
              //echo '<td><button class="openvoc" type="button" value="'.$row->seq.'">'. ($row->isOpen == 'y' ? 'to close' : 'to open').'</button></td>';
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

	$('#subbtn').click(function () { 
		var fromdt = $('#sw_fromdt').val();
		var todt = $('#sw_todt').val();
		var vno = $('#sw_vno').val();
		var cname = $('#sw_cname').val(); 
		$.get
	}); 
	
	$('.glyphicon').hide();  
	
    $('#sw_fromdt').datepicker({
        defaultDate:"+1W",
        changeMonths: true,
        numberOfMonths:3 ,
        dateFormat: "yy-mm-dd",
        onClose :function (selectedDate){
          $("#todt").datepicker("option","minDate", selectedDate);
        }
    });
    $('#sw_todt').datepicker({
        defaultDate:"+1W",
        changeMonths: true,
        numberOfMonths:3 ,
        dateFormat: "yy-mm-dd",
        onClose :function (selectedDate){
          $("#fromdt").datepicker("option","maxDate", selectedDate);
        }
    });

    $('#ovsprint').dialog({ 
        modal:true,
        autoOpen:false,
        title : "Booking Ticket",
        width : 500,
		height: 300,
		buttons : {
			"confirm" : function () {jQuery(this).dialog('close'); return true; },
			"cancel" : function () {jQuery(this).dialog('close'); return false; }
		}
    }); 
    $('.pdfvoc').click (function (data) { 
    	alert('aaaaaaaa');  
    }); 
    
    $('.printpdf').click(function () {   
       	c = $(this);  
        v = c.attr('value');   
       	c.html('<span class="glyphicon glyphicon-repeat" aria-hidden="true">');
       	u = "<?php echo $pdfurl?>/"+v+"/pdf";
    	$.get (u) 
    	  .done(function (data) {     
        	  if(data != '') {
          		c.text('VIEW'); 
          		c.removeClass('printpdf'); 
          		c.addClass('pdfvoc');  
          		c.attr('href' , data);
        	  }
    	});  
    	
    });  
    $('.openvoc').click(function () {  
        var btn = $(this);  
        var cmd = btn.text();   
        var seqno = btn.val();
        var mode = "y"; 
        var r = false;
        if(cmd == 'to open') 
        { 
         	mode="y"; 
        } else {   
            //confirmRet = jQuery('#ovsprint').dialog('open');   
            //alert(confirmRet); 
            r = confirm('Do you want to rollback this voucher? \r\nSystem will send cancel email to organized');  
            if(r === false) { return; } 
            mode = 'n';
        }   
		$.post("<?php echo $openurl;?>", {seq: seqno, cmd: mode})
		 .done(function (data) {      
			 if(data)
			 {  
				 if(data== "y") 
				 { 
				  	btn.text("to close");  
				  	jQuery('#'+seqno+'status').text('OPENED'); 
				  	btn.parents('tr').removeClass('vocclose');
				  	btn.parents('tr').addClass('vocopen');
				 } else {
					 btn.text("to open"); 
				  	jQuery('#'+seqno+'status').text('CLOSED');
				  	btn.parents('tr').removeClass('vocopen');
				  	btn.parents('tr').addClass('vocclose');
			     } 
			 }
		});
    });
});
</script>
