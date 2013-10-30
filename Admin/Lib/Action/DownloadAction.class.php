<?php 

/**

 * 

 * Download(下载)

 *

 * @package      	YIGECMS_Corp

 *

 * @license         http://www.YIGECMS.cn/license.txt

 * @version        	$Id: DownloadAction.class.php v1.0 2012-01-01 06:59:03 



 */



class DownloadAction extends GlobalAction

{

    protected $category, $dao;

    function _initialize()

    {

        parent::_initialize();

        $getData = getCache('Config');

        $data['runSystem'] = $getData['run_system'];

        //取所有分类，过滤出文章模块主ID

        $data_cate= getCategory($this->globalCategory, 14,0);
        $this->data_cate=$data_cate;
		
	    $this->assign('cate',$data_cate);
	   
	   

        $this->dao = D('Download');
		
		 require_once './libs/BaiduPCS.class.php';
               //请根据实际情况更新$access_token与$appName参数
         

    }



    /**

     * 列表

     *

     */

    public function index()

    {

        //parent::_checkPermission();

        $condition = array();

        $title = formatQuery($_GET['title']);

        $orderBy = trim($_GET['orderBy']);

        $orderType = trim($_GET['orderType']);

        $recommend = intval($_GET['recommend']);

        $categoryId = intval($_GET['categoryId']);

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

        $categoryId &&  $condition['a.category_id'] = array('eq', $categoryId);

        $status && $condition['a.status'] = array('eq', $status);

        $istop &&  $condition['a.istop'] = array('eq', $istop);

        $createTime1 && $condition['a.create_time'] = array('between', $setTime);

        $viewCount1 && $condition['a.view_count'] = array('between', $setViewCount);

        $count = $this->dao->Table(C('DB_PREFIX').'download a')->where($condition)->count();
       // echo $count;
        $listRows = empty($pageSize) || $pageSize > 100 ? 15 : $pageSize ;

        $p = new page($count, $listRows);

        $dataList = $this->dao->Table(C('DB_PREFIX').'download a')->Join(C('DB_PREFIX').'category b on a.category_id=b.id')->Field('a.*,b.title as category')->Order($setOrder)->Where($condition)->Limit($p->firstRow.','.$p->listRows)->select();

        $page = $p->show();

        if($dataList !== false)

        {

            $this->assign('page', $page);

            $this->assign('dataList', $dataList);

        }

        parent::_sysLog('index');

        $this->display();

    }



    /**

     * 录入

     *

     */

    public function insert()

    {

        parent::_checkPermission();

        $this->display();

    }



    /**

     * 提交录入

     *

     */

    public function doInsert()

    {

        parent::_checkPermission('Download_insert');

        parent::_setMethod('post');

        if($daoCreate = $this->dao->create())

        {

            $style = createStyle($_POST);

            $this->dao->title_style = $style['title_style'];

            $this->dao->title_style_serialize = $style['title_style_serialize'];

            $this->dao->tags = formatTags($_POST['tags']);

            $this->dao->user_id = parent::_getAdminUid();

            $this->dao->username = parent::_getAdminName();

            $uploadFile = upload($this->getActionName());

            if ($uploadFile)

            {

                $this->dao->attach = 1;

                $this->dao->attach_image = formatAttachPath($uploadFile[0]['savepath']) .splitbig($uploadFile[0]['savename']);

                $this->dao->attach_thumb = fileExit($uploadFile[0]['savepath'] . splitThumb($uploadFile[0]['savename'])) ? formatAttachPath($uploadFile[0]['savepath']) . splitThumb($uploadFile[0]['savename']) : '' ;



            }

            $daoAdd = $this->dao->add();

            if(false !== $daoAdd)

            {

                parent::_tags('insert', $_POST['tags'], $daoAdd);

                parent::_sysLog('insert', "录入:$daoAdd");

                parent::_message('success', '录入成功');

            }else

            {

                parent::_message('error', '录入失败');

            }

        }else

        {

            parent::_message('error', $this->dao->getError());

        }

    }



    /**

     * 编辑

     *

     */

    public function modify()

    {

        parent::_checkPermission();

        $item = intval($_GET["id"]);

        $record = $this->dao->Where('id='.$item)->find();
      
        if (empty($item) || empty($record)) parent::_message('error', '记录不存在');

        $this->assign('vo', $record);

        $this->display();

    }



