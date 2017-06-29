<?php
class Cms extends CI_Controller
    {
        public $data;
        public function __construct()
            {
                parent::__construct();
                $this->checkifloggedin();
                $this->load->model("Cms_model");
                $this->load->model("Accounts");
            }
        public function index()
            {
                try
                    {
                       $this->data["view"]="dashboard"; 
                       $this->load->view("cms/structure",$this->data);
                    }
                catch (Exception $e)
                    {
                        $this->log("cms.log","MAIN INDEX:".$e->getMessage());
                    }
            }
        public function checkifloggedin()
            {
                try
                    {
                        if ($_SESSION['login'] != TRUE)
                            {
                                redirect("login","refresh");
                            }
                    }
                catch (Exception $e)
                    {
                        $this->log("cms.log","CHECK LOGIN:".$e->getMessage());
                    }
            }        
        public function users($action=NULL,$id=NULL)
             {
                 try
                    {
                        $this->data['msg']='';
                        if($action!=NULL)
                            {  
                                if($action=='add')
                                    {    
                                        if($this->input->post('save'))
                                            {
                                                $this->data['msg']=$this->Accounts->add_user($this->input->post());
                                            }
                                    }
                                elseif($action=='inactivate')
                                    {
                                        $this->data['msg']=$this->Accounts->modify_user_status($id,0);
                                        $this->users();
                                    }
                                elseif($action=='activate')
                                    {
                                        $this->data['msg']=$this->Accounts->modify_user_status($id,1);
                                        $this->users();
                                    }

                                elseif($action=='delete')
                                    {
                                        $this->data['msg']=$this->Accounts->delete_user($id);
                                        $this->users();
                                    }
                            }
                        $pag=$this->assist->page(current_url(),$this->Accounts->getNoUsers(),5,3);
                        $this->data['user']=$this->Accounts->getUsers($pag->vpp,$this->input->get('page'));
                        $this->data["link"]=$pag->links; 
                        $this->data["view"]="users"; 
                        $this->load->view("cms/structure",$this->data);
                    }
                catch(Exception $e)
                    {
                        $this->assist->log("cms.log","users:  \n".$e->getMessage());
                    }
             }
        public function add_article()
            {
               
                $x=$this->assist->picuploads("upload")["upload_data"]["file_name"];
                //file_put_contents(FCPATH."application/logs/upload.log","\n".json_encode($x),FILE_APPEND);
                $this->data['msg']=$this->Cms_model->addArticle($x);
                $this->article();
            }
        public function article($action=NULL,$id=NULL)
             {
                 try
                    {
                        $this->data['msg']='';
                        
                        if($action=='create')
                            { 
                                $x=$this->assist->picuploads("upload")["upload_data"]["file_name"];           
                                $this->data['msg']=$this->Cms_model->addArticle($x);
                            }
                        elseif($action=='inactivate')
                            {
                                        
                            }
                        elseif($action=='activate')
                            {
                                        
                            }
                        elseif($action=='edit')
                            {
                                        
                            }
                         
                        $this->data['category']=$this->Cms_model->getCategories();
                        $pag=$this->assist->page(site_url('cms/article'),$this->Cms_model->getNoArticles(),5,3);
                        $this->data['article']=$this->Cms_model->viewArticles($pag->vpp,$this->input->get('page'));
                        $this->data["link"]=$pag->links; 
                        $this->data["view"]="article"; 
                        $this->load->view("cms/structure",$this->data);
                    }
                catch(Exception $e)
                    {
                        $this->assist->log("cms.log","users:  \n".$e->getMessage());
                    }
             }
        public function category()
             {
                 try
                    {
                        
                        $this->data['user']=$this->Cms_model->getCategories(5,0);
                        $this->data["view"]="category"; 
                        $this->load->view("cms/structure",$this->data);
                    }
                catch(Exception $e)
                    {
                        $this->assist->log("cms.log","users:  \n".$e->getMessage());
                    }
             }     
    }