<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   Wap入口控制器($Liu.XiangMin)*/

!defined('DYHB_PATH') && exit;

class WapmainController extends InitController{

	public function index($sModel=null,$bDisplay=true){
		$arrOptionData=$GLOBALS['_option_'];

		$this->assign('arrOptions',$arrOptionData);

		$this->display(Admin_Extend::template('wap','wapmain/index'));
	}

	public function update_option(){
		if(isset($_POST['options'])){
			$arrOptions=G::getGpc('options','P');
		}else{
			$arrOptions=array();
		}

		foreach($arrOptions as $sKey=>$val){
			$val=trim($val);
			$oOptionModel=OptionModel::F('option_name=?',$sKey)->getOne();
			$oOptionModel->option_value=$val;
			$oOptionModel->save(0,'update');
			
			if($oOptionModel->isError()){
				$this->E($oOptionModel->getErrorMessage());
			}
		}

		if(!Dyhb::classExists('Cache_Extend')){
			require_once(Core_Extend::includeFile('function/Cache_Extend'));
		}
		Cache_Extend::updateCache('option');

		$this->S(Dyhb::L('配置更新成功','Controller/Option'));
	}

}
