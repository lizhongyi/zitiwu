<?php

 header('Content-type:text/html;charset=utf-8');
        $new=curl("http://www.3lian.com/e/DownSys/doaction.php?enews=DownSoft&classid=192&id=45886&pathid=0&pass=1368ac3d336b257900dbbcab4ada1647&p=:::");
		$reg1="/(.*)HREF=\"(.*)\">/isU"; 
		
		$str=str_replace('\"','"',$new);
		preg_match_all($reg1,$str,$match);
		xia($match[2][0]);
		

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
		 $filestr=curl($url);
		 
		  $dir='./test/';
          $attach_ext = strtolower(substr(strrchr($url,'.'),1));  
          $filename= $dir.md5(rand(0,100000000)).".".$attach_ext;
		   file_put_contents($filename,$filestr);
           
	      echo $url;
		 
	}
	
	function xia($url){
	      
		 $attach_ext="rar";
		 $filestr=curl($url);
		 $filename= $dir.md5(rand(0,100000000)).".".$attach_ext;
		 file_put_contents('./test/'.$filename,$filestr);
		 echo $filename;
		 
	}




   function curl2($url){
	   
	 $timeout=600;       
$matches = parse_url($url);

$host = $matches['host'];

$path = $matches['path'] ? $matches['path'].(isset($matches['query']) ? '?'.$matches['query'] : '') : '/';

$port = !empty($matches['port']) ? $matches['port'] : 80;



$out = "GET $path HTTP/1.0\r\n";

$out .= "Host: $host\r\n";

$out .= "\r\n\r\n";





$fp = @fsockopen($host, $port, $errno, $errstr, 10);





	



stream_set_blocking($fp, TRUE);

stream_set_timeout($fp, $timeout);

@fwrite($fp, $out);

$status = stream_get_meta_data($fp);

while (!feof($fp)) {

 if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {

  break;

 }

}

$return = '';



while(!feof($fp)) {

 $data = fread($fp, 8192);

 $return .= $data;

}



$attach_ext = strtolower(substr(strrchr($url,'.'),1));  

$filename="./test/".md5(rand(100,10000)).".rar";

$fp=fopen($filename,"w");

flock($fp,2); 

fwrite($fp, $return); 



@fclose($fp);

	      
	   
	   }










?>