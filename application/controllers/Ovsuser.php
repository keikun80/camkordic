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
