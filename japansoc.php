<?php
/*
Plugin Name: JapanSoc: Soc it!
Plugin URI: http://www.instant-ramen.net/2009/04/new-japansoc-it-button/
Description: Allows your users to submit your posts to JapanSoc.com and vote.
Version: 0.3
Author: Nick Ramsay (thanks to Louis Ponder)
Author URI: http://www.japansoc.com
*/

$japansocsite = "http://www.japansoc.com/index.php?page=evb";
$float_button = "left";
$button_margin_left = 0;
$button_margin_right = 10;

$float_button2 = "right";
$button_margin_left2 = 10;
$button_margin_right2 = 0;

function add_japansoc()
{
	global $post, $japansocsite, $float_button, $button_margin_left, $button_margin_right;
	$middle = get_post_meta($post->ID, 'japansocleft', $single=true);
	if ($middle != ''){
		$before = "<span style=\"float:".$float_button.";\"><script type=\"text/javascript\" src=\"".$japansocsite."\">";
		$end = "';</script></span>";
		return $before.$middle.$end;
	}
	else{
		if(!is_search() && !is_archive() && !is_category() && !is_tag())
			{
				$script_bit = "<script type=\"text/javascript\"> submit_url = \"" . get_permalink($post->ID) . "\"; </script>";
			}
		else
			{
				$script_bit = "";
			}
		return "<span style=\"padding-top: 0px; padding-bottom: 2px; margin-left:".$button_margin_left."px; margin-right:".$button_margin_right."px; float:".$float_button.";\">".$script_bit."<script type=\"text/javascript\" src=\"".$japansocsite."\"></script></span>";
	}
}

function add_japansoc2()
{
	global $post,$japansocsite,$float_button2,$button_margin_left2,$button_margin_right2;
	$middle = get_post_meta($post->ID, 'japansocright', $single=true);
	if ($middle != ''){
		$before = "<span style=\"float:".$float_button2.";\"><script type=\"text/javascript\" src=\"".$japansocsite."\">";
		$end = "';</script></span>";
		return $before.$middle.$end;
	}
	else{
		if(!is_search() && !is_archive() && !is_category() && !is_tag())
			{
				$script_bit = "<script type=\"text/javascript\"> submit_url = \"" . get_permalink($post->ID) . "\"; </script>";
			}
		else
			{
				$script_bit = "";
			}
		return "<span style=\"padding-top: 0px; padding-bottom: 2px; margin-left:".$button_margin_left2."px; margin-right:".$button_margin_right2."px; float:".$float_button2.";\">".$script_bit."<script type=\"text/javascript\" src=\"".$japansocsite."\"></script></span>";
	}
}

function add_japansoc_quicktag()
{
	if(strpos($_SERVER['REQUEST_URI'], 'post.php'))
	{
		?>
		<script language="JavaScript" type="text/javascript"><!--
		var toolbar = document.getElementById("ed_toolbar");
		<?php
				edit_insert_button("JSoc-L", "japansocleft", "japansocleft");
				edit_insert_button("JSoc-R", "japansocright", "japansocright");
		?>
		function japansocleft()
		{
			edInsertContent(edCanvas, '\<!--japansocleft--\>');
		}
		function japansocright()
		{
			edInsertContent(edCanvas, '\<!--japansocright--\>');
		}

		//--></script>
		<?php
	}
}
if(!function_exists('edit_insert_button'))
{
	function edit_insert_button($caption, $js_onclick, $title = '')
	{
		?>
		if(toolbar)
		{
			var theButton = document.createElement('input');
			theButton.type = 'button';
			theButton.value = '<?php echo $caption; ?>';
			theButton.onclick = <?php echo $js_onclick; ?>;
			theButton.className = 'ed_button';
			theButton.title = "<?php echo $title; ?>";
			theButton.id = "<?php echo "ed_{$caption}"; ?>";
			toolbar.appendChild(theButton);
		}
		<?php
	}
}
function japansoc_button_check($content)
{
	if(preg_match('|<!--japansoc-->|', $content)){
		return str_replace('<!--japansoc-->', add_japansoc(), $content);
	}
	elseif(preg_match('|<!--japansocleft-->|', $content)){
		return str_replace('<!--japansocleft-->', add_japansoc(), $content);
	}
	elseif(preg_match('|<!--japansocright-->|', $content)){
		return str_replace('<!--japansocright-->', add_japansoc2(), $content);
	}
	else {
		return $content;
	}
}
add_filter('admin_footer', 'add_japansoc_quicktag');
add_action('the_content', 'japansoc_button_check');
?>