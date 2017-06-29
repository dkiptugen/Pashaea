<?php
class Pasha_home extends CI_Controller
	{
		public $data;
		public function __construct()
			{
             	parent::__construct();
             	$this->load->model('Pasha_model','pmodel');
             	$this->data['Navigation']=$this->pmodel->getNav();
			}
		public function home()
			{
			   $this->data["view"]='home';
               $this->load->view("includes/structure",$this->data);
			}
		public function article($id,$title=NULL)
			{
				$this->data['article']=$this->pmodel->getArticle($id,$title);
				//$this->data['relatedArticle']=$this->pmodel->getRelated($this->data['article']->Keywords);
				$this->data['popular']=$this->pmodel->getPopular();
                $this->data["view"]='article';
                $this->load->view("includes/structure",$this->data);
			}
		public function category($id,$title=NULL)
			{
                $this->data["view"]='category';
              	$this->load->view("includes/structure",$this->data);
			}
	}
?>