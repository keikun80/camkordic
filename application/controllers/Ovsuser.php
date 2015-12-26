<?php
defined ('BASEPATH') or exit ('no direct script access allowed');

class Ovsuser extends CI_Controller {

  public function  index()
  {
      $actionJoinPath = $this->config->item('base_url').'index.php/'.get_class($this).'/enroll';
      $actionAuthPath = $this->config->item('base_url').'index.php/'.get_class($this).'/authuser'; 
      $refer = '';
      $vars = array ('actionJoinPath' => $actionJoinPath, 
      		         'actionAuthPath' => $actionAuthPath,
      		         'refer' => $refer
      ); 
      
      $this->layout->setTitle("test");
      $this->layout->view('ovsmain', $vars ,'default_sign');
  }

	public function enroll()
	{
    	$actionJoinPath = $this->config->item('base_url').'index.php/'.get_class($this).'/test_enroll_step1';
    	$actionEmailCheck = $this->config->item('base_url').'index.php/'.get_class($this).'/checkUser';
    	$viewVars = array('actionJoinPath' => $actionJoinPath
    	                  ,'actionEmailCheck' => $actionEmailCheck);
    	$this->layout->setTitle("test");
    	$this->layout->view("ovsenroll",$viewVars, 'default_sign');
	}

  	public function ovsuserlist($offset = 0)
  	{
		$this->load->model('ovsmodel');  
  		if($this->session->userdata('usrEmail'))
  		{   
  			$pageArticleLimit = 20;
  			$config['base_url'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsuserlist';
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
  			$result = $this->ovsmodel->ovslist('tbl_invent_user', $pageArticleLimit, $offset, $condition, 'usrKey'); 
  			
  			$vars = array ('result'=> $result,
  					'listurl' => $_SERVER['PHP_SELF'],
  					'linkurl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsuseredit',
  					'geturl' => $this->config->item('base_url').'index.php/'.get_class($this).'/ovsprint'); 
  				
  			$this->layout->setTitle("OVS MANAGEMENT - USERS LIST");
  			$this->layout->view('ovsuserlist',$vars);
  		}
  	}  
  	private function _getovsuser($usrKey)
  	{ 
  		$retVal = false;
		if($usrKey > 0) 
		{
			$condition= array('usrKey'=> $usrKey);
			$retVal = $this->db->get_where('tbl_invent_user', $condition); 
		} 
		return $retVal;
	} 
	
  	public function ovsuseredit($usrKey = 0)
  	{ 
  		if($usrKey > 0)
  		{
  			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpduser';
  			$vars['buttonDesc'] = 'UPDATE';
  			$vars['result'] = $this->_getovsuser($usrKey);
  			
  			$this->layout->setTitle("OVS USER MANAGEMENT - EDIT");
  			$this->layout->view('ovsuseredit',$vars);
  		} else {
  			$vars['actionUpdUrl'] = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsUpduser';
  			$vars['buttonDesc'] = 'REGISTRATION';
  			$this->layout->setTitle("OVS MANAGEMENT - EDIT");
  			$this->layout->view('ovsuseredit',$vars);
  		}	
  	} 
  	public function ovsUpduser()
  	{  
  		$usrKey = $this->input->post('usrKey');
  		$usrName = $this->input->post('usrName'); 
  		$usrDomain = $this->input->post('usrDomain');
  		
  		$updVars= array('usrName'=> $usrName
  				        ,'usrDomain'=> $usrDomain
  		); 
  	
  		$isChange = $this->input->post('chgPass') ? $this->input->post('chgPass') : 'no'; 
  		 
  		if($isChange =='on') 
  		{
  			$updVars['usrPass'] = $this->input->post('usrPass');
  		} 
  		
  		if($usrKey> 0) {
  			$this->db->where('usrKey',$usrKey);
  			$this->db->update('tbl_invent_user',$updVars);
  		}
  		if($refer == '') {
  			$listUrl = $this->config->item('base_url').'index.php/'.get_class($this).'/ovsuserlist';
  			header('location:'.$listUrl);
  		} else {
  			header('location:'.$refer);
  		}	
  	}
	public function authuser()
	{    
		
		$this->load->model('ovsmodel');
		$usrEmail = $this->input->post('inputEmail'); 
		$usrPassword = $this->input->post('inputPassword');  
		$refer = $this->input->post('refer');
		$resultSet = $this->ovsmodel->auth($usrEmail, $usrPassword); 
		if($resultSet[0])
		{  
			$this->session->set_userdata('usrKey', $resultSet[0]->usrKey); 
			$this->session->set_userdata('usrName', $resultSet[0]->usrName);
			$this->session->set_userdata('usrEmail', $resultSet[0]->usrEmail); 
			$this->session->set_userdata('usrDomain', $resultSet[0]->usrDomain); 
		}  

		if($refer =='')
		{ 
			header('Location: '.$this->config->item('base_url').'index.php/ovsmain/index');
		} else {
			header('Location: '.$refer);
		}
	} 
	public function logout()
	{
		$this->session->unset_userdata('usrKey'); 
		$this->session->unset_userdata('usrName');
		$this->session->unset_userdata('usrEmail'); 
		$this->session->unset_userdata('usrDomain');
		header('Location: '.$this->config->item('base_url').'index.php/ovsmain/index');
	}
	public function checkUser()
	{
		$this->load->model('ovsmodel');
		$vars = array('usrEmail'=> $this->input->post('usrEmail'));
		$result = $this->ovsmodel->checkEmail($vars);
		if($result > 0) { echo 1; } 
		else { echo 0; }
 	} 
  public function test_enroll_step1()
  {
      $vars = array ('usrName' => $this->input->post('usrName'),
                     'usrEmail' => $this->input->post('usrEmail'),
                    'usrPass' => $this->input->post('usrPass'),
                    'isDel' => 'n');
      $isValid = FALSE;
      //Password check
      $this->load->model('ovsmodel');
      $this->ovsmodel->insUsrInfo($vars);
      if($vars['usrPass'] === $this->input->post('usrPass2'))
      {
          $isValid = TRUE;
      } else {
        echo ("<script> alret ('password fault');</script>");
      }
      $goPage = $this->config->item('base_url').'index.php/'.get_class($this).'/index';
      header('Location: '.$goPage);
      die();
      //insert information to database

  }
}
?>
