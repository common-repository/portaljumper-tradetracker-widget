<?php
/*
Plugin Name: linksalt tradetracker datafeed widget
Plugin URI: http://portaljumper.com
Description: This plugin places widgets that will automatically pull affiliate posts out of YOUR tradetracker-NL merchant stores. Generate extra income !! Simply enter your affiliate ID in the widget area and place the widget. <strong><font color='red'>Visit <a href='http://linksalt.com'>linksalt.com</a> for more widgets, info and tips.</font>
Version: 4.1
Author: Peter scheepens
Author URI: http://linksalt.com
*/
add_action( 'widgets_init', 'pj_tt_widget' );

function pj_tt_widget() {
	register_widget( 'portaljumper_tradetracker_widget' );
}

if (!function_exists(_iscurlsupported))
	{
	function _iscurlsupported()
		{
		if (in_array ('curl', get_loaded_extensions())) 
		{ return true;} else {return false;} 
		}
	}


class portaljumper_tradetracker_widget extends WP_Widget 
{


function portaljumper_tradetracker_widget() 
{
	$widget_ops = array( 'classname' => 'example', 'description' => __('This widget will automatically show affiliate advertisement from your tradetracker network. Earn affiliate-income on auto-pilot. Automatic datafeed extractors by portaljumper.com & <a href="http://linksalt.com">linksalt.com</a>', 'example') );
	$control_ops = array( 'width' => 900, 'height' => 350, 'id_base' => 'example-widget' );
	$this->WP_Widget( 'example-widget', __('portaljumper.com TT feed widgets', 'example'), $widget_ops, $control_ops );
}
	
	
function widget( $args, $instance ) 
{
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$affid = get_option('ls_name');
		$merchant = get_option('ls_merch');
		$size = get_option('ls_size');
		echo $before_widget;
		if ( $title )
		echo $before_title . $title . $after_title;

// begin on screen info	
$preview_size = get_option('ls_size');
$psize = explode ("-",$preview_size);
?>
<iframe src="http://linksalt.com/admaker.php?affid=<?PHP echo get_option('ls_name'); ?>&feed=<?PHP echo get_option('ls_merch'); ?>&searchword=&adsize=<?PHP echo get_option('ls_size'); ?>&network=tradetracker_nl&form2=1&co1=FFFFFF&co2=FFFFFF" width="<?PHP echo $psize[0]; ?>" Height="<?PHP echo $psize[1]; ?>" scrolling='no' frameborder='0' marginheight='0' marginwidth='0'>linksalt.com embedding the worlds media</iframe>
<?php
// end on screen info
echo $after_widget;
}
	
function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['merch'] = strip_tags( $new_instance['merch'] );
		$instance['size'] = strip_tags( $new_instance['size'] );
		update_option('ls_title',$instance['title']);
		update_option('ls_name',$instance['name']);
		update_option('ls_merch',$instance['merch']);
		update_option('ls_size',$instance['size']);
		return $instance;
	}
	
function form( $instance )
 
{
		$defaults = array( 'title' => __('portaljumper.com tools', 'example'), 'name' => __('65027', 'example'), 'merch' => __('ElmarReizen.nl-Algemeen.txt', 'example'));
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		
		
		<div style="text-align:center;color:brown">
		<?PHP if (_iscurlsupported()) 
		{
		echo "<small>Curl is supported, all is OK</small><br>";
		$ch = curl_init(); 		
		curl_setopt($ch,CURLOPT_URL,'http://linksalt.com/getfeeds.php?network=tradetracker_nl');
		curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,6);
		if(curl_exec($ch) === false) { echo "<br><font color='red'>Curl error !<br>This needs to be fixed first before you can proceed !</font> " . curl_error($ch);}
		$feeds = curl_exec($ch); 
		curl_close($ch); 
		$feeds = explode("|",$feeds);	
		} 
		else {exit ("Curl is not supported. I am going to stop now"); } 
		?>
		
		
		This widget is for the tradetracker affiliate program.<br> <a href="http://tc.tradetracker.net/?c=27&amp;m=39676&amp;a=65027&amp;r=&amp;u=" target="_blank">Sign up for tradetracker</a> | 
		<a href="http://myplugin.eu" target="_blank">Get widgets for other networks ..</a><hr>
		The front end is now showing widgets from tradetracker merchant: <font color='red'><?php echo $instance['merch']; ?></font>.<br>Pleae make sure you are affiliated with this merchant
		<br> <a href="http://tc.tradetracker.net/?c=27&amp;m=39676&amp;a=65027&amp;r=&amp;u=" target="_blank">Add this merchant to your campaign now.</a><hr>
		</div>
		
		
		<div style="text-align:center;color:darkblue">
		<small>Are the selector below empty ? Only refresh when empty)<br><input type="button" value="Refresh now !" onClick="history.go(0)"></small><br>
		Your widget Title (optional - shows on front end)<br>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:40%;" />
		<br><br>
		Your affiliate ID (<a href="http://portaljumper.com/ttshops/tthelp.jpg" target="_blank">How do I find my ID ?</a>)<br>
		<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:30%;" />		
		<br>
		Select a merchant or productgroup you are affiliated with:<br>
		<select name="<?php echo $this->get_field_name( 'merch' ); ?>" value="<?php echo $instance['merch']; ?>" style="width:80%;" />
		<?PHP
		foreach ($feeds as $feed)
			{
			echo "</option><option value='$feed'>$feed</option>";
			}
		?>	
		</select><br>
		select your preferred widget size:<br>
		<select name="<?php echo $this->get_field_name( 'size' ); ?>" style="width:80%;" />
		</option><option value='120-600'>120 x 600 pixels</option>
		</option><option value='180-600'>180 x 600 pixels</option>
		</option><option value='125-125'>125 x 125 pixels</option>
		</option><option value='200-200'>200 x 200 pixels</option>
		</option><option value='250-250'>250 x 250 pixels</option>
		</option><option value='250-500'>250 x 500 pixels</option>
		</option><option value='300-250'>300 x 250 pixels</option>
		</option><option value='336-250'>336 x 250 pixels</option>
		</option><option value='468-60'>468 x 60 pixels</option>
		</option><option value='500-250'>500 x 250 pixels</option>
		</option><option value='600-90'>600 x 90 pixels</option>
		</option><option value='768-90'>768 x 90 pixels</option>
		</select>
		</div>
		
		
<div style="text-align:center;color:black">
<small><a href="http://portaljumper.com/shop/">get more (free) affiliate tools</a></small></br>

<?PHP
$preview_size = get_option('ls_size');
$psize = explode ("-",$preview_size);
echo "previewing $psize[0] px by $psize[1] px<br>";
?>

<iframe src="http://linksalt.com/admaker.php?affid=<?PHP echo get_option('ls_name'); ?>&feed=<?PHP echo get_option('ls_merch'); ?>&searchword=&adsize=<?PHP echo get_option('ls_size'); ?>&network=tradetracker_nl&form2=1&co1=FFFFFF&co2=FFFFFF" width="<?PHP echo $psize[0]; ?>" Height="<?PHP echo $psize[1]; ?>" scrolling='no' frameborder='0' marginheight='0' marginwidth='0'>linksalt.com embedding the worlds media</iframe>
<br>Here is a live preview of your front-end widget. (Click "SAVE" if you see a blank box)<br>
<hr>
Linksalt.com provides free affiliate services > <a href="http://linksalt.com/myweb/" title='build automated affiliate websites'>Build affiliate websites instead ..</a>
</div>
	<?php
	}
	
	
}
// visit http://owagu.com for more information
?>