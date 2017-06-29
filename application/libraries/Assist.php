<?php
class Assist 
	{
	   var $codeigniter;
	   public function __construct()
	   		{
	   			$this->codeigniter = & get_instance();
	   		}
	   public function secu($username,$password)
			{
               $key=sha1($username);
               $password=substr(md5($password),5,20);
               $key=substr($key,7,5);
               return md5($key.$password);
			}  	
		public function passgen($size)
            {
                $seed = str_split('abcdefghijklmnopqrstuvwxyz'
        			.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        			.'0123456789'
        			.'%$#!@_=&');
                 shuffle($seed);
                 $rand = '';
                 foreach (array_rand($seed,$size) as $k){ $rand .= $seed[$k]; }       	
                  return $rand;
            }
    public function picuploads($x=NULL,$config=NULL)
            {
                $config['upload_path']= FCPATH."images";
                $config['allowed_types']='gif|jpg|png|jpeg';
                $config['file_ext_tolower']= TRUE;
                $config['file_name'] = "FILE-".time();              
                $this->codeigniter->load->library('upload', $config);
                if( ! $this->codeigniter->upload->do_upload('userfile'))
                  {
                    $error = array('error' => $this->codeigniter->upload->display_errors());
                    $this->output->set_output(json_encode($error));
                  }
                else
                  {
                    $data = array('upload_data' => $this->codeigniter->upload->data());
                    if($x=="upload")
                      {
                         return $data;
                      }
                    else
                       {
                          $this->output->set_output($data["upload_data"]["file_name"]);
                       }  
                    
                  }
            }
        public function page($baseurl,$total_rows,$vpp,$urlsegment)
            {
               
                $this->codeigniter->load->library('pagination');
                $config['base_url'] = $baseurl;
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $vpp;
                $config['uri_segment'] = $urlsegment;
                $config['num_links'] = 9;
                $config['page_query_string'] = TRUE;
                $config['query_string_segment'] = 'page';
                $config['full_tag_open'] = '<div><ul  class="pagination">';
                $config['full_tag_close'] = '</ul></div><!--pagination-->';
                $config['first_link'] = '&laquo; First';
                $config['first_tag_open'] = '<li class="prev page">';
                $config['first_tag_close'] = '</li>';
                $config['last_link'] = 'Last &raquo;';
                $config['last_tag_open'] = '<li class="next page">';
                $config['last_tag_close'] = '</li>';
                $config['next_link'] = 'Next &rarr;';
                $config['next_tag_open'] = '<li class="next page">';
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = '&larr; Previous';
                $config['prev_tag_open'] = '<li class="prev page">';
                $config['prev_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active"><a href="">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li class="page">';
                $config['num_tag_close'] = '</li>';
                //$config['display_pages'] = FALSE;//
                $config['anchor_class'] = 'follow_link';
                $this->codeigniter->pagination->initialize($config);
                $data["links"] = $this->codeigniter->pagination->create_links();
                $data['vpp']=$config['per_page'];
                return (object)$data;
            }
        public function log($file,$msg)
            {
                file_put_contents(FCPATH."application/logs/".$file,"\n".$msg,FILE_APPEND);
            }
	}
?>