<?php
require_once "Ice/Db/Table.php";
require_once "PostMeta.php";
class Posts extends Ice_Db_Table {
   
    public function __construct() {
        $this -> key = 'id';
        $this -> table = 'wp_posts';
        parent::__construct();
    }
    public function getAllPosts() {
        $result = $this->select("post_status like 'publish' and post_title <> '' ");
        if($result != null && $result != false){
            $array = array();
			$postMeta = new PostMeta();
            for($i = 0; $i < count($result); ++$i) {
                    $array[$i] = array();
                    $array[$i]['post_title'] = $result[$i]->post_title;
                    $array[$i]['post_content'] = $result[$i]->post_content;
                    $array[$i]['post_date'] = $result[$i]->post_date;
					$array[$i]['guid'] = $result[$i]->guid;
					$array[$i]['post_subtitle'] = $result[$i]->post_subtitle;
					$array[$i]['post_img'] = $postMeta->getPostThumbById($result[$i]->object_id);
            }
            return $array;
        }
        else{
            return null;
        }
    }
    
    public function getTopFivePosts(){
        $result = $this->select("post_status like 'publish' and post_title <> '' ", 
                                null,
                                "post_date DESC LIMIT 0, 5");
        if($result != null && $result != false){
            $array = array();
			$postMeta = new PostMeta();
            for($i = 0; $i < count($result); ++$i) {
                    $array[$i] = array();
                    $array[$i]['post_title'] = $result[$i]->post_title;
                    $array[$i]['post_content'] = $result[$i]->post_content;
                    $array[$i]['post_date'] = $result[$i]->post_date;
					$array[$i]['guid'] = $result[$i]->guid;
					$array[$i]['post_subtitle'] = $result[$i]->post_subtitle;
					$array[$i]['post_img'] = $postMeta->getPostThumbById($result[$i]->ID);
            }
            return $array;
        }
        else{
            return null;
        }
    }

    public function getTopFiveWithCategoryPosts($category){
        $query = "SELECT * 
                FROM  wp_term_relationships AS a,  wp_posts AS b
                where a.object_id = b.id and a.term_taxonomy_id = ".$category." Limit 0, 5";
        $result = $this->query($query);
        if($result != null && $result != false){
            $array = array();
			$postMeta = new PostMeta();
            for($i = 0; $i < count($result); ++$i) {
                    $array[$i] = array();
                    $array[$i]['post_title'] = $result[$i]->post_title;
                    $array[$i]['post_content'] = $result[$i]->post_content;
                    $array[$i]['post_date'] = $result[$i]->post_date;
					$array[$i]['post_subtitle'] = $result[$i]->post_subtitle;
					$array[$i]['guid'] = $result[$i]->guid;
					$array[$i]['post_img'] = $postMeta->getPostThumbById($result[$i]->object_id);
            }
            return $array;
        }
        else{
            return null;
        }
    }
	
	 public function getOrdersWithCategoryPosts($category){
        $query = "SELECT * 
                FROM  wp_term_relationships AS a,  wp_posts AS b
                where a.object_id = b.id and a.term_taxonomy_id = ".$category;
        $result = $this->query($query);
        if($result != null && $result != false){
            $array = array();
			$postMeta = new PostMeta();
            for($i = 0; $i < count($result); ++$i) {
                    $array[$i] = array();
                    $array[$i]['post_title'] = $result[$i]->post_title;
                    $array[$i]['post_content'] = $result[$i]->post_content;
                    $array[$i]['post_date'] = $result[$i]->post_date;
					$array[$i]['guid'] = $result[$i]->guid;
					$array[$i]['post_subtitle'] = $result[$i]->post_subtitle;
					$array[$i]['post_img'] = $postMeta->getPostThumbById($result[$i]->object_id);
            }
            return $array;
        }
        else{
            return null;
        }
    }
	
	 public function getPostById($id){
        $result = $this->select("id = ".$id);
        if($result != null && $result != false){
            $array = array();
			$postMeta = new PostMeta();
            for($i = 0; $i < count($result); ++$i) {
                    $array[$i] = array();
                    $array[$i]['post_title'] = $result[$i]->post_title;
                    $array[$i]['post_content'] = nl2br($result[$i]->post_content);
                    $array[$i]['post_date'] = $result[$i]->post_date;
					$array[$i]['guid'] = $result[$i]->guid;
					$array[$i]['post_subtitle'] = $result[$i]->post_subtitle;
					$array[$i]['post_img'] = $postMeta->getPostThumbById($result[$i]->ID);
            }
            return $array;
        }
        else{
            return null;
        }
    }
}

