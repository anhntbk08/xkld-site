<?php
require_once 'BaseController.php';

class PostController extends BaseController
{
    protected $result = array();
    protected $token;
    protected $callback;

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);	
        $this->callback = $this->_getParam('callback');
        $this->token = $this->_getParam('token');	
    }
    
    public function listAction(){
        require_once 'models/Posts.php';
        $postsMapper = new Posts();
        $posts = $postsMapper->getAllPosts();
        return $this->result = array('success'=>true,'message'=>'Get List Posts successfully','posts'=>$posts); 
    }
	
	public function topfiveAction(){
        require_once 'models/Posts.php';
        $postsMapper = new Posts();        
        $posts = $postsMapper->getTopFivePosts();
        return $this->result = array('success'=>true,'message'=>'Get Top 5 Posts successfully','posts'=>$posts); 
    }

    public function topfiveOrderWithCategoryAction(){
        require_once 'models/Posts.php';
		$category = $this->_getParam('category');
		if ($category != null){
			$postsMapper = new Posts();        
			$posts = $postsMapper->getTopFiveWithCategoryPosts($category);
			return $this->result = array('success'=>true,'message'=>'Get List Posts successfully','posts'=>$posts); 
		}
		else{			
			return $this->result = array('success'=>false,'message'=>'Input category to query'); 
		}        
    }
	
	public function ordersWithCategoryAction(){
        require_once 'models/Posts.php';
		$category = $this->_getParam('category');
		if ($category != null){
			$postsMapper = new Posts();        
			$posts = $postsMapper->getOrdersWithCategoryPosts($category);
			return $this->result = array('success'=>true,'message'=>'Get List Posts successfully','posts'=>$posts); 
		}
		else{			
			return $this->result = array('success'=>false,'message'=>'Input category to query'); 
		}        
    }
	
	public function postByIdAction(){
        require_once 'models/Posts.php';
		$id = $this->_getParam('id');
		if ($id != null){
			$postsMapper = new Posts();        
			$posts = $postsMapper->getPostById($id);
			return $this->result = array('success'=>true,'message'=>'Get Post successfully','posts'=>$posts); 
		}
		else{			
			return $this->result = array('success'=>false,'message'=>'Input id to query'); 
		}        
    }
        
}

