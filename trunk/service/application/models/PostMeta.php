<?php
require_once "Ice/Db/Table.php";
class PostMeta extends Ice_Db_Table {
   
    public function __construct() {
        $this -> key = 'id';
        $this -> table = 'wp_postmeta';
        parent::__construct();
    }    
    
	public function getPostThumbById($id){
         $query = "select s2.meta_value
				  from wp_postmeta
				  inner join
				  (
					 select * from wp_postmeta where `meta_key` = '_wp_attached_file'
				  ) s2
					on wp_postmeta.meta_value = s2.post_id
				  where wp_postmeta.post_id = ".$id;
        $result = $this->query($query);
										
        if($result != null && $result != false && count($result) > 0){          
            return $result[0]->meta_value;
        }
        else{
            return null;
        }
    }
	
	
}

