<?php

namespace app\modules\admin\controller;

use app\library\Page;
use app\library\Safety;
use app\modules\admin\model\SysAdmin;
use app\modules\admin\model\SysMenu;
use app\modules\admin\model\SysMenuAction;

class SysAdminsController extends ControllerBase{
	/* 首页 */
	function indexAction(){
		// 分页
		if(isset($_GET['search'])){
			$like = Page::where();
			self::setVar('getUrl', $like['search']);
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
		self::setVar('List',Page::get([
			'model'=>'SysAdmin',
			'where'=>$where,
			'getUrl'=>$getUrl,
			'order'=>'id desc'
		]));

		// 获取菜单
		self::setVar('Menus',$this->getMenus());

		// 传递参数
		self::setVar('LoadJS', array('system/sys_admin.js'));
		return $this->setTemplate('main','system/admin/index');
	}

	/* 搜索 */
	function searchAction(){
		return $this->view('system/admin/sea');
	}

	/* 添加 */
	function addAction(){
		return $this->view('system/admin/add');
	}
	function addDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'uname'=>trim($_POST['uname']),
				'password'=>md5($_POST['passwd']),
				'email'=>trim($_POST['email']),
				'tel'=>trim($_POST['tel']),
				'name'=>trim($_POST['name']),
				'department'=>trim($_POST['department']),
				'position'=>trim($_POST['position']),
				'rtime'=>date('Y-m-d H:i:s'),
			];
			// 验证
			$res = Safety::isRight('uname',$data['uname']);
			if($res!==true){return json_encode(array('state'=>'n','msg'=>$res));}
			$res = Safety::isRight('passwd',$_POST['passwd']);
			if($res!==true){return json_encode(array('state'=>'n','msg'=>$res));}
			$res = Safety::isRight('email',$data['email']);
			if($res!==true){return json_encode(array('state'=>'n','msg'=>$res));}
			$res = Safety::isRight('tel',$data['tel']);
			if($res!==true){return json_encode(array('state'=>'n','msg'=>$res));}
			// 是否存在用户
			$isNull =SysAdmin::findfirst([
				'where'=>'uname="'.$data['uname'].'" OR tel="'.$data['tel'].'" OR email="'.$data['email'].'"',
				'field'=>'id'
			]);
			if($isNull){
				return json_encode(array('state'=>'n','msg'=>'该用户已经存在！'));
			}
			// 返回信息
			if(SysAdmin::add($data)){
				return json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'添加成功！'));
			}else{
				return json_encode(array('state'=>'n','msg'=>'添加失败！'));
			}
		}
	}

	/* 编辑 */
	function editAction(){
		// 视图
		self::setVar('edit',SysAdmin::findfirst(['where'=>'id='.$_POST['id']]));
		return $this->view('system/admin/edit');
	}
	function editDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data = [
				'name'=>trim($_POST['name']),
				'department'=>trim($_POST['department']),
				'position'=>trim($_POST['position']),
			];
			// 是否修改密码
			if(!empty($_POST['passwd'])){
				$res = Safety::isRight('passwd',$_POST['passwd']);
				if($res!==true){return json_encode(array('state'=>'n','msg'=>$res));}
				// 原密码判断
				$isNull =SysAdmin::findfirst([
					'where'=>'id="'.$_POST['id'].'" AND password="'.md5($_POST['passwd1']).'"',
					'field'=>'id'
				]);
				if($isNull){
					$data['password'] = md5($_POST['passwd']);
				}else{
					return json_encode(array('state'=>'n','msg'=>'原密码错误！'));
				}
			}
			// 返回信息
			if(SysAdmin::update($data,'id='.$_POST['id'])){
				return json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'编辑成功！'));
			}else{
				return json_encode(array('state'=>'n','msg'=>'编辑失败！'));
			}
		}
	}

	/* 删除 */
	function delAction(){
		return $this->view('system/admin/del');
	}
	function delDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = implode(',',json_decode($_POST['id']));
			// 返回信息
			if(SysAdmin::del('id IN ('.$id.')')===true){
				return json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'删除成功！'));
			}else{
				return json_encode(array('state'=>'n','msg'=>'删除失败！'));
			}		
		}
	}

	/* 审核 */
	function auditAction(){
		return $this->view('system/admin/audit');
	}
	function auditDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = implode(',',json_decode($_POST['id']));
			if(SysAdmin::update(['state'=>$_POST['state']],'id IN ('.$id.')')){
				return json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'审核成功！'));
			}else{
				return json_encode(array('state'=>'n','msg'=>'审核失败！'));
			}
		}
	}

	/* 是否存在 */
	function isUnameAction(){
		// 是否提交
		if(!isset($_POST['name']) || !isset($_POST['val'])){return false;}
		// 条件
		$where = '';
		if($_POST['name']=='uname'){
			$where = 'uname="'.trim($_POST['val']).'"';
		}elseif($_POST['name']=='tel'){
			$where = 'tel="'.trim($_POST['val']).'"';
		}elseif($_POST['name']=='email'){
			$where = 'email="'.trim($_POST['val']).'"';
		}
		// 查询
		if($where){
			$data = SysAdmin::findfirst(['where'=>$where,'field'=>'id']);
			return $data?json_encode(['state'=>'y']):json_encode(['state'=>'n']);
		}
	}

	/* 权限 */
	function permAction(){
		// 拆分权限
		$permArr=[];
		$arr = explode(' ',$_POST['perm']);
		foreach($arr as $val){
			$a=explode(':',$val);
			$permArr[$a[0]]=$a[1];
		}
		self::setVar('permArr',$permArr);
		self::setVar('Perm',SysMenuAction::find(['field'=>'name,perm']));
		self::setVar('Menus',$this->Menus());
		return $this->view('system/admin/perm');
	}
	function permDataAction(){
		// 是否有数据提交
		if($_POST){
			// 返回信息
			if(SysAdmin::update(['perm'=>trim($_POST['perm'])],'id='.$_POST['id'])){
				return json_encode(array('state'=>'y','url'=>'SysAdmins'));
			}else{
				return json_encode(array('state'=>'n','msg'=>'权限编辑失败！'));
			}
		}
	}
	// 递归全部菜单
	private function Menus($fid='0'){
		$data=[];
		$M = SysMenu::find(['where'=>'fid='.$fid,'field'=>'id,title,perm']);
		foreach($M as $val){
			$val->menus = $this->Menus($val->id);
			$data[] = $val;
		}
		return $data;
	}

}