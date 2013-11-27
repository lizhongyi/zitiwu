<?php
 session_start();
 
 header('Content-type:text/html;charset=utf-8');
  if($_SESSION['im']){
 $im=$_SESSION['im'];
  }
 if(!$im){
 $content=curl('http://ziti.jz123.cn/class/yingwenziti/jingzhizitiku/huoshuiziti/');
 $pattern="/<img(.*)src=\"upload_img\/font\/([^\"]+)\"[^>]+>/isU"; 
 $weizhi="/(?<=<div\sclass=\"f-list\">)(.*?)(?=<div\sclass=\"r)/is";
 $str=$content; 
 $str=str_replace('\"','"',$content);
 preg_match_all($pattern,$str,$match); 
 $im=$match[2];
 $_SESSION['im']=$im;
 }




           $counts=count($im);
		   
           $page="";
           $Page_size=10;
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
				   
				   $im1[$offset+$i]=$im[$offset+$i];
				   
				 }
			 foreach($im1 as $k=>$v){
				   
				   downImg($v);
				 
				 }
			  print_r($im1);
			 echo pageBar($counts,$Page_size,$page_len,1);
			 
			 

 function curl($url){
			 
			     
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
			 
			if(empty($_GET['p'])||$_GET['p']<0){ 
              $page=1; 
              }else { 
              $page=$_GET['p']; 
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
			  if($page>1)  $pagestr.='<a href="/pi.php?p='.($page-1).'">'.$prvestr.'</a>';
			   for($i=$pi;$i<=$page_len;$i++){
				 if($page==$i){
					 $pagestr.='<span class="selected">'.$i.'</span>';
				 }else{
				  $pagestr.='<a href="/pi.php?p='.$i.'">'.$i.'</a>';
				 }
				 }
			   if($page<$max_p)  $pagestr.='<a href="/pi.php?p='.($page+1).'">'.$nextstr.'</a>';
		      
			  return $pagestr;
		 }	 


function downImg($url){
	     $timeout=600;
	     $doman='http://www.zitiwu.com';
		 $url=$doman.$url;
		 $filestr=curl($url);
		 $img="/<img(.*)src=\"([^\"]+)\"[^>]+>/isU";
		 $ur=preg_match_all($img,$filestr,$match);
		 $ur=$match[2][0];
		 $filestr=curl($ur);
		  $dir='./test/';
          $attach_ext = strtolower(substr(strrchr($url,'.'),1));  
          $filename= $dir.md5(rand(0,100000000)).".".$attach_ext;
		   file_put_contents($filename,$filestr);
           
	      echo $filename;
		 
	}
	
	





?>