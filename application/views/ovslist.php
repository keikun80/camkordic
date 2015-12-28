<p id="ovsprint" style="display:none"></p>
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
              <td>VOS</td>
              <td>Open</td>
              <td>Departure</td>
              <td>Book</td>
              <td>Payment</td>
              <td>Name</td>
              <td>Mobile</td>
              <td>Tour</td>
              <td>PAID</td>
              <td>VOC</td>
          </tr>
          <?php
          foreach ($result->result() as $row)
          {
            echo '<tr>';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->seq.'</a></td>';
              echo '<td>'.$row->cvos.'</td>';
              echo '<td>'. ($row->isOpen == 'y' ? 'open' : 'close').'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->departDate)).'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->regDate)).'</td>';
              echo '<td>'.date('Y-m-d', strtotime($row->paymentDate)).'</td>';
              echo '<td><a href="'.$linkurl.'/'.$row->seq.'">'.$row->cname.'</a></td>';
              echo '<td>'.$row->cmobile.'</td>';
              echo '<td>'.$row->trcode.'</td>';
              echo '<td>'. ($row->isPaid == 'y' ? 'PAID' : 'UN-PAID').'</td>';  
              if($row->voucherPath != '') 
              {
              	echo '<td><a href="'.$row->voucherPath.'">PDF</td>'; 
          	  } else {
              	echo '<td><a href="#" class="printpdf" value="'.$row->seq.'">CREATE</a></td>';
          	  }	
              echo '<td><button class="viewvoc" type="button" value="'.$row->seq.'">VIEW</button></td>';
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

	$('.glyphicon').hide(); 
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

    $('#ovsprint').dialog({ 
        modal:true,
        autoOpen:false,
        title : "Booking Ticket",
        width : 900,
		height: 680,
		buttons : {
			"print" : function() { $('.voucher_body').printElement({ overrideElementCSS: false, printTitle: "booking Ticket"});}, 
			"confirm" : function () {$(this).dialog('close');}
		}
    }); 
    $('.pdfvoc').click (function (data) { 
    	alert('aaaaaaaa');  
    }); 
    
    $('.printpdf').click(function () {   
       	c = $(this);  
        v = c.attr('value');   
       	c.html('<span class="glyphicon glyphicon-repeat" aria-hidden="true">');
       	
    	$.get ("<?php echo $pdfurl; ?>", {seq : v }) 
    	  .done(function (data) {     
        	  if(data != '') {
          		c.text('PDF'); 
          		c.removeClass('printpdf'); 
          		c.addClass('pdfvoc');  
          		c.attr('href' , data);
        	  }
    	});  
    	
    }); 
    $('.viewvoc').click(function () { 
		$.get("<?php echo $geturl;?>", {seq: $(this).val()})
		 .done(function (data) {   
			 $('#ovsprint').html(data);
			 $('#ovsprint').dialog('open');
		});
    });
});
</script>
