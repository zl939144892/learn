<?php
namespace Common\Model;
use Think\Model;

/**
 * 推荐位wmodel操作
 * @author  singwa
 */
class PositionContentModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('position_content');
	}

	public function insert($res = array()) {
		if(!$res || !is_array($res)) {
			return 0;
		}
		if(!$res['create_time']) {
			$res['create_time'] = time();
		}

		return $this->_db->add($res);
	}

	public function select($data = array(), $limit = 0){
		if($data['title']){
			$data['title'] = array('like', '%'.$data['title'].'%');
		}
		$this->_db
			->where($data)
			->order('listorder desc, id desc');
		if($limit){
			$this->_db->limit($limit);
		}
		$list = $this->_db->select();

		return $list;
	}
}