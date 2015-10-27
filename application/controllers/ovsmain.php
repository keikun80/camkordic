<?php
defined ('BASEPATH') or exit('No direct access script allow');

class ovsmain extends CI_Controller {

  public function index($offset=0)
  {
    $this->ovslist($offset);
  }

  public function ovslist($offset=0)
  {
    $pageArticleLimit = 20;
    /*   todo
     1. make list
     2. button for edit, view, new
     3. checkbox for delete
     4. multi item delete
    */
    $config['base_url'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovslist';
    $config['total_rows']= $this->db->count_all('tbl_invent_voucher', array('isDel'=>'n'));
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

    $condition = array();
    $this->load->model('ovsmodel');
    $result = $this->ovsmodel->ovslist($pageArticleLimit, $offset, $condition);
    $vars = array ('result'=> $result,
                   'linkurl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsedit');
    $this->layout->setTitle("OVS MANAGEMENT - LIST");
    $this->layout->view('ovslist',$vars);
  }

  public function ovsedit($vocKey)
  {
    if($vocKey > 0 )
    {
      $condition= array('vocKey'=> $vocKey);
      $vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpdvoucher';
      $vars['buttonDesc'] = 'UPDATE';

      $vars['result'] = $this->db->get_where('tbl_invent_voucher', $condition);

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

    /*
      Todo
       1. if POST value has vocSeq => update process
          none vocSeq => insert process
       2.
    */
    $cusName = $this->input->post('cusName');
    $cusEmail = $this->input->post('cusEmail');
    $cusMobile = $this->input->post('cusMobile');

    $departDate = date_create_from_format('j M, y', $this->input->post('departDate'));
    $departDate = date_format($departDate, 'Y-m-d');

    $returnDate = date_create_from_format('j M, y', $this->input->post('returnDate'));
    $returnDate = date_format($returnDate, 'Y-m-d');

    $bookingDate = date_create_from_format('j M, y', $this->input->post('bookingDate'));
    $bookingDate = date_format($bookingDate, 'Y-m-d');

    $paymentDate = date_create_from_format('j M, y', $this->input->post('paymentDate'));
    $paymentDate = date_format($paymentDate, 'Y-m-d');

    $openDate = date_create_from_format('j M, y', $this->input->post('openDate'));
    $openDate = date_format($openDate, 'Y-m-d');

    $torKey = $this->input->post('torKey');
    $orgKey = $this->input->post('orgKey');
    $isPayment = $this->input->post('isPayment');
    $isOpen = $this->input->post('isOpen');


    $updVars = array('cusName' => $cusName,
                     'cusEmail'=> $cusEmail,
                     'cusMobile' => $cusMobile,
                     'departDate' => $departDate,
                     'returnDate' => $returnDate,
                     'bookingDate' => $bookingDate,
                     'paymentDate' => $paymentDate,
                     'openDate' => $openDate,
                     'torKey' => $torKey,
                     'orgKey' => $orgKey,
                     'isPayment' => $isPaid,
                     'isOpen'=> $isOpen);

    $this->db->insert('tbl_invent_voucher', $updVars);
  }
  public function dummydata($count=1000)
  {

    for($i=0; $i<$count; $i++)
    {
      $data = array('cusName'=>'test#',
            'cusEmail'=> 'test#@gmail.com',
            'cusMobile' => '123#098764',
            'torKey' => '###',
            'orgKey' => '###',
            'amount' => '########',
            'numofpeo' => '##',
            'vocSer' =>'#',
            'departDate' => '2015-10-31',
            'returnDate'=> '2015-11-01',
            'paymentDate' => '2015-10-29',
            'openDate' => '2015-10-30',
            'bookingDate'=> '2015-10-29',
            'isPaid' => 'y',
            'isOpen' =>'n',
            'isDel' => 'n',
          );

        $data['cusName'] = preg_replace('/#/', $i, $data['cusName']);
        $data['cusEmail'] = preg_replace('/#/', $i, $data['cusEmail']);
        $data['cusMobile'] = preg_replace('/#/', $i, $data['cusMobile']);
        $data['torKey'] = preg_replace('/###/', rand(100,200), $data['torKey']);
        $data['orgKey'] = preg_replace('/###/', rand(100,200), $data['orgKey']);
        $data['amount'] = preg_replace('/########/', rand(10000000,20000000), $data['amount']);
        $data['numofpeo'] = preg_replace('/##/', rand(1,99), $data['numofpeo']);
        $data['vocSer'] = preg_replace('/#/', '2015'.date('m').rand(1,9999), $data['vocSer']);
      print_r($data);
      $this->db->insert('tbl_invent_voucher', $data);
    }
  }
}
?>