    /**

     * 提交编辑

     *

     */

    public function doModify()

    {

        parent::_checkPermission('Download_modify');

        parent::_setMethod('post');

        $item = intval($_POST['id']);

        empty($item) && parent::_message('error', '记录不存在');

        if($doaCreate = $this->dao->create())

        {

            $style = createStyle($_POST);

            $this->dao->title_style = $style['title_style'];

            $this->dao->title_style_serialize = $style['title_style_serialize'];

            $this->dao->tags = formatTags($_POST['tags']);

            $uploadFile = upload($this->getActionName());

            if ($uploadFile)

            {

                $this->dao->attach = 1;

               $this->dao->attach_image = formatAttachPath($uploadFile[0]['savepath']) .splitbig($uploadFile[0]['savename']);

                $this->dao->attach_thumb = fileExit($uploadFile[0]['savepath'] . splitThumb($uploadFile[0]['savename'])) ? formatAttachPath($uploadFile[0]['savepath']) . splitThumb($uploadFile[0]['savename']) : '' ;



                @unlink('./'.$this->upload.$_POST['old_image']);

                @unlink('./'.$this->upload.$_POST['old_thumb']);

            }

            $daoSave = $this->dao->save();

            if(false !== $daoSave)

            {

                parent::_tags('modify', $_POST['tags'], $item);

                parent::_sysLog('modify', "编辑:$item");

                parent::_message('success', '更新完成');

            }else

            {

                parent::_message('error', '更新失败');

            }

        }else

        {

            parent::_message('error', $this->dao->getError());

        }

    }



    /**

     * 批量操作

     *

     */
	 
	 
	 
	 
	 //上传百度网盘资源
	 
	 public function up_pan(){
		 
		    
			    $access_token = 	C('MY_TOKEN');
               //应用目录名
               $appName = 'zitiwu01';
                //应用根目录
				
				//字体分类文件夹
				
				$catePath=trim($_POST['cate_path']);
                $root_dir = '/apps' . '/' . $appName . '/'.$catePath.'/';

             //上传文件的目标保存路径，此处表示保存到应用根目录下
              $targetPath = $root_dir;
             //要上传的本地文件路径
			 
			 
			 
			     import('ORG.Net.UploadFile');
                  $upload = new UploadFile();// 实例化上传类
                  $upload->maxSize  = 31045728 ;// 设置附件上传大小
                  $upload->allowExts  = array('rar', 'zip', 'tff', '7z');// 设置附件上传类型
				  //$upload->saveRule=0;
				  //$upload->saveRule=uniqid;//上传文件的文件名保存规则
                  $upload->uploadReplace=0;
                  $upload->savePath =  './fontTemp/';// 设置附件上传目录
                 if(!$upload->upload()) {// 上传错误提示错误信息
				 
				 $rr=$upload->getErrorMsg();
				  print_r($rr);
				 
                
				  
				  
				  
				  
                 }else{// 上传成功 获取上传文件信息
                 $info =  $upload->getUploadFileInfo();
                
                 }
			 
			 
			 
			 
			 
			 
			
             $file = $info[0]['savepath'].$info[0]['savename'];
             //文件名称
              $fileName = basename($file);
              //新文件名，为空表示使用原有文件名
             $newFileName = '';

             $pcs = new BaiduPCS($access_token);

             if (!file_exists($file)) {
	          			  
			   
			     $error=array('ed'=>1,'info'=>'文件不存在请检查是否正确');
				 $error=json_encode($error);
			     echo '<script>';   
			
	             echo 'parent.callback('.$error.')';
	    
		         echo '</script>';
				 echo 
				 exit();
				 
            } else {
	           $fileSize = filesize($file);
	           $handle = fopen($file, 'rb');
	          $fileContent = fread($handle, $fileSize);

	          $result = $pcs->upload($fileContent, $targetPath, $fileName, $newFileName);
	          fclose($handle);
			  
			  //删除临时文件
			  unlink($file);
			  
			  //错误类型中文数组
			  
			   $errArray=array('33061'=>'文件已存在');
			  
			  //判断错误类型
			  $json=json_decode($result);
			  print_r($json);
			  
	     echo '<script>';   
			
	     echo 'parent.callback('.$result.')';
	    
		 echo '</script>';
		 
		 echo $result;
}
	 
		 
		 
		 }
	 
	 
	 
	 

