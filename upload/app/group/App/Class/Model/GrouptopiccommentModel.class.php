<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   群组帖子评论模型($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class GrouptopiccommentModel extends CommonModel{

	static public function init__(){
		return array(
			'table_name'=>'grouptopiccomment',
			'props'=>array(
				'grouptopiccomment_id'=>array('readonly'=>true),
				'grouptopic'=>array(Db::BELONGS_TO =>'GrouptopicModel','source_key'=>'grouptopic_id','target_key'=>'grouptopic_id'),
				'user'=>array(Db::BELONGS_TO =>'UserModel','source_key'=>'user_id','target_key'=>'user_id'),
				'userprofile'=>array(Db::BELONGS_TO=>'UserprofileModel','source_key'=>'user_id','target_key'=>'user_id'),
				'usercount'=>array(Db::BELONGS_TO=>'UsercountModel','source_key'=>'user_id','target_key'=>'user_id'),
			),
			'attr_protected'=>'grouptopiccomment_id',
			'autofill'=>array(
				array('user_id','userId','create','callback'),
			),
			'check'=>array(
				'grouptopiccomment_title'=>array(
					array('max_length',300,Dyhb::L('回帖标题不能超过300个字符','__APP_ADMIN_LANG__@Model/Grouptopiccomment')),
				),
				'grouptopiccomment_content'=>array(
					array('require',Dyhb::L('帖子评论内容不能为空','__APP_ADMIN_LANG__@Model/Grouptopiccomment')),
				),
			),
		);
	}

	static function F(){
		$arrArgs=func_get_args();
		return ModelMeta::instance(__CLASS__)->findByArgs($arrArgs);
	}

	static function M(){
		return ModelMeta::instance(__CLASS__);
	}

	public function safeInput(){
	}

	protected function userId(){
		$nUserId=$GLOBALS['___login___']['user_id'];

		return $nUserId>0?$nUserId:0;
	}	
	
	protected function userName(){
		$sUserName=$GLOBALS['___login___']['user_name'];

		return $sUserName?$sUserName:'';
	}

	static public function getGrouptopiccommentById($nCommentId,$sField='grouptopiccomment_name',$bAll=false){
		$oGrouptopiccomment=GrouptopiccommentModel::F('grouptopiccomment_id=?',$nCommentId)->query();

		if(empty($oGrouptopiccomment['grouptopiccomment_id'])){
			return '';
		}

		if($bAll===true){
			return $oGrouptopiccomment;
		}
		
		return $oGrouptopiccomment[$sField];
	}

}
