<?php
defined ('BASEPATH') or exit('No direct access script allow');

class Ovsmain extends CI_Controller {

	
	public function index($offset=0)
	{   
		if(!$this->session->userdata('usrName'))
		{
			header ('Location: '.$this->config->item('base_url').'index.php/ovsuser/index');
		}
		$this->ovslist($offset);
	}

	public function ovslist($offset=0)
	{
		$pageArticleLimit = 20;
		$config['base_url'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovslist';
		$config['total_rows']= $this->db->count_all('wp_tb_voucher_list', array('isDel'=>'n'));
		$config['per_page'] = $pageArticleLimit;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<nav><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_tag_open'] ='<li>';
		$config['first_tag_close'] ='</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$condition = array('isDel'=>'n' );
		$this->load->model('ovsmodel');
		$result = $this->ovsmodel->ovslist('wp_tb_voucher_list', $pageArticleLimit, $offset, $condition, 'seq');
		$vars = array ('result'=> $result,
						'listurl' => $_SERVER['PHP_SELF'],
						'linkurl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsedit',
						'pdfurl' => $this->config->item('base_url').'index.php/'.get_class($this).'/getpdf',
				        'openurl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsopen');
		$this->layout->setTitle("OVS MANAGEMENT - LIST");
		$this->layout->view('ovslist',$vars);
	}

	private function _getovsvoucher($seq = 0)
	{ 
		$retVal = false;
		if($seq > 0) 
		{
			$condition= array('seq'=> $seq);
			$retVal = $this->db->get_where('wp_tb_voucher_list', $condition); 
		} 
		return $retVal;
	}  
	
	public function ovsopen()
	{   
		$seq = $this->input->post('seq');	 
		$cmd= $this->input->post('cmd');	 
		
		$retVal =0;
	
		$this->db->where('seq', $seq); 
		$this->db->set('isOpen',$cmd);
		$this->db->update('wp_tb_voucher_list'); 
	
		$this->db->where('seq',$seq);
		$this->db->select('isOpen');
		$res= $this->db->get('wp_tb_voucher_list'); 
		$status = $res->row()->isOpen;	  
	
		if($status == 'y')
		{
			//send voucher to org and customer and kvision			 
			$this->getemail($seq);
		} else {
			//senc cancel request to org and customer and kbvision
		}
		echo $status; 
		
			
	}
	public function ovsedit($seq=0)
	{ 
		$tourSet = $this->gettourlist(); 
		
		if($seq > 0 )
		{
			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpdvoucher';
			$vars['buttonDesc'] = 'UPDATE';
			$vars['result'] = $this->_getovsvoucher($seq);  
			$vars['tourSet'] = $tourSet;
			
			$this->layout->setTitle("OVS MANAGEMENT - EDIT");
			$this->layout->view('ovsedit',$vars);
		} else {
			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpdvoucher';
			$vars['buttonDesc'] = 'REGISTRATION';
			$vars['tourSet'] = $tourSet;
			$this->layout->setTitle("OVS MANAGEMENT - EDIT");
			$this->layout->view('ovsedit',$vars);
		}
	}
	
	public function ovsdelete()
	{
	}

	public function gettourlist()
	{ 
		$this->db->where('post_status','publish');
		$this->db->where('post_type' , 'post'); 
		$this->db->select(array('ID','post_title'));
		$resSet = $this->db->get('wp_posts');   
	
		if($resSet->num_rows() > 0) { return $resSet; }
		else { return NULL; }
	}
	public function ovsnew()
	{
		$this->layout->setTitle("OVS MANAGEMENT - NEW");
	}

	public function ovsUpdvoucher()
	{
		$seq = $this->input->post('seq');
		$refer = $this->input->post('refer');
		$cname = $this->input->post('cname');
		$cemail = $this->input->post('cemail');
		$cmobile = $this->input->post('cmobile');
		$departDate = $this->input->post('departDate');
		$returnDate = $this->input->post('returnDate');
		$regDate = $this->input->post('regDate');
		$paymentDate = $this->input->post('paymentDate'); 
		$pickup = $this->input->post('pickup');
		$nopadult = $this->input->post('nopadult');
		$nopchild = $this->input->post('nopchild');
		$openDate = $this->input->post('openDate'); 
		$ttype = $this->input->post('ttype');
		$trcode = $this->input->post('trcode');
		$orgemail = $this->input->post('orgemail');
		$isPaid = $this->input->post('isPaid');
		$isOpen = $this->input->post('isOpen');
		$amount = $this->input->post('amount');
		$totamount = $this->input->post('totamount');  
		$remark = $this->input->post('remark');

		$updVars = array('cname' => $cname,
						'cemail'=> $cemail,
						'cmobile' => $cmobile,
						'departDate' => $departDate,
						'returnDate' => $returnDate,
						'regDate' => $regDate,
						'paymentDate' => $paymentDate,
						'openDate' => $openDate, 
						'nopadult'=> $nopadult,
						'nopchild'=> $nopchild,  
					    'ttype'=>$ttype,
						'amount'=> $amount,
						'totamount'=> $totamount,
						'pickup' => $pickup,
						'trcode' => $trcode, 
						'orgemail' => $orgemail, 
						'isPaid' => $isPaid, 
				        'remark' => $remark,
						'isOpen'=> $isOpen);

		if($seq> 0) {
       		$this->db->where('seq',$seq);
        	$this->db->update('wp_tb_voucher_list',$updVars);
    	} else {  
    		$this->load->model('ovsmodel');
    		$updVars['cvos'] = $this->ovsmodel->get_cvos_id($updVars['ttype'], $updVars['regDate']);
			$this->db->insert('wp_tb_voucher_list', $updVars);
		}
		if($refer == '') {
			$listUrl = $this->config->item('base_url').'index.php/'.get_class($this).'/ovslist';
			header('location:'.$listUrl);
		} else {
			header('location:'.$refer);
		}
	} 

	public function getemail($seq = 0)
	{ 
		$this->load->model('ovsmodel');
		if(!$seq) $seq = $this->input->get('seq'); 
		
		$retVal = 0;   
		if($seq > 0)
		{
			$vocInfo = $this->_getovsvoucher($seq)->row();  
			$retVal = $this->ovsmodel->get_tour_post($vocInfo->trcode);
		} 	
		$strings = explode('[wptab name', $retVal->post_content);

		//table content;    
		$htmlStream  = $this->load->view('tpl/c_voucher_tpl.html', array(), TRUE);  

		$vocInfoArr = array();
		foreach ($vocInfo as $key => $value)
		{ 
			$vocInfoArr[$key] = $value;
		}  
		
		$vocInfoArr['content'] = '';
		foreach ($strings as $key => $value)
		{
			if(preg_match('/^=/', $value))
			{  
				$tempString= explode(']',$value);	  
				$strlen_1 = strlen($tempString[0]);
				$tempString[0] = mb_substr($tempString[0], 2, $strlen_1);   
				$strlen_2 = strlen($tempString[0]); 
				$tempString[0] = mb_substr($tempString[0], 0 ,-1); 
				//additional Content;  
				$vocInfoArr['content'] .= "<hr><p>&nbsp;</p><p>".$tempString[0]."</p>";
				//echo $tempString[0]; //Title   
				$tempString[1] = mb_substr($tempString[1], 0, -7);  // Content; 
				$vocInfoArr['content'].= "<p>".nl2br($tempString[1])."</p><p>&nbsp;</p>";
			} 
		}  
		$vocInfoArr['content'].="<hr>";   
		
		$htmlVoucher = $this->parse($htmlStream, $vocInfoArr);     
		if($_SERVER['HTTP_HOST'] == 'localhost')
		{
			$cemail = "localtest@localhost"; 
			$orgemail= "localtest@localhost"; 
			$kvision= "localtest@localhost"; 
		} else {
			$cemail = $vocInfoArr['cemail'];
			$orgemail = $vocInfoArr['orgemail'];
			$kvision = "vision1@kvisiontour.com";
		}  
		$config = array('mailtype'=>'html');
		$this->email->initialize($config);
		$this->load->library('email');
		$this->email->from($kvision);
		$this->email->to($cemail);
		$this->email->cc($orgemail);
		$this->email->cc($kvision);
		$this->email->subject('KVISIONTOUR - Booking confirmation');
		$this->email->message($htmlVoucher);
		$this->email->send();	 
	}
	public function getpdf($seq = 0)
	{  
		if(!$seq)
			$seq = $this->input->get('seq');
		
		$retVal =0;
		if($seq > 0)
		{
			$retVal = $this->_getovsvoucher($seq)->row();
		} 
		
		$dataSet = array();
		
		foreach ($retVal as $key => $value)
			$dataSet[$key] = $value;
		
		$html = $this->load->view('tpl/voucher_mail.tpl.php', $dataSet, true);		 
		
		$filePath = getcwd().'/files/'.$dataSet['cvos'].'.pdf';   
		
		$this->load->helper('dompdf','files');   
		
		$output = pdf_creator($html,$filePath ,false); 
		
		file_put_contents($filePath, $output);  
		
		$updData['voucherPath'] = $this->config->item('base_url').'files/'.basename($filePath);  
		$this->db->where('seq', $seq);
		$this->db->update('wp_tb_voucher_list',$updData);	 
		
		echo $updData['voucherPath'];
	}

	public function parse ($tpl, $hash)
	{
		foreach ($hash as $key => $value)
			$tpl = str_replace('[+'.$key.'+]', $value, $tpl);
	
			return $tpl;
	}
/*
  public function dummydata($count=1000)
  {

    for($i=0; $i<$count; $i++)
    {
$data = array('cname'=>'test#',
            'cemail'=> 'test#@gmail.com',
            'cmobile' => '123#098764',
            'trcode' => '###',
            'orgname' => '###',
            'amount' => '########',
            'nopad' => '##',
            'nopch' =>'#',
            'departDate' => '2015-10-31',
            'returnDate'=> '2015-11-01',
            'paymentDate' => '2015-10-29',
            'openDate' => '2015-10-30',
            'regDate'=> '2015-10-29',
            'isPaid' => 'y',
            'isOpen' =>'n',
            'isDel' => 'n',
          );

        $data['cname'] = preg_replace('/#/', $i, $data['cusName']);
        $data['cemail'] = preg_replace('/#/', $i, $data['cusEmail']);
        $data['cmobile'] = preg_replace('/#/', $i, $data['cusMobile']);
        $data['trcode'] = preg_replace('/###/', rand(100,200), $data['torKey']);
        $data['orgname'] = preg_replace('/###/', rand(100,200), $data['orgKey']);
        $data['amount'] = preg_replace('/########/', rand(10000000,20000000), $data['amount']);
        $data['nopad'] = preg_replace('/##/', rand(1,99), $data['numofpeo']);
        $data['cvos'] = preg_replace('/#/', '2015'.date('m').rand(1,9999), $data['cvos']);
      print_r($data);
      $this->db->insert('wp_tb_voucher_list', $data);
    }
  } 
  */
} 
?>
