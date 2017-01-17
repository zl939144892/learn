<?php
namespace Home\Controller;
use Think\Controller;

class CatController extends CommonController{
	public function index(){
		$id = intval($_GET['id']);
		if(!$id){
			return $this->error('ID错误');
		}

		$nav = D('Menu')->find($id);
		if(!$nav || $nav['status'] != 1){
			return $this->error('ID不存在或状态不正常');
		}
		$advNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>5), 2);
		$rankNews = $this->getRank();

		$page = $_GET['p'] ? $_GET['p'] : 1;
		$pageSize = 20;
		$conds = array(
			'ststus'=>1,
			'thumb'=>array('neq', ''),
			'catid'=>$id,
		);
		$news = D('News')->getNews($conds, $page, $pageSize);
		$count = D('News')->getNewsCount($conds);
		$positions = D('Position')->getBarPosition();

		$res = new \Think\Page($count, $pageSize);
		$pageres = $res->show();

		$this->assign('result', array(
			'advNews'=>$advNews,
			'rankNews'=>$rankNews,
			'catId'=>$id,
			'listNews'=>$news,
			'pageres'=>$pageres,
		));
		$this->display();
	}
}