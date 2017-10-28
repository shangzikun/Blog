<?php

class CommentModel extends Model {

	public function add($blog_id,$user_id,$parent_id=0,$content='') {
		$createtime = date("Y-m-d H:i:s");
		$sql = "insert into comment(blog_id,user_id,parent_id,content,createtime) value ({$blog_id},{$user_id},{$parent_id},'{$content}','{$createtime}')";
		$res = $this->mysqli->query($sql);
		return $res;
	}
	public function getLists($offset=0,$limit=20,$order='id desc',$where='1') {
		$sql = "select * from comment where {$where} order by {$order} limit {$offset},{$limit}";
		$res = $this->mysqli->query($sql);
		$data = $res->fetch_all(MYSQLI_ASSOC);
		return $data;
	}
	public function getCount($where=1) {
		$sql = "select count(*) as num from comment where {$where}";
		$res = $this->mysqli->query($sql);
		$data = $res->fetch_all(MYSQLI_ASSOC);
		return isset($data[0]['num']) ? $data[0]['num'] : 0;
	}
} 