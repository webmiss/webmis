<?php

/**
* 分页类
*/

namespace app\library;

class Page{
	/* 分页 */
	static function get($config=[]){
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
			$html .= '<a href="'.self::getUrl(CONTROLLER.'?search&page=1'.$getUrl).'">首页</a>';
			$html .= '<a href="'.self::getUrl(CONTROLLER.'?search&page='.($page-1).$getUrl).'">上一页</a>';
		}
		if($page==$page_count){
			$html .= '<span>下一页</span>';
			$html .= '<span>末页</span>';
		}else{
			$html .= '<a href="'.self::getUrl(CONTROLLER.'?search&page='.($page+1).$getUrl).'">下一页</a>';
			$html .= '<a href="'.self::getUrl(CONTROLLER.'?search&page='.$page_count.$getUrl).'">末页</a>';
		}
		$html .= '第'.$page.'/'.$page_count.'页, 共'.$rows.'条';

		// 结果
		return array('data'=>$data,'page'=>$html);
	}

	/* 分页条件 */
	static function where(){
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
		// 返回数据
		return ['data'=>$like,'getUrl'=>$getUrl,'search'=>'?search&page='.$page.$getUrl];
	}

	// 获取网址
	static private function getUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].'/'.MODULE.'/'.$url;
		return $base_url;
	}
}