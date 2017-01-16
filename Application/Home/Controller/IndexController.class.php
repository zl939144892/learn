<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends CommonController {
	public function index(){
		//获取排行
		$rankNews = $this->getRank();
		//获取首页大图数据
		$topPicNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>2), 1);
		//首页三张小图推荐
		$topSmallNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>3), 3);
		//首页内容
		$listNews = D('News')->select(array('status'=>1, 'thumb'=>array('neq', '')), 30);
		//广告位管理
		$advNews = D('PositionContent')->select(array('status'=>1, 'position_id'=>5), 2);

		$this->assign('result', array(
			'topPicNews'=>$topPicNews,
			'topSmallNews'=>$topSmallNews,
			'listNews'=>$listNews,
			'advNews'=>$advNews,
			'rankNews'=>$rankNews,
			'catId'=>0,
		));
		$this->display();
	}
}