<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>	
<div class="sidebar">
<ul>
<li><h2 onclick="showhidediv('calendar')">日历</h2>
<ul>
<div id="calendar"></div>
</ul>
</li>
<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>

<li><h2 onclick="showhidediv('tags')">标签</h2>
<ul id="tags">
<?php
foreach($tag_cache as $value){
?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php
}?>
</ul>
</li>
<?php
if($index_twnum>0){
?>
<li><h2 onclick="showhidediv('twitter')">Twitter</h2>
<ul id="twitter">
<?php  if(isset($tw_cache) && is_array($tw_cache)) {
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value)
{
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = smartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
<?php
}echo $morebt;}
?>
</ul>
<?php
if(ISLOGIN === true)
{
?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="overflow-y: hidden;width:140px;height:70px;" class="input"></textarea>
<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
</li>
</ul>
<?php
}
}
?>
<li><h2 onclick="showhidediv('blogroll')">Blogroll</h2>
<ul id="blogroll">
<?php
foreach($link_cache as $value){
?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php
}?>	
		</ul>
</li>
	
</ul>
		</div>
