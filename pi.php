<?php
 
 header('Content-type:text/html;charset=utf-8');
 session_start();
  
 $im=$_SESSION['ima'];
 if(!$im){
 $content=curl('http://www.zitiwu.com');
 $pattern="/<img(.*)src=\"([^\"]+)\"[^>]+>/isU"; 
 $str=$content; 
 $str=str_replace('\"','"',$content);
 preg_match_all($pattern,$str,$match); 
 $imgurl=($match[2]);
 $_SESSION['ima']=$imgurl;
 }
 



           $counts=count($im);
		   
           $page="";
           $Page_size=2;
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
			  print_r($im1);
			  
			 echo pageBar($counts,$Page_size,$page_len,1);
			 
			 

 function curl($url){
			 
			     if(function_exists('curl_init')) {
    
	             $ch = curl_init();
                 $timeout = 1;
                 curl_setopt ($ch, CURLOPT_URL,$url);
                 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                 $info = curl_exec($ch);
                 curl_close($ch);
                 }else{
                  $info= file_get_contents($url);	
	            }
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

?>