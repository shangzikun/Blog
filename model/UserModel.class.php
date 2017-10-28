<?php

class UserModel extends Model {

	public function addUser($name,$email,$password,$image) {
			$createtime = date("Y-m-d H:i:s");
			$sql = "insert into user(name,email,password,image,createtime) value ('{$name}', '{$email}', '{$password}','{$image}','{$createtime}')";
			$res = $this->mysqli->query($sql);
			return $res;
	}
	public function getUserLists() {
			$sql = "select * from user";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQL_ASSOC);
			return $data;
	}
	public function getUserInfo() {
			$sql = "select * from user";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQL_ASSOC);
			// var_dump($data);
			// die();
			return isset($data[0]) ? $data[0] :array();
	}
	public function editUserInfo($name,$email,$password,$image,$id) {
			$sql = "update user set name='{$name}',email='{$email}',password='{$password}',image='{$image}' where id= {$id}";
			$res = $this->mysqli->query($sql);
			return $res;
	}
	public function getUserInfoById($id) {
			$sql = "select * from user where id = {$id}";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQL_ASSOC);
			return isset($data[0]) ? $data[0] :array();
	}
	public function getUserInfoByEmail($email) {
			$sql = "select * from user where email = '{$email}'";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQL_ASSOC);
			return isset($data[0]) ? $data[0] :array();
	}
}	