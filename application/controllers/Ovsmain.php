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
				        'geturl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsprint');
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
	
	public function ovsprint()
	{   
		$seq = $this->input->get('seq');	 
		
		$retVal =0;
		if($seq > 0) 
		{
			$retVal = $this->_getovsvoucher($seq);
		}    
		$retHtml = '<div class="voucher_body">
						<p class="gwd-p-10g2">KVISION TOURS
		<br class="">&nbsp; &nbsp; &nbsp; &nbsp;비전투어
		<br class="">
		<br class="">
		</p>
		<p class="gwd-p-1vai">케이비전투어</p>
		<p class="gwd-p-cczf">Booking Ticket</p>
		<p class="gwd-p-4dku">No :&nbsp;</p>
		<p class="gwd-p-wj6z">'.$retVal->row()->cvos.'</p>
		<p class="gwd-p-azle">Booking Date :</p>
		<p class="gwd-p-1e68">'.$retVal->row()->regDate.'</p>
		<p class="gwd-p-2zzh">Customer Name (고객성명) :</p>
		<p class="gwd-p-1y0u">'.$retVal->row()->cname.'</p>
		<p class="gwd-p-pzcs">Tour Type (티켓 종류):</p>
		<p class="gwd-p-d3i0">Departure Date (출발일):</p>
		<p class="gwd-p-8fbn">Pickup Place (픽업장소):</p>
		<p class="gwd-p-pn4n">Persons (인원):</p>
		<p class="gwd-p-r05n">Price (가격):</p>
		<p class="gwd-p-1ve2">'.$retVal->row()->ttype.'</p>
		<p class="gwd-p-149d">성인 : '.$retVal->row()->nopadult.' 명 (child(소아) '.$retVal->row()->nopchild.'명)</p>
		<p class="gwd-p-p98u">'.$retVal->row()->pickup.'</p>
		<p class="gwd-p-724h">'.$retVal->row()->totamount.'USD</p>
		<p class="gwd-p-uwb8">'.$retVal->row()->departDate.'</p>
		<p class="gwd-p-1f6y">Address : 72 Tran Nhay Duat St, Hoan Kiem , Ha noi, Vietnam</p>
		<p class="gwd-p-1tsb">Email : vision1@kvisiontour.com</p>
		<p class="gwd-p-1ot2">Phone : +84 4 3871 5555 / +84 93 508 2402</p>
		<p class="gwd-p-1moj">Website : www.kvisiontours.com</p>
		<p class="gwd-p-1yh4 gwd-p-wcha" style="">Accountant</p>
		<p class="gwd-p-1yh4 gwd-p-kdn8 gwd-p-11za">Customer</p>
		<p class="gwd-p-1yh4 gwd-p-kdn8 gwd-p-12ch">Seller</p> </div>'; 

		print ($retHtml);
	}
	public function ovsedit($seq=0)
	{
		if($seq > 0 )
		{
			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpdvoucher';
			$vars['buttonDesc'] = 'UPDATE';
			$vars['result'] = $this->_getovsvoucher($seq); 
			
			$this->layout->setTitle("OVS MANAGEMENT - EDIT");
			$this->layout->view('ovsedit',$vars);
		} else {
			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpdvoucher';
			$vars['buttonDesc'] = 'REGISTRATION';
			$this->layout->setTitle("OVS MANAGEMENT - EDIT");
			$this->layout->view('ovsedit',$vars);
		}
	}
	
	public function ovsdelete()
	{
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
		$trcode = $this->input->post('trcode');
		$orgname = $this->input->post('orgname');
		$isPaid = $this->input->post('isPaid');
		$isOpen = $this->input->post('isOpen');
		$amount = $this->input->post('amount');
		$totamount = $this->input->post('totamount'); 

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
						'amount'=> $amount,
						'totamount'=> $totamount,
						'pickup' => $pickup,
						'trcode' => $trcode, 
						'orgname' => $orgname, 
						'isPaid' => $isPaid,
						'isOpen'=> $isOpen);

		if($seq> 0) {
       		$this->db->where('seq',$seq);
        	$this->db->update('wp_tb_voucher_list',$updVars);
    	} else {
			$this->db->insert('wp_tb_voucher_list', $updVars);
		}
		if($refer == '') {
			$listUrl = $this->config->item('base_url').'index.php/'.get_class($this).'/ovslist';
			header('location:'.$listUrl);
		} else {
			header('location:'.$refer);
		}
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
