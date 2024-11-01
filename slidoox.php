<?
/*
Plugin Name: slidoox
Plugin URI: http://devoox.com/bluvoox/
Description: A custom slider for your blog.
You can add text, html, images....
This plugin is really easy to install and custom. 
You can see an exemple here : http://devoox.com/bluvoox/
Version: 0.1
Author: devoox
Author URI: http://devoox.com
*/
/*  Copyright 2008  devoox.com  (email : info@devoox.com)

*/


function mt_options_page() {
   global $wpdb;
   global $jal_db_version;
	
/*DB SETUP START*/
$jal_db_version = "0.1";
function jal_install () {
   global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . "slidoox";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  title VARCHAR(100) NOT NULL,
	  content text NOT NULL,
	  position int(3) NOT NULL,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	    add_option("jal_db_version", $jal_db_version);
   }
}
/*DB SETUP END*/
?> 
<style type="text/css">
.title,.content{
float:left;	
}
.title{
width:130px;	
}
#post_form input,#post_form textarea{
background-color:#E4F2FD;	
border:1px solid #ccc;
width:300px;
}
#post_form{
margin-left:20px;
padding:10px;
border:1px solid #ccc;
width:310px;
background-color:#EDF8FC;
float:left;
}
#post_result{
float:left;	
margin-left:10px;
}
.element_style{
border:1px solid #ccc;	
padding-left:10px;
padding-right:10px;
margin-bottom:2px;

}
.element_style:hover{
background-color:#eee;	
cursor:pointer;

}
</style>

<?php	
 $wpdb->show_errors(); 

if($_GET['delete']){
$wpdb->query("DELETE FROM ".$wpdb->prefix."slidoox WHERE id = {$_GET['id']}");
}	 
	 
if($_POST['title'] && $_POST['content']){
$title=$_POST['title'];
$content=$_POST['content'];
if($_POST['id']){
$id=$_POST['id'];
$wpdb->query("UPDATE ".$wpdb->prefix."slidoox SET title = '".$title."', content = '".$content."' WHERE ID = $id ");
}else{
$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."slidoox( title, content) VALUES ( %s, %s )",$title, $content));
}
}
$getinfo=$wpdb->get_results("select * from ".$wpdb->prefix."slidoox order by position ASC");	

if($_GET['item']){
$item_title=$wpdb->get_var("select title from ".$wpdb->prefix."slidoox where id = {$_GET['item']}"); 
$item_content=$wpdb->get_var("select content from ".$wpdb->prefix."slidoox where id = {$_GET['item']}"); 
$item_id=$wpdb->get_var("select id from ".$wpdb->prefix."slidoox where id = {$_GET['item']}"); 

} 

echo '<p>&nbsp;&nbsp;Welcome to your Slidoox Manager. Please enter a title and a content and click on send for add it on your first page.</p>';
echo'
	<div id="post_form" >
		<form method="POST" action="?page=slidoox">
			<p>Title:</p>
			<div><input type="text" name="title" value="'. stripslashes($item_title).'"></div>
			<p>Content:</p>
			<div><textarea name="content" rows="10">'.stripslashes($item_content).'</textarea></div>
			<p><input type="submit" value="send"></p>
			<input type="hidden" name="id" value="'.$item_id.'">
		</form>';
if($_GET['item']){
echo '<div style="text-align:center;text-decoration:underline;"><a href="?page=slidoox&delete=true&id='.$_GET['item'].'">delete</a></div>';
}
echo 	'</div>';

echo '<table id="post_result"><tr><td>';
foreach ($getinfo as $result) {
echo '<table onClick="window.location.href=\'?page=slidoox&item='.$result->id.'\';" class="element_style" width="400">';	
echo '<tr><td width="200">'.stripslashes($result->title).'</td>';
echo '<td>'.stripslashes(substr($result->content,0,30)).'...<td>';
echo '</tr></table>';
}

echo '</td></tr></table>';
}




function slide(){
$script='
<script type="text/javascript"  src="'.PLUGINDIR.'/slidoox/js/mootools.js"></script>
<script type="text/javascript"  src="'.PLUGINDIR.'/slidoox/js/sliding-tabs.js"></script>
<link rel="stylesheet" type="text/css" href="'.PLUGINDIR.'/slidoox/css/style.css">
';
print($script);
}
function contenu(){
global $wpdb;
$getinfo=$wpdb->get_results("select * from ".$wpdb->prefix."slidoox order by position ASC");	


$the_content= '
<div id="box">
<div id="wrapper">
<div id="heading">
<ul id="buttons">';
foreach($getinfo as $title){
$the_content.= '<li>'.$title->title.'</li>';
}
$the_content.= '</ul></div>';

$the_content.= '<div id="panes"><div id="content">';

foreach($getinfo as $title){
$the_content.= '<div class="pane">'.$title->content.'</div>';

}
$the_content.= '</div></div></div>';
		
		
$the_content.= '</div>
<script type="text/javascript" charset="utf-8">
		window.addEvent(\'load\', function () {
			myTabs = new SlidingTabs(\'buttons\', \'panes\');
			
			// this sets up the previous/next buttons, if you want them
			

			window.addEvent(\'resize\', myTabs.recalcWidths.bind(myTabs));
		});
	</script>

';	

return($the_content);
}
function mt_add_pages() {
 add_management_page('Slidoox Manager', 'Slidoox Manager', 8, 'slidoox', 'mt_options_page');
}

add_action('wp_head', 'slide', 2);
add_action('admin_menu', 'mt_add_pages');
add_action('loop_start', 'contenu', 2);

register_activation_hook(__FILE__,'jal_install');
