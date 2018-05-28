<?php 
/**
 * 简单的curl
 * @param  [type]  $url    [description]
 * @param  boolean $params [description]
 * @param  integer $ispost [description]
 * @return [type]          [description]
 */
function customCurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'zjx' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost ){
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }else{
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if($response == FALSE){
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}
/**
 * ip转换成地址
 * @param  [type] $ip [description]
 * @return [type]     [description]
 */
function ip2address($ip){
	$url='http://freeapi.ipip.net/'.$ip;
	$data=customCurl($url);
	if($data){
		$arr=json_decode($data);
		return $arr[0].$arr[1].$arr[2];
	}else{
		return 0;
	}	
}
/**
 * 获取设备信息
 * @return [type] [description]
 */
function getDeviceInfo(){
	$ua=$_SERVER['HTTP_USER_AGENT'];
    $str=substr($ua,0,strpos($ua,")"));
    $str1=str_replace(' (', '_', $str);
    $str2=str_replace('; ', '_', $str1);
	return $str2;
}
/**
 * 保存文件
 * @param  [type] $name   [description]
 * @param  [type] $suffix [description]
 * @param  [type] $source [description]
 * @param  string $path   [description]
 * @return [type]         [description]
 */
function saveFile($name,$suffix,$source,$path='/'){
	$fileName=$name.'.'.$suffix;
	$file=$path.'/'.$fileName;
	$file = fopen($file,'w');
	fwrite($file,$source);
	fclose($file);
}