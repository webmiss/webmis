<?php

namespace app\modules\admin\controller;

use app\library\Page;
use app\modules\admin\model\SysMenuAction;

class SysMenusActionController extends ControllerBase{
	/* 首页 */
	function indexAction(){
		// 分页
		if(isset($_GET['search'])){
			$like = Page::where();
			// 生成搜索条件
			$where = '';
			foreach ($like['data'] as $key => $val){
				$where .= $key." LIKE '%".$val."%' AND ";
			}
			$where = rtrim($where,'AND ');
			$getUrl = $like['getUrl'];
			self::setVar('getUrl', $like['search']);
		}else{
			$where = '';
			$getUrl = '';
		}
		// 数据
		self::setVar('List',Page::get([
			'model'=>'SysMenuAction',
			'where'=>$where,
			'getUrl'=>$getUrl
		]));

		// 获取菜单
		self::setVar('Menus',self::getMenus());

		// 传递参数
		self::setVar('LoadJS', ['system/sys_menus_action.js']);
		return self::setTemplate('main','system/action/index');
	}
	/* 搜索 */
	function searchAction(){
		return self::view('system/action/sea');
	}
	/* 添加 */
	function addAction(){
		return self::view('system/action/add');
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
				return json_encode(['state'=>'y','url'=>'SysMenusAction','msg'=>'添加成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'添加失败！']);
			}
		}
	}
	/* 编辑 */
	function editAction(){
		// 视图
		self::setVar('edit',SysMenuAction::findfirst(['where'=>'id='.$_POST['id']]));
		return self::view('system/action/edit');
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
				return json_encode(['state'=>'y','url'=>'SysMenusAction','msg'=>'编辑成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'编辑失败！']);
			}
		}
	}
	/* 删除 */
	function delAction(){
		return self::view('system/action/del');
	}
	function delDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = implode(',',json_decode($_POST['id']));
			// 实例化
			if(SysMenuAction::del('id IN ('.$id.')')===true){
				return json_encode(['state'=>'y','url'=>'SysMenusAction','msg'=>'删除成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'删除失败！']);
			}		
		}
	}
}