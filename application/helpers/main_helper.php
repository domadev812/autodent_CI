<?php

if ( ! function_exists('get_title')){
	function get_title($divider = '', $reverse = false){
		$CI =& get_instance();
		$divider = strlen($divider) ? trim($divider) : '-';
		$arr = array($CI->meta_title, $CI->site_name);
		return !strlen($CI->meta_title) ? $CI->site_name : implode(" $divider ", 
			!$reverse ? $arr : array_reverse($arr)
		);
	}
}


if ( ! function_exists('get_css_version')){
	function get_css_version($filename){
		return filemtime(FCPATH.'/assets/css/'.$filename.'.css');
	}
}


if ( ! function_exists('set_input')){
	function set_input($attr = []){
		if(empty($attr['type'])) $attr['type'] = 'text';
		array_walk($attr, function(&$val, $key){$val = $key.'="'.$val.'"';});
		echo '<input '.implode(' ', $attr).' />';
	}
}


if ( ! function_exists('get_time_interval')){
	function get_time_interval($time){		
		$interval = time() - $time;
		$interval = $interval<600 ? floor($interval/60)." minutes ago" : ( date('Y-m-d',$time) == date('Y-m-d') ? date('h:i A',$time) : date('l, j M, Y', $time) );	
		return $interval;
	}
}


if ( ! function_exists('url_to_link')){
	function url_to_link($content){
		return preg_replace_callback('~((http|https)://[^\s]+)~i',function($m){
			return '<a target="_blank" href="'.$m[1].'">'.(strlen($m[1])>30 ? substr($m[1],0,30).'...' : $m[1]) .'</a>';
		},$content);
	}
}


