<?php

namespace framework;

class Controller{
	//模板变量
	private static $var = [];
	private static $getContent = '';

	/* 获取网址 */
	function getUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].'/'.MODULE.'/'.$url;
		return $base_url;
	}

	/* 跳转页面 */
	function redirect($url=''){
		header("Location: ".$this->getUrl($url));
	}

	/* 设置参数 */
	function setVar($name,$value=''){
		self::$var[$name] = $value;
	}

	/* 获取参数 */
	function getVar($name){
		return self::$var[$name];
	}

	/* 加载视图 */
	protected function view($file=''){
		$file = APP.'modules/'.MODULE.'/view/'.$file.'.php';
		if(!is_file($file)){die('该视图不存在！');}
		// 参数
		foreach(self::$var as $key=>$val){$$key = $val;}
		// 加载视图
		return require_once $file;
	}

	/* 加载模板视图 */
	function setTemplate($template='',$file=''){
		// 模板文件
		$template = APP.'modules/'.MODULE.'/view/layouts/'.$template.'.php';
		// 视图文件
		$file = $file?$file:strtolower(CONTROLLER).'/'.ACTION;
		$file = APP.'modules/'.MODULE.'/view/'.$file.'.php';
		// 视图是否存在
		if(!is_file($file)){die('该模板视图不存在！');}
		// 参数
		foreach(self::$var as $key=>$val){$$key = $val;}
		// 加载视图
		self::$getContent = $file;
		return require_once $template;
	}

	/* 分页 */
	function page($config = array()){
		// 必须参数
		if(!isset($config['model'])){die('请传入模型');}
		// 命名空间
		$namespace = isset($config['namespace'])?$config['namespace']:'app\\modules\\'.MODULE.'\\model\\';
		$config['model'] = $namespace.$config['model'];
		// 默认值
		$field = isset($config['field'])?$config['field']:'*';
		$where = isset($config['where'])?$config['where']:'';
		$order = isset($config['order'])?$config['order']:'';
		$limit = isset($config['limit'])?$config['limit']:15;
		$getUrl = isset($config['getUrl'])?$config['getUrl']:'';
		// Page
		$rows = $config['model']::getNumRows($where);
		$page = empty($_GET['page'])?1:$_GET['page'];
		// 计算页数
		$page_count = ceil($rows/$limit);
		if($page >= $page_count){
			$page = $page_count;
		}
		// 数据
		$start=$limit*($page-1);
		$data = $config['model']::find(['where'=>$where,'field'=>$field,'order'=>$order,'limit'=>$start.','.$limit]);

		// 分页菜单
		$html = '';
		if($page==1 || $page==0){
			$html .= '<span>首页</span>';
			$html .= '<span>上一页</span>';
		}else{
			$html .= '<a href="'.$this->getUrl(CONTROLLER.'&page=1'.$getUrl).'">首页</a>';
			$html .= '<a href="'.$this->getUrl(CONTROLLER.'&page='.($page-1).$getUrl).'">上一页</a>';
		}
		if($page==$page_count){
			$html .= '<span>下一页</span>';
			$html .= '<span>末页</span>';
		}else{
			$html .= '<a href="'.$this->getUrl(CONTROLLER.'&page='.($page+1).$getUrl).'">下一页</a>';
			$html .= '<a href="'.$this->getUrl(CONTROLLER.'&page='.$page_count.$getUrl).'">末页</a>';
		}
		$html .= '第'.$page.'/'.$page_count.'页, 共'.$rows.'条';

		// 结果
		return array('data'=>$data,'page'=>$html);
	}
	// 分页条件
	function pageWhere(){
		$getUrl = '';
		$like = $_GET;
		$page = isset($like['page'])?$like['page']:1;
		unset($like['page']);
		// 条件字符串
		foreach($like as $key=>$val){
			if($val==''){
				unset($like[$key]);
			}else{
				$getUrl .= '&'.$key.'='.$val;
			}
		}
		unset($like['search']);
		// 传递搜索条件
		$this->setVar('getUrl','?search&page='.$page.$getUrl);
		// 返回数据
		return array('getUrl'=>$getUrl,'data'=>$like);
	}

}