<?php

/**

 * 

 * 下载

 *

 * @package      	YIGECMS_CORP

 *

 * @license         http://www.YIGECMS.cn/license.txt

 * @version        	$Id: ProductAction.class.php v1.0 2012-01-01 06:59:03 

 */



class DownloadAction extends GlobalAction

{

    public $dao;

    function _initialize()

    {

        parent::_initialize();

        $this->dao = M('Download');

        $data_cate= getCategory($this->globalCategory, 14,0);
        $this->data_cate=$data_cate;
		
		$category = $_GET['cate'];
		
		foreach($data_cate as $k=>$v){
			     if($v['biaozhi']==$category){
					   $category=array('id'=>$v['id'],'title'=>$v['title'],'biaozhi'=>$v['biaozhi'],'pid'=>$v['parent_id']);
					 }
			 }
		 $this->cate=$category;
		
		// print_r($category);
		$this->assign('cateArr',$data_cate);
		$this->assign('cate',$category);
        $this->assign('moduleTitle', '字体下载');

        $this->assign($data);

    }

    

    /**

     * 列表

     *

     */

    public function index()

    {
         
        
        
        $condition = array();

        $title = formatQuery($_GET['title']);

        $orderBy = trim($_GET['orderBy']);

        $orderType = trim($_GET['orderType']);

        $recommend = intval($_GET['recommend']);
		
		
		//检测室不是父亲ID
          
		 
          $categoryId = $this->cate['id'];
		 

        $status =  intval($_GET['status']);

        $istop = intval($_GET['istop']);

        $createTime = trim($_GET['createTime']);

        $createTime1 = trim($_GET['createTime1']);

        $viewCount = intval($_GET['viewCount']);

        $viewCount1 = intval($_GET['viewCount1']);

        $setOrder = setOrder(array(array('viewCount', 'a.view_count'),'a.id'), $orderBy, $orderType, 'a');

        $setTime = setTime($createTime, $createTime1);

        $setViewCount = setViewCount($viewCount, $viewCount1);

        $pageSize = intval($_GET['pageSize']);

        $title &&  $condition['a.title'] = array('like', '%'.$title.'%');

        $recommend &&  $condition['a.recommend'] = array('eq', $recommend);
        
		 if($this->cate['pid'] != 14){ 
		 
        $categoryId &&  $condition['a.category_id'] = array('eq', $categoryId);
		
		 }else{
			  
			   foreach($this->data_cate  as $k=>$v){
				      
					  if($v['parent_id']==$this->cate['id']){
						   
						   $nk[]=$v['id'];
						   
						  }
				   
				   }
			   $nk=implode(',',$nk);
			   
			    $categoryId &&  $condition['a.category_id'] = array('in', ($nk));
			 }
		// echo $this->cate['pid'];
       
     

        $count = $this->dao->Table(C('DB_PREFIX').'download a')->where($condition)->count();
		
     
       $listRows = empty($listRows) ? 40 : $listRows;

        $p = new page($count, $listRows);

        $dataList = $this->dao->Table(C('DB_PREFIX').'download a')->Join(C('DB_PREFIX').'category b on a.category_id=b.id')->Field('a.*,b.title as category')->Order($setOrder)->Where($condition)->Limit($p->firstRow.','.$p->listRows)->select();

        $page = $p->show();

        if($dataList !== false)

        {

            $this->assign('page', $page);

            $this->assign('dataList', $dataList);

        }

       

        $this->display();

    }

    

    /**

     * 内容

     *

     */

    public function detail(){

        $id = intval($_GET['id']);
		$fs_id = $_GET['fs_id'];
        $detail = M('Download')->where("id=$id or fs_id=$fs_id")->find();
		   if (empty($detail)) parent::_message('error', '记录不存在');
        $this->assign('detail',$detail);
		$this->display();
    }
	
	
	public function addr(){
		
		    $id=$_POST['id'];
			if(!$id) exit();
			
			 echo "/Download/down/id/$id";
		   
		}
		
	public function down(){
		
	 $id=intval($_GET['id']);
	 if(!$id){
		  
		  exit('非法操作');
		 
		 }
		 
  require_once './libs/BaiduPCS.class.php';
 $access_token = 	C('MY_TOKEN');

//文件路径
$path = M('Download')->where('id='.$id)->getField('download_url');
$fileName=explode('/',$path);
$fileName=$fileName[4];
$pcs = new BaiduPCS($access_token);

header('Content-Disposition:attachment;filename="' . $fileName . '"');
header('Content-Type:application/octet-stream');
$result = $pcs->download($path);
echo $result;
		
		}	
		
		
		//批量导入字体库
		
		public function piliang(){
			
			    require_once './libs/BaiduPCS.class.php';
               //请根据实际情况更新$access_token与$appName参数
        $access_token = 	C('MY_TOKEN');

        $appName = 'zitiwu01';
      //应用根目录
     $root_dir = '/apps' . '/' . $appName . '/';

       //搜索关键字
      $wd = $_GET['keyword'];
//搜索的目录路径，此处为搜索应用根目录
$path = $root_dir;
//是否递归搜索
$re = 1;

$pcs = new BaiduPCS($access_token);
$result = $pcs->search($path, $wd, $re);
  
  $getList=json_decode($result);
   
   $list=(array)$getList->list;
    
	//批量写入语句
   foreach($list as $k=>$v){
	      
		  $list[$k]=(array)($list[$k]);
	   
	   }
	   
	   
	   foreach($list as $k=>$v){
		   
		     echo $v['pass'];
		   
		   }
			
			     
			}
		
		
		
		
		
		//抓图
		
		public function zhuatu(){
			  
			   $title=$_GET['title'];
			   $url=$_GET['url'];
			   $data['title']=$title;
			   $data['url']=$url;
			   $data['create_time']=time();
			   $rs=D('Zhuatu')->add($data);
			   echo $title;
			   echo  D('Zhuatu')->getLastSql();
				   
			}
		
		
		public function test(){
			
			
			$sd= M('Zhuatu')->limit('1')->select();
			
			echo base64_decode($sd[0]['url']);
			 
			
			
			}
		

}