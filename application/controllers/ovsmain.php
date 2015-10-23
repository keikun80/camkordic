<?php
defined ('BASEPATH') or exit ('no direct script access allowed');

class ovsmain extends CI_Controller {

  public function  index()
  {
      $this->layout->setTitle("test");
      $this->layout->view('ovsmain');

  }

  public function enroll()
  {
    $this->layout->setTitle("test");
    $this->layout->view("ovsenroll");
  }
}
?>
