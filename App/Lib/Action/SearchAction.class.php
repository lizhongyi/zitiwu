<?php

/**

 * 

 * 搜索

 *

 * @package      	YIGECMS_CORP

 *

 * @license         http://www.YIGECMS.cn/license.txt

 * @version        	$Id: ArticleAction.class.php v1.0 2012-01-01 06:59:03 

 */



class SearchAction extends GlobalAction

{

    public $dao;

    function _initialize()

    {

        parent::_initialize();

        $this->assign('moduleTitle', '搜索中心');

        $this->assign($data);

		$this->dao = M('Page');

		//获取page标题

		$row=$this->dao->where('category_id=95')->order("id asc")->select(); 

        $this->assign('row',$row);

    }



    /**

     * 列表

     *

     */

    public function index()

    {   
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
  
   foreach($list as $k=>$v){
	      
		  $list[$k]=(array)($list[$k]);
	   
	   }
   //如果资源没有的花那么就搜索分类
	   
	foreach($list as $k=>$v){
	      
		  $list[$k]['title']=$this->imp($v['path']);
	   
	   }
	   
	   
   $this->assign('dataList',$list);
  

   $this->display();

    }

  
     public function imp($str){
		 
		      if(!$str) return false;
			  $arr=explode('/',$str);
			 $title= substr($title=$arr[4],0,-4);
			 
				return $title;  
		 
		 }

    /**

     * 提交评论

     *

     */

    public function doInsert()

    {

        $data['username'] = dadds(trim($_POST['username']));

        $data['email'] = dadds(trim($_POST['email']));

        $data['content'] = trim($_POST['content']);

        $data['module'] = trim($_POST['module']);

        $data['title_id'] = intval($_POST['title_id']);

        $data['ip'] = get_client_ip();

        $data['create_time'] = time();

        $verifyCode = intval(trim($_POST['verifyCode']));

        if(empty($data['username']) || empty($data['content'])){

            echo 'emptyInfo';

            exit();

        }elseif(md5($verifyCode) != Session::get('verify'))

        {

            echo 'errorVerifyCode';

            exit();

        }

        if($daoCreate = $this->dao->create($data))

        {

            $daoAdd = $this->dao->add();

            if(false !== $daoAdd)

            {

                echo 'success';

                exit();

            }else

            {

                echo '评论录入错误';

                exit();

            }

        }else

        {

            echo $this->dao->getError();

            exit();

        }

    }

}