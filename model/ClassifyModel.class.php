<?php
class ClassifyModel extends Model{

	public function add($name,$parent_id) {
		$sql = "insert into classify(name,parent_id) values('{$name}',{$parent_id})";
		$res = $this->mysqli->query($sql);
		return $res;
	}
	public function getLists($parent_id=0) {
		$sql = "select * from classify where parent_id={$parent_id}";
		$res=$this->mysqli->query($sql);
		$data=$res->fetch_all(MYSQL_ASSOC);
		return $data;
	}
	public function getClassifyLists($parent_id=0) {
		$sql = "select * from classify where parent_id={$parent_id}";
		$res=$this->mysqli->query($sql);
		$data=$res->fetch_all(MYSQL_ASSOC);
		foreach ($data as $key => $value) {
			$sqlChild = "select * from classify where parent_id = {$value['id']}";
			$resChild = $this->mysqli->query($sqlChild);
			$child = $resChild->fetch_all(MYSQL_ASSOC);
			$data[$key]['child']=$child;
		}
		return $data;
	}
	public function lists() {
		$sql = "select * from classify ";
		$res=$this->mysqli->query($sql);
		$data=$res->fetch_all(MYSQL_ASSOC);
		return $data;
	}
	public function audit($id,$status=0) {
		$sql ="update classify set status = {$status} where id = {$id}";
		$res=$this->mysqli->query($sql);
		return $res;
	}
	public function edit($name,$parent_id,$id) {
		$sql = "update classify set name='{$name}',parent_id={$parent_id} where id= {$id}";
		$res = $this->mysqli->query($sql);
		return $res;
	}
	public function getInfoById($id) {
		$sql = "select * from classify where id = {$id}";
		$res = $this->mysqli->query($sql);
		$data = $res->fetch_all(MYSQL_ASSOC);
		return isset($data[0]) ? $data[0] :array();
	}
	public function getClassifyInfoById($id) {
			$sql = "select * from classify where id = {$id}";
			$res = $this->mysqli->query($sql);
			$data = $res->fetch_all(MYSQL_ASSOC);
			return isset($data[0]) ? $data[0] : 0;
		}
}