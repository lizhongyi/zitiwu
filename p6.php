<?php
  header('Content-type:text/html;charset=utf-8');
  $timeout=600; 

  //$url="http://www.webshu.net/Soft/font/List_2.html";
 
// $content=curl($url);




           $counts=76;
		   
           $page="";
           $Page_size=1;
           $Page_count = ceil($counts/$Page_size); 
           $init=1; 
           $page_len=12; 
           $ps=$Page_size;
           if(empty($_GET['p'])||$_GET['p']<0){ 
              $page=1; 
              }else { 
              $page=$_GET['p']; 
              } 
              $offset=$Page_size*($page-1);
 
            
			
				  
			  $ws= $counts-$ps*($page-1);
			  if($ws<$ps) $ps=$ws;
			   for($i=0;$i<$ps;$i++){
				   
				   $im1[$offset+$i]="http://www.webshu.net/Soft/font/List_".($offset+$i+1).".html";
				   
				 }
			 foreach($im1 as $k=>$v){
				   
			       downImg($v);
				 
				 }
			//  print_r($im1);
			// echo pageBar($counts,$Page_size,$page_len,1);
			 
			 

 function curl($url){
			 
			     $timeout=600; 
	             $ch = curl_init();
                 $timeout = 1;
                 curl_setopt ($ch, CURLOPT_URL,$url);
                 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				 //curl_setopt($ch, CURLOPT_HEADER, 1); 
				
				 $info = curl_exec($ch);

				 
                 curl_close($ch);
                
			   return $info;
			 }
			 
			 
	 
	 
	 
	 function pageBar($counts,$Page_size='',$page_len='',$lang=''){
		      
			 if(empty($_GET['p'])||$_GET['p']<0){ 
              $page=1; 
              }else { 
              $page=$_GET['p']; 
              } 
			 $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?");
         $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params['p']);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
			 
			 
			 if($lang==0){
				$prvestr='prve';
				$nextstr='next';
				$last='last';
				$first='first';
				}else{
     			$prvestr='上页';
				$nextstr='下页';
				$last='末页';
				$first='首页';
			 
			}
			 
			   
		   $Page_count = ceil($counts/$Page_size); 
           $init=1; 
           $page_len=12; 
           $max_p=$Page_count; 
           
		     $pagestr="";
			 //分页代码
			 if($max_p<$page_len ) $page_len=$max_p;
			  $pi=1;
			  if($page>=$page_len) {
				  $pi=$page-6;
				  if($pi < 1){
					  $pi=1;
					  }
				  if($page<$max_p-6){
					
				    $page_len=$page+6;
				     echo $Page_count;
				 // echo $page_len."asdasdasdasdasd";
				  
				  }else{
					  $page_len=$max_p;
					  }
				  };
			  if($page>1)  $pagestr.='<a href="'.$url.'&p='.($page-1).'">'.$prvestr.'</a>';
			   for($i=$pi;$i<=$page_len;$i++){
				 if($page==$i){
					 $pagestr.='<span class="selected">'.$i.'</span>';
				 }else{
				  $pagestr.='<a href="'.$url.'&p='.$i.'">'.$i.'</a>';
				 }
				 }
			   if($page<$max_p)  $pagestr.='<a href="'.$url.'&p='.($page+1).'">'.$nextstr.'</a>';
		      
			  return $pagestr;
		 }	 


function downImg($url){
	     $timeout=600;
	     $ziku=array();
		 $filestr=curl($url);
		// echo $filestr;
		  
		  $filestr=iconv("gb2312","UTF-8//IGNORE",$filestr);
		  $weizhi="/(?<=<td vAlign=top bgColor=#f2fbea colSpan=2 height=50>)(.*?)(?=<td align=left colSpan=2>)/is";//断言位置
		 $img="/<img\sclass=\'pic2\'\ssrc=\'([^\']+)\'[^>]+>/isU";
		 //$title="/(?<=title=\"下载名称：)(\w+)/is";
		 $title="/<a\sclass=\"\"(.*)>([^<img>].*)<\/a>/isU";
		 //$a="/<a>/isU";
		  $ur=preg_match_all($weizhi,$filestr,$match);
	      $filestr=$match[1][0];
		  $ut=preg_match_all($title,$filestr,$match);
		  $tt=$match[2]; 
		 // print_r($tt);
		  $ui=preg_match_all($img,$filestr,$match);
		  $im=($match[1]); 
		 // print_r($im);
		 foreach($im as $k=>$v){
			 
			
		  $filestr=curl("http://www.webshu.net/".$v);
		  $dir='./fontImg/';
		 // createFolder($dir);
		  $attach_ext = "jpg";  
          $filename=$k+(rand(0,100000000)).".".$attach_ext;
		  $fs=file_put_contents($dir.$filename,$filestr);
          //写入数据库、
		  if(!$fs){
			  // echo  "error";
			  }
		  $addUrl="http://www.zitiwu.com/Download/zhuatu/title/".$tt[$k]."/url/".base64_encode($filename)."";
		  $rs=curl($addUrl);
		 
		  if($rs){
			 // echo "succ".$rs;
			  }else{
			 // echo "erro".$rs;	  
				  }
		  
		  }
	}
	

 function createFolder($path)
 {
  if (!file_exists($path))
  {
   createFolder(dirname($path));
   mkdir($path, 0777);
  }
 }
 $shu=intval($_GET['p'])+1;
 if($_GET['p']<76){
  
  echo $shu;
 
 }
?>


