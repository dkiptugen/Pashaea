<?php
class Login extends CI_Controller
	{
		public function __construct()
		 	{   
		 		parent::__construct();
                //
		 		$this->load->model("Accounts");
		 	}
        public function x($authkey,$password)
            {
                echo $this->assist->secu($authkey,$password);
            }
		public function index()
		    {
                $this->checkifuserloggedin();
                try
                    {
                        $data["msg"]=NULL;
                        if($this->input->post("login"))
                            {
                                $login=$this->Accounts->login();
                                if(isset($login->error))
                                    {
                                        $data["msg"]=$login->error;
                                    }
                                else
                                    {
                                        $newdata =(array)$login;
                                        $newdata["login"]=TRUE;
                                        //$data["msg"]=json_encode($newdata);
                                        $this->session->set_userdata($newdata);
                                        redirect("cms","refresh");
                                    }

                            }
                           
                        $this->load->view('cms/login/login',array("elements"=>$data));

                    }
                catch (Exception $e)
                    {
                        //file_put_contents(base_url()."application/log/login.log","Main login:".$e->getMessage(),FILE_APPEND);
                        $this->log("login.log","Main login:".$e->getMessage());
                    }
		    }
        public function checkifuserloggedin()
            {
              try
                {
                    if(isset($_SESSION['login']))
                        {
                            if ($_SESSION['login'] == TRUE)
                                {
                                  redirect("cms","refresh");
                                }
                        }

                  
                }
              catch (Exception $e)
                {
                    
                    $this->log("login.log","Check login:".$e->getMessage());
                }
            }    
		public function changepassword()
		    {
		    	$data["msg"]=NULL;
		    	if($this->input->post("changepassword"))
		    	  	{
                     	$data["msg"]=json_encode($this->Accounts->changepassword());	
		    	   	}
		        $this->load->view('cms/login/changepassword',array("elements"=>$data));
		    }
        public function logout()
            {
                $data=array('id','Name','Designation','email','password','role','user_status','pass_status','userimg','login','__ci_last_regenerate');
                $this->session->unset_userdata($data);
                $this->session->sess_destroy();
                //$this->cache->clean();
                redirect('login','refresh');
                //echo "yei";
            }
        public function log($file,$msg)
            {
                file_put_contents(FCPATH."application/logs/".$file,"\n".$msg,FILE_APPEND);
            }
	}