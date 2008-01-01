<?php
/* emlog 2.5.0 Emlog.Net */
require_once('./globals.php');
require_once('../cache/musics');

if($action == ''){
	include getViews('header');
	
	$ismusic = isset($ismusic) && $ismusic === 1?"checked=\"checked\"":'';
	if(isset($auto) && $auto){
		$auto1 = "checked=\"checked\"";
		$auto2 = '';
	}else{
		$auto2 = "checked=\"checked\"";
		$auto1 = '';		
	}
	if(isset($randplay) && $randplay){
		$randplay1 = "checked=\"checked\"";
		$randplay2 = '';
	}else{
		$randplay2 = "checked=\"checked\"";
		$randplay1 = '';		
	}
	$content = '';
	if(isset($mlinks) && $mlinks){
		foreach($mlinks as $key=>$val){
			$content .= urldecode($val)."\n";
		}
	}
	
	require_once(getViews('music'));
	include getViews('footer');cleanPage();
	}

if($action== 'mod'){

	$ismusic= isset($_POST['ismusic']) ? intval($_POST['ismusic']) : 0;
	$mlinks = isset($_POST['mlinks']) ? addslashes(trim($_POST['mlinks'])) : '';
	$randplay = isset($_POST['randplay']) ? intval($_POST['randplay']) : 0;
	$auto = isset($_POST['auto']) ? intval($_POST['auto']) : 0;
	$link = '';
	$i = 0;
	if($mlinks){
			$mlinks = explode("\n",$mlinks);
			foreach($mlinks as $key=>$val){
				if(preg_match("/^(http:\/\/).+/i",$val)>0)
				{
					$link .= "\$mlinks[$i] = \"".urlencode($val)."\";\n";
					$i++;
				}
			}
	}
	if($ismusic && !$i){
		formMsg( "音乐链接中没有可用的音乐地址","./music.php",0);
	}
	$mcache = "<?php\n$link\n\$auto=$auto;\n\$randplay=$randplay;\n\$ismusic=$ismusic;\n?>";
	$MC->mc_print($mcache,'../cache/musics');
	formMsg( "背景音乐设置成功","./music.php",1);
}
?>
