<?php
class Accounts extends CI_Model
	{
		public function __construct()
		  	{
		  		parent::__construct();
		  	}
    public function getUsers($limit,$start)
      {
          $this->db->limit($limit,$start);
          $dbh=$this->db->get("users");
          if($dbh->num_rows()>0)
            {
              return $dbh->result();
            }
      }
    public function getNoUsers()  
      {
        $dbh=$this->db->get("users");
        return $dbh->num_rows();
      }
    public function add_user($j)
      {
        $authkey=$this->assist->passgen(8);
        $password=$this->assist->secu($authkey,$j['password']);
        $name=$j['f_name'].' '.$j['l_name'];
        //var_dump($j);
        //file_put_contents(FCPATH."application/logs/add_account_mod.log","\n".$name,FILE_APPEND);
        $data=array(
                      'Name'=>ucwords($name),
                      'username'=>$j['username'],
                      'email'=>$j['email'],
                      'password'=>$password,
                      'auth_key'=>$authkey,
                      'user_status'=>(isset($j['Inactive']))?0:1,
                      'pass_status'=>(isset($j['col']))?1:0
                    );
        $dbh=$this->db->where('email',$j['email'])->or_where('username',$j['username'])->get('users');
        if($dbh->num_rows()>0)
          {
            return 'user or username already exists';
          }
        else
         {
            $this->db->insert('users',$data);
            if($this->db->affected_rows()>0)
              {
                return 'User created successfully';
              }
            else
              {
                return 'Failed to create user';
              }
          }
      }
    public function modify_user_status($id,$type)
      {

        $this->db->where('id',$id)->update('users',array('user_status'=>$type));
        if($this->db->affected_rows()>0)
          {
             return 'user updated';
          }
        else
          { 
            return 'user not updated'.json_encode($this->db->error());
          }
      }
    public function delete_user($id)
      {

        $this->db->where('id',$id)->delete('users');
        if($this->db->affected_rows()>0)
          {
             return 'user deleted successfully'.$this->input->ip_address();
          }
        else
          { 
            return 'user not updated'.json_encode($this->db->error());
          }
      }
		public function login()
			{   
				$dbh=$this->db->get("users");
				if($dbh->num_rows()<1)
					{
						//#!2016Fa5h!0N
                       	if(($this->input->post("email")=="admin@aaf.com")&($this->input->post("password")=="1234"))
                       		{
                       			$roles=array("article"=>array("edit","delete","disable"),"users"=>array("edit","delete","disable"));
                       			$x=array("id"=>"#1","Name"=>"DEFAULT ADMIN","Designation"=>"System Administrator","email"=>"admin@aaf.com","password"=>"#!2016Fa5h!0N","role"=>json_encode($roles),"pass_status"=>1,"user_status"=>1,"user_image"=>base_url("cms-assets/dist/img/user2-160x160.jpg"));
                       			return (object)$x;
                       		}
                       	else
                       	    {
                       	    	 $msg=array("error"=>"Invalid username or password");
                       	    	 return (object)$msg;
                       	    }	
					}
				else
					{
						
						$this->db->where("email",$this->input->post("email"));
            $this->db->or_where("username",$this->input->post("email"));
						$dbh=$this->db->get("users");
		        if($dbh->num_rows()>0)
		          {
                $password=$this->assist->secu($dbh->row()->auth_key,$this->input->post("password"));
                //return $password;
                $this->db->where("password",$password)
                        ->where("username",$dbh->row()->username);
                $dbh=$this->db->get("users");
                if($dbh->num_rows()>0)
                  {
    		            return $dbh->row();
                  }
                else
                  {
                    $msg=array("error"=>"Invalid username or password");
                    return (object)$msg;
                  } 
		          } 
		        else
              {
                $msg=array("error"=>"Invalid username or password");
                return (object)$msg;
              }	
					}	
				
			}
	    public function changepassword()
	    	{
                $this->db->where("email",$this->input->post("email"));
                $dbh=$this->db->get("users");
                if($dbh->num_rows()>0)
                	{   
                		$pass=$this->assist->passgen(15);
                    $authkey=$this->assist->passgen(8);
                		$password=$this->assist->secu($authkey,$pass);
                		$this->db->where("email",$this->input->post("email"));
                		$this->db->update("users",array("password"=>$password,"auth_key"=>$authkey));
                		if($this->db->affected_rows()>0)
                		   {
                		   	 	return (object)array("message"=>"New password sent to ".$this->input->post("email"),"email"=>$this->input->post("email"),"password"=>$pass);
                		   }
                		else
                		   {
                             	return (object)array("error"=>"password not changed");
                		   }  
                	}
                else
                	{
                        return (object)array("error"=>"Email does not exist");
                	}  	
	    	}
	    public function register()
	    	{

	    	}	
	}