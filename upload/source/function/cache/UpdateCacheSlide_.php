<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   幻灯片缓存($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class UpdateCacheSlide{

	public static function cache(){
		$arrData=array();

		$arrSlides=SlideModel::F('slide_status=?',1)->order('slide_sort ASC,create_dateline DESC')->getAll();
		if(is_array($arrSlides)){
			foreach($arrSlides as $oSlide){
				$arrData[]=array(
					'slide_title'=>$oSlide['slide_title'],
					'slide_img'=>Core_Extend::getEvalValue($oSlide['slide_img']),
					'slide_url'=>Core_Extend::getEvalValue($oSlide['slide_url']),
				);
			}
		}

		Core_Extend::saveSyscache('slide',$arrData);
	}

}
