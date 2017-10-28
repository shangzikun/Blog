<?php
	class HomeController {

	public function __construct() {

	}
	public function index() {
		$blogModel = new BlogModel();
		$ClassifyModel = new ClassifyModel();
		$data = $blogModel->getBlogLists(0,30,'id desc');
		foreach ($data as $key => $value) {
			$data[$key]['year']= substr($value['createtime'], 0,5);
			$data[$key]['month']= substr($value['createtime'], 5,5);
			$classify_info = $ClassifyModel->getClassifyInfoById($value['classify_id']);
			$data[$key]['classify_name']= $classify_info['name'];
		}
		include"./view/home/index.html";
	}
	public function blogInfo() {
		$id = $_GET['id'];
		$blogModel = new BlogModel();
		$classifyModel = new ClassifyModel();
		$userModel = new UserModel();
		$commentModel = new CommentModel();
		$blogInfo = $blogModel->getBlogInfoById($id);
		$blogInfo['createtime']=substr($blogInfo['createtime'], 0,10);		
		$where = "classify_id = {$blogInfo['classify_id']} and id !={$id} ";
		$data = $blogModel->getBlogLists(0,10,'id desc',$where);
		$commentWhere = "blog_id = {$blogInfo['id']}";
		$commentLists = $commentModel->getLists(0,20,'id desc',$commentWhere);
		$commentCount = $commentModel->getCount($commentWhere);
		foreach ($commentLists as $key => $comment) {
			$userInfo = $userModel->getUserInfoById($comment['user_id']);
			$commentLists[$key]['author'] = $userInfo;
		}
		include "./view/home/blogInfo.html";
	
	}
	public function study() {
		$classify_id = isset($_GET['classify_id']) ? $_GET['classify_id'] : 0;
			$where = '1';
			if ($classify_id) {
				$where .= " and classify_id in ({$classify_id})";
			} else {
				$where .= " and classify_id in (4,5,6)";
			}
			$where .= " and status = 1";
			
		$blogModel = new BlogModel();
		$ClassifyModel = new ClassifyModel();
		$data = $blogModel->getBlogLists(0,30,'id desc',$where);
		foreach ($data as $key => $value) {
			$data[$key]['year']= substr($value['createtime'], 0,5);
			$data[$key]['month']= substr($value['createtime'], 5,5);
			$classify_info = $ClassifyModel->getClassifyInfoById($value['classify_id']);
			$data[$key]['classify_name']= $classify_info['name'];
		}
		$classify = $ClassifyModel->getClassifyLists(2);
		include "./view/home/study.html";
	}
	public function life() {
		$classify_id = isset($_GET['classify_id']) ? $_GET['classify_id'] : 0;
			$where = '1';
			if ($classify_id) {
				$where .= " and classify_id in ({$classify_id})";
			} else {
				$where .= " and classify_id in (4,5,6)";
			}
			$where .= " and status = 1";
			
		$blogModel = new BlogModel();
		$ClassifyModel = new ClassifyModel();
		$data = $blogModel->getBlogLists(0,30,'id desc',$where);
		foreach ($data as $key => $value) {
			$data[$key]['year']= substr($value['createtime'], 0,5);
			$data[$key]['month']= substr($value['createtime'], 5,5);
			$classify_info = $ClassifyModel->getClassifyInfoById($value['classify_id']);
			$data[$key]['classify_name']= $classify_info['name'];
		}
		$classify = $ClassifyModel->getClassifyLists(1);
		include "./view/home/life.html";

	}
	public function doComment() {
		$blog_id = $_POST['blog_id'];
		$user_id = $_SESSION['me']['id'];
		$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0 ; 
		$content = $_POST['content'];
		if (!isset($_SESSION['me']['id']) || !$_SESSION['me']['id']) {
			header('Refresh:1,Url=index.php?c=UserCenter&a=login');
			echo "请登录";
			die();
		} 
		if (!$blog_id || !$content) {
			die("参数错误，请重新评论！");			
		}
		$commentModel = new CommentModel();
		$commentModel = $commentModel->add($blog_id,$user_id,$parent_id,$content);
		if ($commentModel) {
			header('Location:index.php?c=Home&a=blogInfo&id='.$blog_id);
			echo ("评论成功");
			die();
		}		
	}
	public function back() {
			echo "<script>alert('返回上一页');history.go(-2);</script>";  

		}
}