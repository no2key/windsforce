<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   离开小组控制器($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class LeavegroupController extends Controller{

	public function index(){
		// 获取参数
		$nGid=G::getGpc('gid','G');

		if($GLOBALS['___login___']===false){
			$this->E(Dyhb::L('退出小组需登录后才能进行','Controller/Group'));
		}
		
		$oGroup=GroupModel::F('group_id=?',$nGid)->getOne();
		if(empty($oGroup['group_id'])){
			$this->E(Dyhb::L('小组不存在或在审核中','Controller/Group'));
		}

		// 查询用户是否加入小组
		$arrCondition=array('group_id'=>$nGid,'user_id'=>$GLOBALS['___login___']['user_id']);

		$oGroupuser=GroupuserModel::F($arrCondition)->getOne();
		if(empty($oGroupuser['user_id'])){
			$this->E(Dyhb::L('你尚未加入该小组','Controller/Group'));
		}

		$oGroupuser->destroy();

		// 更新小组中的用户数量
		$oGroup->group_usernum=GroupuserModel::F('group_id=?',$nGid)->getCounts();
		$oGroup->setAutofill(false);
		$oGroup->save(0,'update');
		
		if($oGroup->isError()){
			$this->E($oGroup->getErrorMessage());
		}

		$this->S(Dyhb::L('成功退出 %s 小组','Controller/Group',null,$oGroup->group_nikename));
	}

}