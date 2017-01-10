<?php
namespace Common\Model;
use Think\Model;

class PositionModel extends Model{
	private $_db = '';

	public function __construct(){
		$this->_db = M('Position');
	}

	public function getPosition($data){
		$data['status'] = array('neq', -1);
		$list = $this->_db->where($data)->order('id desc')->select();
		return $list;
	}

	public function insert($data = array()){
		if (!$data || !is_array($data)) {
			return 0;
		}

		$data['create_time'] = time();

		return $this->_db->add($data);
	}

	public function find($id){
		if(!is_numeric($id) || !$id){
			//执行跳转
			$this->redirect('/admin.php?c=position');
		}
		return $this->_db->where('id='.$id)->find();
	}

	public function getBarPosition(){
		$data = array(
			'status' => array('neq',-1),
		);

		$res = $this->_db->where($data)
			->order('id')
			->select();

		return $res;
	}

	public function updateById($id, $data){
		if(!$id || !is_numeric($id)){
			throw_exception('ID不合法');
		}
		if(!$data || !is_array($data)){
			throw_exception('更新数据不合法');
		}

		return $this->_db->where('id='.$id)->save($data);
	}

	public function updateStatusById($id, $status){
		if(!is_numeric($status)){
			throw_exception('ststus不合法');
		}
		if(!$id || !is_numeric($id)){
			throw_exception('ID不合法');
		}
		$data['status'] = $status;

		return $this->_db->where('id='.$id)->save($data);
	}
}