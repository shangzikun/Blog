<?php

class ClassifyController {
	public function __construct() {

	}
	public function add() {
		$classifyModel = new ClassifyModel();
		$classify=$classifyModel->getLists();
		include"./view/classify/add.html";
	}
	public function doAdd() {
		$classifyModel = new ClassifyModel();
		$name = $_POST['name'] ? $_POST['name'] : '' ;
		$parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : 0 ;
		$status = $classifyModel->add($name,$parent_id);
		if ($status) {
			header('Refresh:2,Url=index.php?c=blog&a=add');
			echo "添加成功";
		}
	}
	public function lists() {
		$classifyModel = new ClassifyModel();
		$data = $classifyModel->lists();
		include "./view/classify/lists.html";
	}
	public function onLine() {
		$id = $_GET['id'];
		$classifyModel = new ClassifyModel();	
		$data = $classifyModel->audit($id,1);
		if ($data) {
			header('Refresh:1,Url=index.php?c=classify&a=lists');
			echo "上线成功";
		}
	}
	public function offLine() {
		$id = $_GET['id'];
		$classifyModel = new ClassifyModel();
		$data = $classifyModel->audit($id,0);
		if ($data) {
			header('Refresh:1,Url=index.php?c=classify&a=lists');
			echo "下线成功";
		}
	}
	public function edit() {
		$id = $_GET['id'];
		$classifyModel = new ClassifyModel();
		$classify=$classifyModel->getLists();
		$data=$classifyModel->getInfoById($id);
		include"./view/classify/edit.html";
	}
	public function doEdit() {
		$id =$_POST['id'];
		$classifyModel = new ClassifyModel();
		$name = $_POST['name'] ? $_POST['name'] : '' ;
		$parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : 0 ;
		$status = $classifyModel->edit($name,$parent_id,$id);
	
		if ($status) {
			header('Refresh:1,Url=index.php?c=classify&a=lists');
			echo "修改成功";
		}
	}
}