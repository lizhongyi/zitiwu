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
					   $category=array('id'=>$v['id'],'title'=>$v['title'],'biaozhi'=>$v['biaozhi'],'pid'=>$v['perent_id']);
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
         
		 if($this->cate['pid'] != 0){ 
		 
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
		 
        $status && $condition['a.status'] = array('eq', $status);

        $istop &&  $condition['a.istop'] = array('eq', $istop);

        $createTime1 && $condition['a.create_time'] = array('between', $setTime);

        $viewCount1 && $condition['a.view_count'] = array('between', $setViewCount);

        $count = $this->dao->where($condition)->count();

        $listRows = empty($pageSize) || $pageSize > 100 ? 15 : $pageSize ;

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
		$fs_id = intval($_GET['fs_id']);
        $detail = M('Download')->where("id=$id or fs_id=$fs_id")->find();
		
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
		
		

}