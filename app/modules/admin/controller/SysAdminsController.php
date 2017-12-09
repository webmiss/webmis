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
		$this->setVar('Menus',$this->getMenus());

		// 传递参数
		$this->setVar('LoadJS', array('system/sys_admin.js'));
		$this->setTemplate('main','system/admin/index');
	}

	/* 搜索 */
	function searchAction(){
		$this->view('system/admin/sea');
	}

	/* 添加 */
	function addAction(){
		$this->view('system/admin/add');
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
			if($res!==true){echo json_encode(array('state'=>'n','msg'=>$res));return false;}
			$res = Safety::isRight('passwd',$_POST['passwd']);
			if($res!==true){echo json_encode(array('state'=>'n','msg'=>$res));return false;}
			$res = Safety::isRight('email',$data['email']);
			if($res!==true){echo json_encode(array('state'=>'n','msg'=>$res));return false;}
			$res = Safety::isRight('tel',$data['tel']);
			if($res!==true){echo json_encode(array('state'=>'n','msg'=>$res));return false;}
			// 是否存在用户
			$isNull =SysAdmin::findfirst([
				'where'=>'uname="'.$data['uname'].'" OR tel="'.$data['tel'].'" OR email="'.$data['email'].'"',
				'field'=>'id'
			]);
			if($isNull){
				echo json_encode(array('state'=>'n','msg'=>'该用户已经存在！'));
				return false;
			}
			// 返回信息
			if(SysAdmin::add($data)){
				echo json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'添加成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'添加失败！'));
			}
		}
	}

	/* 编辑 */
	function editAction(){
		// 视图
		$this->setVar('edit',SysAdmin::findfirst(['where'=>'id='.$_POST['id']]));
		$this->view('system/admin/edit');
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
				if($res!==true){echo json_encode(array('state'=>'n','msg'=>$res));return false;}
				// 原密码判断
				$isNull =SysAdmin::findfirst([
					'where'=>'id="'.$_POST['id'].'" AND password="'.md5($_POST['passwd1']).'"',
					'field'=>'id'
				]);
				if($isNull){
					$data['password'] = md5($_POST['passwd']);
				}else{
					echo json_encode(array('state'=>'n','msg'=>'原密码错误！'));
					return false;
				}
			}
			// 返回信息
			if(SysAdmin::update($data,'id='.$_POST['id'])){
				echo json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'编辑成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'编辑失败！'));
			}
		}
	}

	/* 删除 */
	function delAction(){
		$this->view('system/admin/del');
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
			// 返回信息
			if(SysAdmin::del($data)===true){
				echo json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'删除成功！'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'删除失败！'));
			}		
		}
	}

	/* 审核 */
	function auditAction(){
		$this->view('system/admin/audit');
	}
	function auditDataAction(){
		// 是否有数据提交
		if($_POST){
			// 获取ID
			$id = $_POST['id'];
			$arr = json_decode($id);
			foreach ($arr as $val){
				if(!SysAdmin::update(array('state'=>$_POST['state']),'id='.$val)){
					echo json_encode(array('state'=>'n','msg'=>'审核失败！'));
					return false;
				}
			}
			echo json_encode(array('state'=>'y','url'=>'SysAdmins','msg'=>'审核成功！'));
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
			echo $data?json_encode(['state'=>'y']):json_encode(['state'=>'n']);
		}
	}

	/* 权限 */
	function permAction(){
		// 权限数组
		$permArr = $this->splitPerm($_POST['perm']);
		// 所有动作
		$actionM = SysMenuAction::find(['field'=>'name,perm']);

		// HTML
		$html = '';
		// 一级菜单
		$menu1 = SysMenu::find(['where'=>'fid=0','field'=>'id,title']);
		foreach($menu1 as $m1){
			$ck = isset($permArr[$m1->id])?'checked':'';
			$html .= '<div id="oneMenuPerm" class="perm">'."\n";
			$html .= '	<span class="text1"><input type="checkbox" value="'.$m1->id.'" '.@$ck.' /></span>'."\n";
			$html .= '	<span>[<a href="#">-</a>] '.$m1->title.'</span>'."\n";
			$html .= '</div>'."\n";
			// 二级菜单
			$menu2 = SysMenu::find(['where'=>'fid='.$m1->id,'field'=>'id,title']);
			foreach($menu2 as $m2){
				$ck = isset($permArr[$m2->id])?'checked':'';
				$html .= '<div id="twoMenuPerm" class="perm">'."\n";
				$html .= '	<span class="text2"><input type="checkbox" value="'.$m2->id.'" '.@$ck.' /></span>'."\n";
				$html .= '	<span>[<a href="#">-</a>] '.$m2->title.'</span>'."\n";
				$html .= '</div>';
				// 二级菜单
				$menu3 = SysMenu::find(['where'=>'fid='.$m2->id,'field'=>'id,title,perm']);
				foreach($menu3 as $m3){
					$ck = isset($permArr[$m3->id])?'checked':'';
					$html .= '<div id="threeMenuPerm" class="perm perm_action">'."\n";
					$html .= '	<span class="text3"><input type="checkbox" name="threeMenuPerm" value="'.$m3->id.'" '.@$ck.' /></span>'."\n";
					$html .= '	<span>[<a href="#">-</a>] '.$m3->title.'</span>'."\n";
					$html .= '	<span id="actionPerm_'.$m3->id.'"> ( ';
					// 动作菜单
					foreach($actionM as $val){
						if(intval($m3->perm) & intval($val->perm)){
							$ck = @$permArr[$m3->id]&intval($val->perm)?'checked':'';
							$html .= '<span><input type="checkbox" value="'.$val->perm.'" '.@$ck.' /></span><span class="text">'.$val->name.'</span>';
						}
					}
					$html .= ')</span>';
					$html .= '</div>';
				}
			}
		}

		// 视图
		$this->setVar('permHtml', $html);
		$this->view('system/admin/perm');
	}
	/* 拆分权限 */
	private function splitPerm($perm){
		if($perm){
			$arr = explode(' ', $perm);
			foreach($arr as $val) {
				$num = explode(':', $val);
				$permArr[$num[0]]= $num[1];
			}
			return $permArr;
		}else{return FALSE;}
	}
	function permDataAction(){
		// 是否有数据提交
		if($_POST){
			// 采集数据
			$data['perm'] = trim($_POST['perm']);
			// 返回信息
			if(SysAdmin::update($data,'id='.$_POST['id'])){
				echo json_encode(array('state'=>'y','url'=>'SysAdmins'));
			}else{
				echo json_encode(array('state'=>'n','msg'=>'权限编辑失败！'));
			}
		}
	}
}