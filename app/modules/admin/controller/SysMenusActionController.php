<?php

namespace app\modules\admin\controller;

use app\modules\admin\model\SysMenuAction;

class SysMenusActionController extends ControllerBase{
	/* 首页 */
	function indexAction(){
		// 分页
		if(isset($_GET['search'])){
			$like = $this->pageWhere();
			// 生成搜索条件
			$where = '';
			foreach ($like['data'] as $key => $val){
				$where .= $key." LIKE '%".$val."%' AND ";
			}
			$where = rtrim($where,'AND ');
			$getUrl = $like['getUrl'];
		}else{
			$where = '';
			$getUrl = '';
		}
		// 数据
		$this->setVar('List',$this->page([
			'model'=>'SysMenuAction',
			'where'=>$where,
			'getUrl'=>$getUrl
		]));

		// 获取菜单
		$this->setVar('Menus',$this->getMenus());

		// 传递参数
		$this->setVar('LoadJS', array('system/sys_menus_action.js'));
		$this->setTemplate('main','system/action/index');
	}
	/* 搜索 */
	function searchAction(){
		$this->view('system/action/sea');
	}
	/* 添加 */
	function addAction(){
		$this->view('system/action/add');
	}
	function addDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'name'=>trim($_POST['name']),
				'perm'=>trim($_POST['perm']),
				'ico'=>trim($_POST['ico']),
			];
			// 返回信息
			if(SysMenuAction::add($data)){
				echo json_encode(array('state'=>'y','url'=>'SysMenusAction','msg'=>'添加成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'添加失败！'));
			}
		}
	}
	/* 编辑 */
	function editAction(){
		// 视图
		$this->setVar('edit',SysMenuAction::findfirst(['where'=>'id='.$_POST['id']]));
		$this->view('system/action/edit');
	}
	function editDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'name'=>trim($_POST['name']),
				'perm'=>trim($_POST['perm']),
				'ico'=>trim($_POST['ico']),
			];
			// 返回信息
			if(SysMenuAction::update($data,'id='.$_POST['id'])){
				echo json_encode(array('state'=>'y','url'=>'SysMenusAction','msg'=>'编辑成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'编辑失败！'));
			}
		}
	}
	/* 删除 */
	function delAction(){
		$this->view('system/action/del');
	}
	function delDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = json_decode($_POST['id']);
			$data = array();
			foreach ($id as $val){
				$data[] = 'id='.$val;
			}
			// 实例化
			if(SysMenuAction::del($data)===true){
				echo json_encode(array('state'=>'y','url'=>'SysMenusAction','msg'=>'删除成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'删除失败！'));
			}		
		}
	}
}