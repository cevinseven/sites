<?php

if ( function_exists('register_sidebar') )
{
register_sidebar(array('name'=>'Sidebar','before_widget' => '<div class="widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
   ));
}


/*Start of Theme Options*/
$themename = "TV House";
$shortname = "swp";

$categories = get_categories(array('hide_empty'=>false));
$swp_ftcat = array();
foreach ($categories as $category_list ) {
       $swp_ftcat[$category_list->cat_ID] = $category_list->category_nicename;
}
$category_bulk_list = array_unshift($swp_ftcat, "Choose a category:"); 

$options = array (
				  
 
 
array( "type" => "open"),

 /*Start Featured Post management*/

 array( "name" => "Featured Post",
	   	"desc" => "Select the Featured Post Category",
		"type" => "title"),


	array( 	"name" => "Featured Post category",
			"desc" => "For featured images to show, please add post thumbnail field while creating a post",
			"id" => $shortname."_ftpost",
			"std" => "Select a category:",
			"type" => "select",
			"options" => $swp_ftcat),

 /*End Featured Post management*/

/*Start google adsense Management*/

 array( "name" => "Google Adsense",
	   	"desc" => "Insert adsense ",
		"type" => "title"),

array(	"name" => "Enable google Adsense",
			"desc" => "Check this box if you want to enable gogle adsense.",
			"id" => $shortname."_adsense_on",
            "type" => "checkbox"),
			"std" => "",



array( "name" => "Publisher ID",
	"desc" => "Insert the publisher Id from google i.e. <b>pub-2093522799617918</b>",
	"id" => $shortname."_ads1",
	"type" =>"text",
	"std" => "" ),	



/*Start Advertisment management*/

 array( "name" => "Advertisments",
	   	"desc" => "Here you can Insert Advertisment Links",
		"type" => "title"),
 
 
array(	"name" => "Enable Ads 125x125",
			"desc" => "Check this box if you want to enable  advertisment.",
			"id" => $shortname."_ads_on",
            "type" => "checkbox"),
			"std" => "",



array( "name" => "Image 1 Location",
	"desc" => "Insert the Location Link for Image 1 here",
	"id" => $shortname."_ads1",
	"type" =>"text",
	"std" => "" ),	

array( "name" => "Image 1 link",
	"desc" => "Insert the Destination Link  for Image 1 here",
	"id" => $shortname."_url1",
	"type" =>"text",
	"std" => ""),	

array( "name" => "Image 2 Location",
	"desc" => "Insert the Location Link for Image 2 here",
	"id" => $shortname."_ads2",
	"type" =>"text",
	"std" => "" ),	

array( "name" => "Image 2 link",
	"desc" => "Insert the Destination Link  for Image 2 here",
	"id" => $shortname."_url2",
	"type" =>"text",
	"std" => ""),	
	
	array( "name" => "Image 3 Location",
	"desc" => "Insert the Location Link for Image 2 here",
	"id" => $shortname."_ads3",
	"type" =>"text",
	"std" => "" ),	

array( "name" => "Image 3 link",
	"desc" => "Insert the Destination Link  for Image 2 here",
	"id" => $shortname."_url3",
	"type" =>"text",
	"std" => ""),	
	
	array( "name" => "Image 4 Location",
	"desc" => "Insert the Location Link for Image 2 here",
	"id" => $shortname."_ads4",
	"type" =>"text",
	"std" => "" ),	

array( "name" => "Image 4 link",
	"desc" => "Insert the Destination Link  for Image 2 here",
	"id" => $shortname."_url4",
	"type" =>"text",
	"std" => ""),	
	
	

/*End Advertisment management*/







array( "type" => "close")
 
);

function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
header("Location: themes.php?page=functions.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=functions.php&reset=true");
die;
 
}
}
 
add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>

<div class="wrap">
<style> 
.wrap h3 { padding: 10px 0; border-bottom:1px solid #333; font: normal italic 2em 'georgia', serif; }
.wrap small { text-transform:uppercase;  font-size:0.8em;}
.wrap p.op { width:75%;} 
</style>
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>

 
<?php break;
 
case "close":
?>
 
  
<?php break;
  
 case "title":
?>
<h3><?php echo $value['name']; ?></h3>
 
<?php break;

case 'text':
?>
<p class="op">
<strong><?php echo $value['name']; ?></strong>
<input style="width:250px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
  <br/>
 <small><?php echo $value['desc']; ?></small>
  </p>
  
<?php
break;

case 'textarea':
?>
<p class="op">
 <strong><?php echo $value['name']; ?></strong>
  <textarea style="width:250px;" name="<?php echo $value['id']; ?>" style="width:700px; height:100px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea>
 <br/>
 <small><?php echo $value['desc']; ?></small>
  </p>
 
<?php
break;

case 'select':
?>
<p class="op">
<strong><?php echo $value['name']; ?></strong>
<select style="width:250px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select> 
<br/><small><?php echo $value['desc']; ?></small></p>
 
<?php
break;
 
case "checkbox":
?>

<p class="op">
<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /> 
<strong><?php echo $value['name']; ?></strong>
<br/>
<small><?php echo $value['desc']; ?></small>
 </p>
<?php break;
 
}
}
?>

// Get Custom Field Template Values
function getCustomField($theField) {
	global $post;
	$block = get_post_meta($post->ID, $theField);
	if($block){
		foreach(($block) as $blocks) {
			echo $blocks;
		}
	}
}

<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 
<?php

}
add_action('admin_menu', 'mytheme_add_admin');


if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails'); 

?>