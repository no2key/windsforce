<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   移动帖子控制器($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class MovetopicController extends Controller{

	public function index(){
		$sGrouptopics=trim(G::getGpc('grouptopics'));
		$nGroupid=intval(G::getGpc('groupid'));
		$sMovegroupid=trim(G::getGpc('move_groupid'));
		$sReason=trim(G::getGpc('reason'));

		if(!Groupadmin_Extend::checkTopicmove()){
			$this->E(Dyhb::L('你没有移动帖子的权限','Controller/Grouptopicadmin'));
		}

		if(empty($sMovegroupid)){
			$this->E(Dyhb::L('你没有选择需要移动到的目标小组','Controller/Grouptopicadmin'));
		}

		if(Core_Extend::isPostInt($sMovegroupid)){
			$oGroup=GroupModel::F('group_id=?',$sMovegroupid)->getOne();
		}else{
			$oGroup=GroupModel::F('group_name=?',$sMovegroupid)->getOne();
		}

		if(empty($oGroup['group_id'])){
			$this->E(Dyhb::L('你需要移动到的目标小组不存在','Controller/Grouptopicadmin'));
		}

		$arrGrouptopics=explode(',',$sGrouptopics);

		$bAdmincredit=false;

		if(!$sReason){
			$sReason=Dyhb::L('该管理人员没有填写操作原因','Controller/Grouptopicadmin');
		}

		if(is_array($arrGrouptopics)){
			foreach($arrGrouptopics as $nGrouptopic){
				$oGrouptopic=GrouptopicModel::F('grouptopic_id=?',$nGrouptopic)->getOne();

				if(!empty($oGrouptopic['grouptopic_id']) && $oGrouptopic->group_id!=$oGroup->group_id){
					$oGrouptopic->group_id=$oGroup->group_id;
					$oGrouptopic->setAutofill(false);
					$oGrouptopic->save(0,'update');
					
					if($oGrouptopic->isError()){
						$this->E($oGrouptopic->getErrorMessage());
					}

					// 发送提醒
					if($GLOBALS['___login___']['user_id']!=$oGrouptopic['user_id']){
						$sNoticetemplate='<div class="notice_movegrouptopic"><span class="notice_title"><a href="{@space_link}">{user_name}</a>&nbsp;'.Dyhb::L('对你的主题执行了移动','Controller/Grouptopicadmin').'&nbsp;<a href="{@grouptopic_link}">'.$oGrouptopic['grouptopic_title'].'</a></span><div class="notice_content"><div class="notice_quote"><span class="notice_quoteinfo">{admin_reason}</span></div>&nbsp;'.Dyhb::L('如果你对该操作有任何疑问，可以联系相关人员咨询','Controller/Grouptopicadmin').'</div><div class="notice_action"><a href="{@grouptopic_link}">'.Dyhb::L('查看','Controller/Grouptopicadmin').'</a></div></div>';

						$arrNoticedata=array(
							'@space_link'=>'group://space@?id='.$GLOBALS['___login___']['user_id'],
							'user_name'=>$GLOBALS['___login___']['user_name'],
							'@grouptopic_link'=>'group://grouptopic/view?id='.$oGrouptopic['grouptopic_id'],
							'admin_reason'=>$sReason,
						);

						try{
							Core_Extend::addNotice($sNoticetemplate,$arrNoticedata,$oGrouptopic['user_id'],'movegrouptopic',$oGrouptopic['grouptopic_id']);
						}catch(Exception $e){
							$this->E($e->getMessage());
						}
					}

					$bAdmincredit=true;
				}
			}
		}

		// 管理积分
		if($bAdmincredit===true){
			Core_Extend::updateCreditByAction('group_topicadmin',$GLOBALS['___login___']['user_id']);
		}

		$this->A(array('group_id'=>$nGroupid,array('move_groupid'=>$oGroup['group_id'])),Dyhb::L('移动主题成功','Controller/Grouptopicadmin'));
	}

}
