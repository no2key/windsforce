/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   前台短消息&&提醒($Liu.XiangMin)*/

function getNewpms(userid){
	$.ajax({
		type:"GET",
		url:D.U('home://misc/newpmnum?uid='+userid),
		success: function(data){
			var dataJson=eval('('+data+')');

			if(dataJson.total>0){
				// 显示消息框
				var sMessage='<a href="'+D.U('home://pm/index?'+(dataJson.user?'type=new':'type=systemnew'))+'" title="'+D.L('私人消息','__COMMON_LANG__@Js/Pm_Js')+'('+dataJson.user+') '+D.L('系统消息','__COMMON_LANG__@Js/Pm_Js')+'('+dataJson.system+')"><img src="'+_ROOT_+'/Public/images/common/notice_newpm.gif"/> '+D.L('新消息','__COMMON_LANG__@Js/Pm_Js')+'+'+dataJson.total+'</a>';
				if(pm_sound_on==1){
					sMessage+='<div id="pmsound" style="position:absolute;top:-100000px">&nbsp;</div>';
				}
				$('#new-message-box').html(sMessage);
				$WF('pmsound').innerHTML=AC_FL_RunContent('id','pmsoundplayer','name','pmsoundplayer','width','0','height','0','src',_ROOT_+'/Public/images/common/sound/player.swf','FlashVars','sFile='+sound_outurl,'menu','false','allowScriptAccess','sameDomain','swLiveConnect','true');

				// 赋值
				if($WF('usernew-pm-num')){
					if(dataJson.user){
						$WF('usernew-pm-num').innerHTML='<span class="badge badge-important">'+dataJson.user+'</span>';
					}else{
						$WF('usernew-pm-num').innerHTML='<span class="badge">'+dataJson.user+'</span>';
					}
				}
				if($WF('systemnew-pm-num')){
					if(dataJson.system){
						$WF('systemnew-pm-num').innerHTML='<span class="badge badge-important">'+dataJson.system+'</span>';
					}else{
						$WF('systemnew-pm-num').innerHTML='<span class="badge>'+dataJson.system+'</span>';
					}
				}
				
				// 闪烁标题
				var titleState=0;
				var promptState=0;
				var oldTitle=document.title;
				flashTitle=function(){
					document.title=(titleState?'\u3010\u3000\u3000\u3000\u3011':'【'+D.L('新消息','__COMMON_LANG__@Js/Pm_Js')+'】'+'('+dataJson.total+') ')+oldTitle;
					titleState=!titleState;
				}

				window.setInterval('flashTitle();',500);
			}
		}
	});
}

function getNewnotices(userid){
	$.ajax({
		type:"GET",
		url:D.U('home://misc/newnoticenum?uid='+userid),
		success: function(data){
			var dataJson=eval('('+data+')');

			if(dataJson.num>0){
				// 显示消息框
				var sMessage='<a href="'+D.U('home://notice/index?type=new')+'" title="'+D.L('未读提醒','__COMMON_LANG__@Js/Pm_Js')+'('+dataJson.num+')"><img src="'+_ROOT_+'/Public/images/common/notice_new.gif"/> '+D.L('新提醒','__COMMON_LANG__@Js/Pm_Js')+'+'+dataJson.num+'</a>';

				$('#new-notice-box').html(sMessage);

				// 赋值
				if($WF('usernew-notice-num')){
					if(dataJson.num){
						$WF('usernew-notice-num').innerHTML='<span class="badge badge-important">'+dataJson.num+'</span>';
					}else{
						$WF('usernew-notice-num').innerHTML='<span class="badge">'+dataJson.num+'</span>';
					}
				}
			}
		}
	});
}
