<?php 

/**

 * 

 * Page(单页)

 *

 * @package      	YIGECMS_Corp

 *

 * @license         http://www.YIGECMS.cn/license.txt

 * @version        	$Id: PageAction.class.php v1.0 2012-01-01 06:59:03 



 */



class PageAction extends GlobalAction

{

    public $dao;

	function _initialize()

	{

		

		$category = D('Category')->where('parent_id=122')->Order('display_order DESC,id DESC')->select();

      
        
		$this->assign('rr', $rr);
        $this->assign('category',$category);
        $this->dao = D('Page');

		parent::_initialize();

		

	}

	/**

     * 列表

     *

     */

	public function index()

	{

		parent::_checkPermission();

		$condition = array();

		$title = formatQuery($_GET['title']);

		$linkLabel = formatQuery($_GET['linkLabel']);

		$orderBy = trim($_GET['orderBy']);

		$orderType = trim($_GET['orderType']);

		$setOrder = setOrder(array(array('viewCount', 'view_count'),'id'), $orderBy, $orderType);

		$pageSize = intval($_GET['pageSize']);

		$title &&  $condition['title'] = array('like', '%'.$title.'%');

		$linkLabel &&  $condition['link_label'] = array('like', '%'.$linkLabel.'%');

		$count = $this->dao->where($condition)->count();

		$listRows = empty($pageSize) || $pageSize > 100 ? 15 : $pageSize ;

		$p = new page($count,$listRows);

		 $dataList = $this->dao->Table(C('DB_PREFIX').'page a')->Join(C('DB_PREFIX').'category b on a.category_id=b.id')->Field('a.*,b.title as category')->Order($setOrder)->Where($condition)->Limit($p->firstRow.','.$p->listRows)->select();

		$page = $p->show();

		if($dataList !== false){

			$this->assign('pageBar', $page);

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

		parent::_checkPermission('Page_insert');

		parent::_setMethod('post');

		if($daoCreate = $this->dao->create())

		{

			$uploadFile = upload($this->getActionName());

			if ($uploadFile)

			{

				$this->dao->attach_image = formatAttachPath($uploadFile[0]['savepath']) . $uploadFile[0]['savename'];

				$this->dao->attach_thumb = fileExit($uploadFile[0]['savepath'] . splitThumb($uploadFile[0]['savename'])) ? formatAttachPath($uploadFile[0]['savepath']) . splitThumb($uploadFile[0]['savename']) : '' ;

				$this->dao->attach_ext = $uploadFile[0]['extension'];

				$this->dao->content=$_POST['content_1'];

			}

			$daoAdd = $this->dao->add();

			if(false !== $daoAdd)

			{

				parent::_sysLog('insert', "提交录入:$daoAdd");

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

		$dao = D("Page");

		$record = $this->dao->where('id='.$item)->find();

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

		parent::_checkPermission('Page_modify');

		parent::_setMethod('post');

		$item = intval($_POST['id']);

		empty($item) && parent::_message('error', 'ID获取错误,未完成编辑');

		if($daoCreate = $this->dao->create())

		{

			$uploadFile = upload($this->getActionName());

			if ($uploadFile)

			{

				$this->dao->attach_image = formatAttachPath($uploadFile[0]['savepath']) . $uploadFile[0]['savename'];

				$this->dao->attach_thumb = fileExit($uploadFile[0]['savepath'] . splitThumb($uploadFile[0]['savename'])) ? formatAttachPath($uploadFile[0]['savepath']) . splitThumb($uploadFile[0]['savename']) : '' ;

				$this->dao->attach_ext = $uploadFile[0]['extension'];

				$this->dao->content=$_POST['content_1'];

				@unlink('./'.$this->upload.$_POST['old_image']);

				@unlink('./'.$this->upload.$_POST['old_thumb']);

			}

			//echo "<pre>";

			//exit(print_r($_POST));

			$daoSave = $this->dao->save();

			if(false !== $daoSave)

			{

				parent::_sysLog('modify', "编辑:$item");

				parent::_message('success', '更新成功');

			}else

			{

				parent::_message('error', '更新失败');

			}

		}else

		{

			parent::_message('error', $this->dao->getError());

		}

	}

	

	

	

	/*单个删除*/

	

	

	 public function delete(){

		  

		 $id = intval($this->_get("id"));

		 $del = $this->dao->where("id = $id")->delete();

		// parent::_tagsDelete('Article');

        // parent::_delete(0, 0, array('attach_image', 'attach_thumb'));

		 

		   if($del){

			 

			 $this->_message('success',"{$items} 删除成功",$jumpUri);

			 }

			 

		 } 

	

	

	/**

     * 批量操作

     *

     */

	public function doCommand()

	{

		parent::_checkPermission('Page_Command');

		if(getMethod() == 'get'){

			$operate = trim($_GET['operate']);

		}elseif(getMethod() == 'post'){

			$operate = trim($_POST['operate']);

		}else{

			parent::_message('error', '只支持POST,GET数据');

		}

		switch ($operate){

			case 'delete': parent::_delete();break;

			case 'update': parent::_batchModify(0, $_POST, array('title', 'link_label'));break;

			default: parent::_message('error', '操作类型错误') ;

		}

	}

}

