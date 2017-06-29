<?php
class Pasha_model extends CI_MODEL
	{
		public function __construct()
			{
				parent::__construct();
			}
		public function getNav()
			{
				$this->db->where('inactive is null');
				$dbh=$this->db->get('article_category');
				if($dbh!=FALSE)
					{
						if($dbh->num_rows()>0)
							{
								return $dbh->result();
							}
					}
				
			}
		public function getArticle($id,$title)
			{

			}
		public function getPopular()
			{
				
			}
		public function getRelated($keyword)
			{
				
			}	
	}