<?php
/**
 * 推荐位内容管理
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends CommonController{
	public function index(){print_r($_POST);
		$positions = D('Position')->getBarPosition();//获取推荐位
		$data['status'] = array('neq', -1);
		if($_GET['title']){
			$data['title'] = trim($_GET['title']);
			$this->assign('title', $data['title']);
		}
		$data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
		$contents = D('PositionContent')->select($data);

		$this->assign('positions', $positions);
		$this->assign('contents', $contents);
		$this->assign('positionId', $data['position_id']);
		$this->display();
	}

	public function add(){
		if($_POST){
			if(!isset($_POST['position_id']) || !$_POST['position_id']){
				return show(0, '推荐位ID不能为空');
			}
			if(!isset($_POST['title']) || !$_POST['title']){
				return show(0, '推荐位标题不能为空');
			}
			if(!$_POST['news_id'] && !$_POST['url']){
				return show(0, 'URL和文章ID不能同时为空');
			}
			if(!isset($_POST['thumb']) || !$_POST['thumb']){
				if($_POST['news_id']){
					$res = D('News')->find($_POST['news_id']);
					if($res && is_array($res)){
						$_POST['thumb'] = $res['thumb'];
					}
				}else{
					return show(0, '图片不能为空');
				}
			}
			if($_POST['id']){
				return $this->save($_POST);
			}
			try{
				$id = D('PositionContent')->insert($_POST);
				if($id){
					return show(1, '新增成功');
				}
				return show(0, '新增失败');
			}catch(Exception $e){
				return show(0, $e->getMessage());
			}
		}else{
			$positions = D('Position')->getBarPosition();

			$this->assign('positions', $positions);
			$this->display();
		}
	}

	public function edit(){
		$id = $_GET['id'];
		$position = D('PositionContent')->find($id);
		$positions = D('Position')->getBarPosition();

		$this->assign('vo', $position);
		$this->assign('positions', $positions);
		$this->display();
	}

	public function save($data){
		$id = $data['id'];
		unset($data['id']);

		try{
			$resId = D('PositionContent')->updateById($id, $data);
			if($resId === false){
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
		return parent::setStatus($data, 'PositionContent');
	}

	public function listorder(){
		return parent::listorder('PositionContent');
	}
}