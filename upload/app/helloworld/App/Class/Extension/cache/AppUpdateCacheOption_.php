<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   helloworld应用配置缓存($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class AppUpdateCacheOption{

	public static function cache(){
		$arrData=array();

		$arrOptionData=HelloworldoptionModel::F()->asArray()->all()->query();
		if(is_array($arrOptionData)){
			foreach($arrOptionData as $nKey=>$arrValue){
				$arrData[$arrValue['helloworldoption_name']]=$arrValue['helloworldoption_value'];
			}
		}

		Core_Extend::saveSyscache('helloworld_option',$arrData);
	}

}
