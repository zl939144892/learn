<?php
/**
 * 后台菜单相关
 */
namespace Admin\Controller;
use Think\Controller;
/**
 * 推荐位管理
 */
class PositionController extends CommonController{
	public function index(){
		$data = array();

		$page = $_GET['p'] ? $_GET['p'] : 1;
		$pageSize = $_GET['pageSize'] ? $_GET['pageSize'] : 10;
		$position = D('Position')->getPosition($data);

		$this->assign('positions', $position);

		return $this->display();
	}

	public function add(){
		if($_POST){
			if(!isset($_POST['name']) || !$_POST['name']){
				return show(0, '推荐位名称不能为空');
			}
			if(!isset($_POST['description']) || !$_POST['description']){
				return show(0, '推荐位描述不能为空');
			}
			if($_POST['id']){
				return $this->save($_POST);
			}

			$positionsId = D('Position')->insert($_POST);
			if($positionsId){
				return show(1, '新增成功', $positionsId);
			}
			return show(0, '新增失败', $positionsId);
		}else{
			return $this->display();
		}
	}

	public function edit(){
		$positionId = $_GET['id'];
		if(!$positionId){
			//执行跳转
			$this->redirect('/admin.php?c=position');
		}
		$vo = D('Position')->find($positionId);
		if(!$vo){
			$this->redirect('/admin.php?c=position');
		}

		$this->assign('vo', $vo);
		$this->display();
	}

	public function save($data){
		$positionId = $data['id'];
		unset($data['id']);

		try{
			$id = D('Position')->updateById($positionId, $data);
			$positionContentData['content'] = $data['content'];
			if($id === false){
				return show(0, '更新失败');
			}
			return show(1, '更新成功');
		}catch(Exception $e){
			return show(0, $e->getMessage());
		}
	}

	public function setStatus(){
		$data = array(
			'id' => intval($_POST['id']),
			'status' => intval($_POST['status']),
		);
		return parent::setStatus($data, 'Position');
	}
}