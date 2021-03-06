<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   用户在线模型($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class OnlineModel extends CommonModel{

	static public function init__(){
		return array(
			'table_name'=>'online',
		);
	}

	static function F(){
		$arrArgs=func_get_args();
		return ModelMeta::instance(__CLASS__)->findByArgs($arrArgs);
	}

	static function M(){
		return ModelMeta::instance(__CLASS__);
	}

}
