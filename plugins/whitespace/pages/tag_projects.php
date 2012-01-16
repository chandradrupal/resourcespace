<?php
include "../../../include/db.php";
include "../../../include/authenticate.php"; if (!checkperm("n")) {exit("Permission denied");}
include "../../../include/general.php";
include "../../../include/resource_functions.php";
include "../include/airotek_functions.php";

$offset=getvalescaped("offset",0);
$find=getvalescaped("find","");
$proj_order_by=getvalescaped("proj_order_by","due");
$sort=getval("sort","ASC");
$revsort = ($sort=="ASC") ? "DESC" : "ASC";
# pager
$per_page=getvalescaped("per_page_list",$default_perpage_list);setcookie("per_page_list",$per_page);

if (array_key_exists("find",$_POST)) {$offset=0;} # reset page counter when posting

include "../../../include/header.php";
?>
<style>#CentralSpaceContainer {margin:0px 25px 0px;padding:0 0px 0 0;text-align:left;} #CentralSpace {margin-left: 0px; padding: 0; }</style>

<form method="post" id="mainform">

<div style="margin-right:-15px;">


<h1>My Projects</h1>

<?php

$collections=get_user_projects($userref);
?>

<div class="Listview">
<table border="0" cellspacing="0" cellpadding="0" class="ListviewStyle">
<tr class="ListviewTitleStyle">
<td><?php if ($proj_order_by=="name") {?><span class="Selected"><?php } ?><a href="tag_projects.php?offset=0&proj_order_by=name&sort=<?php echo $revsort?>&find=<?php echo urlencode($find)?>">Project Name</a><?php if ($proj_order_by=="name") {?><div class="<?php echo $sort?>">&nbsp;</div><?php } ?></td>

<td><?php if ($proj_order_by=="field") {?><span class="Selected"><?php } ?><a href="tag_projects.php?offset=0&proj_order_by=field&sort=<?php echo $revsort?>&find=<?php echo urlencode($find)?>">Field</a><?php if ($proj_order_by=="field") {?><div class="<?php echo $sort?>">&nbsp;</div><?php } ?></td>

<td><?php if ($proj_order_by=="user") {?><span class="Selected"><?php } ?><a href="tag_projects.php?offset=0&proj_order_by=user&sort=<?php echo $revsort?>&find=<?php echo urlencode($find)?>">User</a><?php if ($proj_order_by=="user") {?><div class="<?php echo $sort?>">&nbsp;</div><?php } ?></td>

<td><?php if ($proj_order_by=="created") {?><span class="Selected"><?php } ?><a href="tag_projects.php?offset=0&proj_order_by=created&sort=<?php echo $revsort?>&find=<?php echo urlencode($find)?>">Created</a><?php if ($proj_order_by=="created") {?><div class="<?php echo $sort?>">&nbsp;</div><?php } ?></td>

<td><?php if ($proj_order_by=="due") {?><span class="Selected"><?php } ?><a href="tag_projects.php?offset=0&proj_order_by=due&sort=<?php echo $revsort?>&find=<?php echo urlencode($find)?>">Due</a><?php if ($proj_order_by=="due") {?><div class="<?php echo $sort?>">&nbsp;</div><?php } ?></td>

<td><div class="ListTools">Actions</div></td>

</tr>
<form method="get" name="colactions" id="colactions">
<?php

for ($n=$offset;(($n<count($collections)) && ($n<($offset+$per_page)));$n++)
	{
	?><tr>
	<td><div class="ListTitle"><a href="tag_project.php?ref=<?php echo $collections[$n]['ref']?>"><?php echo $collections[$n]["name"]?></a></div></td>
	<td><?php $field=get_fields(array($collections[$n]["field"])); echo $field[0]['title'];?></td>
	<td><?php $user=get_user($collections[$n]["user"]); echo ucwords($user['username'])." (".$user['fullname'].")";?></td>
	<td><?php echo date("m-j-Y",strtotime($collections[$n]["created"]))?></td>
	<td><?php echo date("m-j-Y", strtotime($collections[$n]["due"]))?></td>
	<td>
    <div class="ListTools">
	<a href="tag_project.php?ref=<?php echo $collections[$n]['ref']?>">&gt;&nbsp;Go</a>
	</td>
	</tr><?php
	
}

	?>
	<input type=hidden name="deleteempty" id="collectiondeleteempty" value="">
	
	<?php if ($collections_delete_empty){
        $use_delete_empty=false;
        //check if delete empty is relevant
        foreach ($collections as $collection){
            if ($collection['count']==0){$use_delete_empty=true;}
        }
        if ($use_delete_empty){
        ?>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><?php if (!$hide_access_column){?><td>&nbsp;</td><?php } ?><?php hook("addcollectionmanagespacercolumn");?><td><div class="ListTools">&nbsp;<a href="#" onclick="if (confirm('<?php echo $lang["collectionsdeleteemptyareyousure"]?>')) {document.getElementById('collectiondeleteempty').value='yes';document.getElementById('collectionform').submit();} return false;">&gt;&nbsp;<?php echo $lang["collectionsdeleteempty"]?></a></div></td></tr>
        <?php }
    }
?>
</table>
</div>

</form>
<div class="BottomInpageNav"><?php pager(false); ?></div>
</div>
<?php
include "../../../include/footer.php";
?>
<script src="<?php echo $magictouch_secure ?>://www.magictoolbox.com/mt/<?php echo $magictouch_account_id ?>/magictouch.js" type="text/javascript" defer="defer"></script>