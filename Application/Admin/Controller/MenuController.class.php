<?php
/**
 * 后台菜单相关
 */
namespace Admin\Controller;
use Think\Controller;

class MenuController extends CommonController{
	public function add(){
		if($_POST){
			if(!isset($_POST['name']) || !$_POST['name']){
				return show(0, '菜单名不能为空');
			}
			if(!isset($_POST['m']) || !$_POST['m']){
				return show(0, '模块名不能为空');
			}
			if(!isset($_POST['c']) || !$_POST['c']){
				return show(0, '控制器不能为空');
			}
			if(!isset($_POST['f']) || !$_POST['f']){
				return show(0, '方法不能为空');
			}
			if($_POST['menu_id']){
				return $this->save($_POST);
			}

			$menuId = D('Menu')->insert($_POST);
			if($menuId){
				return show(1, '新增成功', $menuId);
			}
			return show(0, '新增失败', $menuId);

		}else{
			$this->display();
		}
		//echo 'Welcome';
	}

	public function index(){
		/**
		 * 分页操作逻辑
		 */
		$data = array();

		if(isset($_GET['type']) && in_array($_GET['type'], array(1, 2))){//搜索操作
			$data['type'] = intval($_GET['type']);
			$this->assign('type', $data['type']);//让form-control选择完成后保持selected状态
		}

		//以下是排序分页操作
		$page = $_GET['p'] ? $_GET['p'] : 1;
		$pageSize = $_GET['pageSize'] ? $_GET['pageSize'] : 10;
		$menus = D('Menu')->getMenus($data, $page, $pageSize);
		$menusCount = D('Menu')->getMenusCount($data);

		$res = new \Think\Page($menusCount, $pageSize);
		$pageRes = $res->show();
		$this->assign('pageRes', $pageRes);
		$this->assign('menus', $menus);

		$this->display();
	}

	public function edit(){
		$menuId = $_GET['id'];

		$menu = D('Menu')->find($menuId);
		$this->assign('menu',$menu);
		$this->display();
	}

	public function save($data){
		$menu_id = $data['menu_id'];
		unset($data['menu_id']);

		try{
			$id = D('Menu')->updateMenuById($menu_id, $data);
			if($id === flase){
				return show(0, '更新失败！');
			}
			return show(1, '更新成功！');
		}catch(Exception $e){
			return show(0, $e->getMessage());
		}
	}
}