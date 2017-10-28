<?php
	class BlogModel extends Model {

		function addBlog($data) {
			$sql = "insert into blog(content,image,title,classify_id,createtime) value ('{$data['content']}','{$data['image']}','{$data['title']}', '{$data['classify']}','{$data['createtime']}')";
			$res = $this->mysqli->query($sql);
			return $res;
		}
		function getBlogLists($offset=0,$limit=20,$order='id desc',$where='1') {
			$sql = "select * from blog where {$where} order by {$order} limit {$offset},{$limit}";
			// var_dump($sql);
			// die();
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQLI_ASSOC);
			return $data;
		}
		// function getUserInfoByName($name) {
		// 	$sql = "select * from user where name = '{$name}'";
		// 	$res = $this->mysqli->query($sql);
		// 	$data = $res->fetch_all(MYSQLI_ASSOC);
		// 	return $data[0];
		// }
		function getBlogInfoById($id) {
			$sql = "select * from blog where id = '{$id}'";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQLI_ASSOC);
			return isset($data[0]) ? $data[0] :array();
		}
		function getUserInfoById($id) {
			$sql = "select * from blog where id = '{$id}'";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQLI_ASSOC);
			return isset($data[0]) ? $data[0] :array();
		}
		function getBlogCount() {
			$sql = "select count(*) as num from blog ";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQLI_ASSOC);
			return $data[0];
		}
		public function audit($id,$status=0) {
		$sql ="update blog set status = {$status} where id = {$id}";
		$res=$this->mysqli->query($sql);
		return $res;
		}
	}
	