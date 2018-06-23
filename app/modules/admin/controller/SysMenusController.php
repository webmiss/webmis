<?php

namespace app\modules\admin\controller;

use app\library\Page;
use app\modules\admin\model\SysMenu;
use app\modules\admin\model\SysMenuAction;

class SysMenusController extends ControllerBase{
	// 首页
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
			'model'=>'SysMenu',
			'where'=>$where,
			'getUrl'=>$getUrl
		]));
		
		// 获取菜单
		self::setVar('Menus',self::getMenus());

		// 传递参数
		self::setVar('LoadJS', ['system/sys_menus.js']);
		return self::setTemplate('main','system/menus/index');
	}

	/* 搜索 */
	function searchAction(){
		return self::view('system/menus/sea');
	}

	/* 添加 */
	function addAction(){
		// 所有权限
		self::setVar('perm',SysMenuAction::find(['field'=>'name,perm']));
		return self::view('system/menus/add');
	}
	function addDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'fid'=>trim($_POST['fid']),
				'title'=>trim($_POST['title']),
				'url'=>trim($_POST['url']),
				'perm'=>trim($_POST['perm']),
				'ico'=>trim($_POST['ico']),
				'sort'=>trim($_POST['sort']),
				'remark'=>trim($_POST['remark']),
			];
			// 返回信息
			if(SysMenu::add($data)){
				return json_encode(['state'=>'y','url'=>'SysMenus','msg'=>'添加成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'添加失败！']);
			}
		}
	}

	/* 编辑 */
	function editAction(){
		// 所有权限
		self::setVar('perm',SysMenuAction::find(['field'=>'name,perm']));
		// 视图
		self::setVar('edit',SysMenu::findfirst(['where'=>'id='.$_POST['id']]));
		return self::view('system/menus/edit');
	}
	function editDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'fid'=>trim($_POST['fid']),
				'title'=>trim($_POST['title']),
				'url'=>trim($_POST['url']),
				'perm'=>trim($_POST['perm']),
				'ico'=>trim($_POST['ico']),
				'sort'=>trim($_POST['sort']),
				'remark'=>trim($_POST['remark']),
			];
			// 返回信息
			if(SysMenu::update($data,'id='.$_POST['id'])){
				return json_encode(['state'=>'y','url'=>'SysMenus','msg'=>'编辑成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'编辑失败！']);
			}
		}
	}

	/* 删除 */
	function delAction(){
		return self::view('system/menus/del');
	}
	function delDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = implode(',',json_decode($_POST['id']));
			// 实例化
			if(SysMenu::del('id IN ('.$id.')')===true){
				return json_encode(['state'=>'y','url'=>'SysMenus','msg'=>'删除成功！']);
			}else{
				return json_encode(['state'=>'n','msg'=>'删除失败！']);
			}		}
	}

	/* 联动菜单数据 */
	function getMenuAction(){
		// 实例化
		$menus = SysMenu::find(['where'=>'fid='. $_POST['fid'],'field'=>'id,title']);
		$data = [];
		foreach($menus as $val){
			$data[] = [$val->id,$val->title];
		}
		// 返回数据
		return json_encode($data);
	}

}