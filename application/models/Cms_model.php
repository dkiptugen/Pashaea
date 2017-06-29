<?php
class Cms_model extends CI_Model
	{
		public function __construct()
			{
				parent::__construct();
			}
		public function getCategories($limit=null,$start=0)
			{   
				if($limit!=null)
					{
						$this->db->limit($limit,$start);
					}
				$this->db->where("inactive is null");
				$dbh=$this->db->get("article_category");
				if($dbh->num_rows()>0)
					{
						return $dbh->result();
					}
				else
					{
                      	return NULL;
					}
			}
		public function addArticle($x)
		    {	    	 

		    	$data=array(
					         	"title"=>$this->input->post("title"),
					        	"story"=>$this->input->post("content"),
					        	"homepagelistorder"=>$this->input->post("home_list"),
					        	"parentcategorylistorder"=>$this->input->post("parent_list"),
					        	"listorder"=>$this->input->post("parent_list"),
					        	"keywords"=>$this->input->post("keywords"),
					        	"categoryid"=>$this->input->post("category"),
					        	"thumbcaption"=>$this->input->post("caption"),
					        	"thumbURL"=>$x,
					        	"alt"=>$this->input->post("alt"),
					        	"summary"=>$this->input->post("summary"),
					        	"related_video"=>$this->input->post("r_video"),
					        	"publishdate"=>date('Y-m-dTH:i:s'),
					        	"publishday"=>date('Y-m-dTH:i:s'),
					        	"posteddate"=>date('Y-m-d'),
					        	"inactive"=>NULL,
                                "createdby"=>(int)$this->session->userdata('id'),
                                "author_id"=>(int)$this->session->userdata('id'),
 								"author"=>$this->input->post("author")
					        );

				if($this->input->post("submit")=='save')
					{
					  	$data["published"]=0;
					}
				else
			        {
			      	    $data["published"]=1;
			        }  
			       // var_dump($data);
                $this->db->where("title",$this->input->post("title"));
                $dbh=$this->db->get("article");
                if($dbh->num_rows()>0)
                   {

                   	  $this->db->where("id",$dbh->row()->id);
                   	  $this->db->update("article",$data);
                   	  return ($this->db->affected_rows()>0)?"Article - ".$data["title"]." created successfully":"Article update failed".json_encode($this->db->error());
                   }
                else
                   {    
                   	    //$this->db->where("id",$dbh->row()->id);

                   		$this->db->insert("article",$data);
                   		return ($this->db->affected_rows()>0)?"Data insert successful":"Article creation failed".json_encode($this->db->error());
                   }   
		    }	
		public function addCategory()
			{  
				$data=array(
					         	"categoryname"=>$this->input->post("catName"),
					        	"description"=>$this->input->post("description"),
					        	"categorylistorder"=>$this->input->post("categorylistorder")
					        );
				if($this->input->post("save"))
					{
					  	$data["inactive"]="b:1";
					}
				else
			        {
			      	    $data["inactive"]=NULL;
			        }  
                $this->db->like("categoryname",$this->input->post("catName"));
                $dbh=$this->db->get("category");
                if($dbh->num_rows()>0)
                   {
                   	  $this->db->where("id",$dbh->row()->id);
                   	  $this->db->update("category",$data);
                   	  return ($this->db->affected_rows()>0)?"Data updated successful":"category update failed";
                   }
                else
                   {    
                   	    //$this->db->where("id",$dbh->row()->id);
                   		$this->db->insert("category",$data);
                   		return ($this->db->affected_rows()>0)?"Category ".$data["categoryname"]." created successfully":"Category creation failed";
                   }   
				
			}	
		public function viewArticles($limit,$start)
			{
				$this->db->limit($limit,$start);
		        $dbh=$this->db->get("article");
		        if($dbh->num_rows()>0)
		            {
		              return $dbh->result();
		            }
			}
	    public function getNoArticles()
	    	{
	    		$dbh=$this->db->get("article");
	    		return $dbh->num_rows();
	    	}
	}