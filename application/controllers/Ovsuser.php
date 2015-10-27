<?php
defined ('BASEPATH') or exit ('no direct script access allowed');

class Ovsuser extends CI_Controller {

  public function  index()
  {
      $actionJoinPath = $this->config->item('base_url').'index.php/'.get_class($this).'/enroll';
      $vars = array ('actionJoinPath' => $actionJoinPath);
      $this->layout->setTitle("test");
      $this->layout->view('ovsmain', $vars);
  }

  public function enroll()
  {

    $actionJoinPath = $this->config->item('base_url').'index.php/'.get_class($this).'/test_enroll_step1';
    $actionEmailCheck = $this->config->item('base_url').'index.php/'.get_class($this).'/checkUser';
    $viewVars = array('actionJoinPath' => $actionJoinPath
                      ,'actionEmailCheck' => $actionEmailCheck);
    $this->layout->setTitle("test");
    $this->layout->view("ovsenroll",$viewVars);
  }

  public function checkUser()
  {
    $this->load->model('ovsmodel');
    $vars = array('usrEmail'=> $this->input->post('usrEmail'));
    $result = $this->ovsmodel->checkEmail($vars);
    if($result > 0)
    {
        echo 1;
    } else {
      echo 0;
    }
  }
  public function test_enroll_step1()
  {
      $vars = array ('usrName' => $this->input->post('usrName'),
                     'usrEmail' => $this->input->post('usrEmail'),
                    'usrPass' => $this->input->post('usrPass'),
                    'isActive' => 'n');
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
