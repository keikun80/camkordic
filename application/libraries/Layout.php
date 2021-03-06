<?php defined('BASEPATH') OR exit('No direct script access allowed');
/** ovs layout library **/
class Layout {
  private $CI;
  private $title_for_page = NULL;
  private $title_separator = '|';
  private $separated_title_for_page = NULL;
  public function __construct() {
      $this->CI =& get_instance();
  }
  public function setTitle($title)
  {
      $this->title_for_page = $title;
  }
  public function view ($view_name, $params = array(), $layout ='default')
  {
    $this->addInclude("assets/css/bootstrap.min.css");
    $this->addInclude("assets/css/voucher.css");
    
    $this->addInclude("assets/js/jquery-2.1.4.min.js"); 
    $this->addInclude("assets/js/jquery.migrate.js");
    $this->addInclude("assets/js/jquery-ui-1.11.4/jquery-ui.min.js"); 
    $this->addInclude("assets/js/bootstrap.min.js");
    $this->addInclude("assets/js/jquery-ui-1.11.4/jquery-ui.min.css"); 
    $this->addInclude("assets/js/jquery.print.js");
    
    if($layout == 'default_sign')
    {
      $this->addInclude("assets/css/signin.css");
    }
   
    if($this->title_for_page !== NULL)
    {
        $separated_title_for_page = $this->title_separator . $this->title_for_page;
    }  
    
   	$menu['userPath'] = $this->CI->config->item('base_url').'index.php/ovsuser/ovsuserlist';
   	$menu['logoutPath'] = $this->CI->config->item('base_url').'index.php/ovsuser/logout';
    
   	$view_content = $this->CI->load->view($view_name,$params, TRUE); 
    
    $this->CI->load->view('layouts/'.$layout , array('content_for_page'=>$view_content,
                                                     'title_for_page'=>$separated_title_for_page,
    		                                          'menu' => $menu
    ));
  }
  public function addInclude($path, $prepend_base_url = TRUE)
  {
      if($prepend_base_url)
      {
        $this->CI->load->helper('url');

        $this->file_includes[] = base_url() . $path;
      } else {
        $this->file_includes[] = $path;
      }
      return $this;
  }
  public function printInclude()
  {
      $final_includes = '';
      if(!empty($this->file_includes))
      {
        foreach ($this->file_includes as $include)
        {
          if(preg_match('/js$/', $include))
          {
            $final_includes .= '<script type="text/javascript" src="' . $include . '"></script>';
          } elseif(preg_match('/css$/',$include)) {
            $final_includes .= '<link href="' . $include . '" rel="stylesheet" type="text/css" media="screen, print" />';
          } else {}
          }
      }
      return $final_includes;
  }
}
?>