    public function doCommand()

    {

        parent::_checkPermission('Download_command');

        if(getMethod() == 'get'){

            $operate = trim($_GET['operate']);

        }elseif(getMethod() == 'post'){

            $operate = trim($_POST['operate']);

        }else{

            parent::_message('error', '只支持POST,GET数据');

        }

        $newCategory = intval($_POST['newCategory']);

        switch ($operate){

            case 'delete': parent::_delete(0, 0, array('attach_image', 'attach_thumb'));break;

            case 'recommend': parent::_recommend('set');break;

            case 'unRecommend': parent::_recommend('unset');break;

            case 'setTop': parent::_setTop('set');break;

            case 'unSetTop': parent::_setTop('unset');break;

            case 'setStatus': parent::_setStatus('set');break;

            case 'unSetStatus': parent::_setStatus('unset');break;

            case 'update': parent::_batchModify(0, $_POST, array('title'));break;

            case 'move': parent::_move($newCategory);break;

            default: parent::_message('error', '操作类型错误') ;

        }



    }
    
	
	public function sr_ku(){
		
		     $access_token = 	C('MY_TOKEN');
		      $k=$_GET['keyword'];
			  
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
  
   foreach($list as $k=>$v){
	      
		  $list[$k]=(array)($list[$k]);
	   
	   }
   //如果资源没有的花那么就搜索分类
	   
	foreach($list as $k=>$v){
	      
		  $list[$k]['title']=$this->imp($v['path']);
	   
	   }
	   
    $ed=$this->dao->where('title like "%'.$wd.'%"')->Field('fs_id')->select();
	foreach($ed as $k=>$v){
		  
		  $ed1[]=$v['fs_id'];
		} 
	 
	 //print_r($ed1);
	 //过滤掉存在的
	 
	foreach($list as $k=>$v){
		   
		   if(in_array($v['fs_id'],$ed1)){
			  unset($list[$k]);   
			 }
		
		}
	
		Session::set('listArr',$list);
   $this->assign('tiao',count($list)); 
   $this->assign('dataList',$list);

   $this->display();
		}
		
		
		
		
		
		public function check(){
			 
			  $title=$_POST['title'];
			  if(empty($title)) return false;
			  $cn=M('Download')->where('title="'.$title.'"')->count();
			  echo $cn;
			
			}
		
		
		
		
		
	

  
     public function imp($str,$n){
		 
		      if(!$str) return false;
			  $arr=explode('/',$str);
			  if(substr($title=$arr[4],-2)=='7z'){
				 $title= substr($title=$arr[4],0,-3); 
			  }else{
			 $title= substr($title=$arr[4],0,-4);
			  }
			  if($n==1){
				  $title= substr($arr[3]); 
			  }
				return $title;  
		 
		 }

	
	
	
	public function piliang(){
		
		     
        $this->display();
		}
		
	
	public function import(){
		
		          
				  $listArr=Session::get('listArr');
		          if(!$listArr){
					  
					  echo "数据过期";
					  
					  }
					  
				//开始执行批量脚本
				//print_r($listArr);
				$su=0;
				$er=0;
				foreach($listArr as $k=>$v){
					   
					   $data['fs_id']=$v['fs_id'];
					   $data['download_url']=$v['path'];
					   $data['title']=$v['title'];
					   $data['size']=$v['size'];
					   $arr=explode('/',$v['path']);
					   $data['category_id']=M('Category')->where('title like "%'.$arr[3].'%"')->getField('id');
					   $data['keyword']=$data['title']."下载,中文字体".$arr[3];
					   $data['description']=$data['keyword'];
					   $data['content']=$data['description'];
					   $data['create_time']=time();
					   $rs=$this->dao->add($data);
					   if($rs){
						     $su=$su+1;
						   }else{
							   $er=$er+1;
							   }
					   
					}
					M('Category')->Where('id='.$data['category_id'])->setInc($nums,$su);
					echo "成功".$su."条<br/>";
					echo "失败".$er."条";  
					  
		
		   }
	
	
	
	
}

