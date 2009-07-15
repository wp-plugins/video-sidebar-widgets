<?php
/*
Plugin Name: Video Sidebar Widgets
Plugin URI: http://denzeldesigns.com/wordpress-plugins/video-sidebar-widgets/
Version: 1.0
Description: A video sidebar widget using WordPress 2.8 Widgets API to display videos such as Vimeo, YouTube, MySpace Videos etc.
requires at least WordPress 2.8.1 
Author: Denzel Chia
Author URI: http://denzeldesigns.com/
*/ 


add_action('widgets_init', 'load_video_sidebar_widgets');

function load_video_sidebar_widgets() {
register_widget('VideoSidebarWidget');
}


// vimeo video widget
class VideoSidebarWidget extends WP_Widget {

function VideoSidebarWidget() {
$widget_ops = array( 'classname' => 'videosidebar', 'description' => __('A Video Widget to display multiple videos in sidebar from sources such as YouTube, Vimeo, MySpace etc. Please visit Plugin Site for details', 'videosidebar') );
$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'videosidebar' );
$this->WP_Widget( 'videosidebar', __('Video Sidebar Widget', 'videosidebar'), $widget_ops, $control_ops );
}


function widget( $args, $instance ) {
extract( $args );

        $title2 = apply_filters('widget_title2', $instance['title2'] );
        $v_width2 = $instance['v_width2'];
        $v_height2 = $instance['v_height2'];
        $v_autoplay2 = $instance['v_autoplay2'];
        $v_id2 = $instance['v_id2'];
		$v_source = $instance['v_source']; 


        echo $before_widget;

        if ( $title2 )
        echo $before_title . $title2 . $after_title;
		
		$source = $v_source;
	
		switch ($source) {
		
		case null:
		$value = null;
		$flashvar = null;
		$flashvar2 = null;
		break;		
		
        case YouTube:
        $value = "http://www.youtube.com/v/$v_id2&autoplay=$v_autoplay2&loop=0&rel=0";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
		case Vimeo:
		$value =  "http://vimeo.com/moogaloop.swf?clip_id=$v_id2&amp;server=vimeo.com&amp;loop=0&amp;fullscreen=1&amp;autoplay=$v_autoplay2";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
		case MySpace:
		$value =  "http://mediaservices.myspace.com/services/media/embed.aspx/m=$v_id2,t=1,mt=video,ap=$v_autoplay2";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
		case Veoh:
		$value = "http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.20.1002&permalinkId=$v_id2&player=videodetailsembedded";
		$value.= "&id=anonymous&videoAutoPlay=$v_autoplay2";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
	    case Blip:
		if($v_autoplay2=='1'){
		$autoplay2 = "true";
		}else{$autoplay2 = "false";}
		$value =  "http://blip.tv/play/$v_id2?autostart=$autoplay2";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
	    case WordPress:
		$value =  "http://v.wordpress.com/$v_id2";
		$flashvar = null;
		$flashvar2 = null;
        break;
		
		case Viddler:
		$value =  "http://www.viddler.com/player/$v_id2";
		if($v_autoplay2=='1'){
		$flashvar = "<param name=\"flashvars\" value=\"autoplay=t\" />\n";
		$flashvar2 = 'flashvars="autoplay=t" ';
		}
        break;
		
		case DailyMotion:
		$value =  "http://www.dailymotion.com/swf/$v_id2&autoStart=$v_autoplay2&related=0";
		$flashvar = null;
		$flashvar2 = null;
        break;
				
		
		case Revver:
		$value = "http://flash.revver.com/player/1.0/player.swf?mediaId=$v_id2&autoStart=$v_autoplay2";
		$flashvar = null;
		$flashvar2 = null;
		break;
		
		case Metacafe:
		$id = split('/',$v_id2);
		$value = "http://www.metacafe.com/fplayer/$id[0]/$id[1].swf";
		if($v_autoplay2=='1'){
		$flashvar = null;
		$flashvar2 = 'flashVars="playerVars=showStats=no|autoPlay=yes|"';
		}
		break;
		
		case Tudou:
		$value = "$v_id2";
		$flashvar = null;
		$flashvar2 = null;
		break;
		
		case Youku:
		$value = "$v_id2";
		$flashvar = null;
		$flashvar2 = null;
		break;
		
		case cn6:
		$value = "$v_id2";
		$flashvar = null;
		$flashvar2 = null;
		break;
	
		}
		
		
		
        echo "\n<object width=\"$v_width2\" height=\"$v_height2\">\n";
		echo $flashvar;
		echo "<param name=\"allowfullscreen\" value=\"true\" />\n";
		echo "<param name=\"allowscriptaccess\" value=\"always\" />\n";
		echo "<param name=\"movie\" value=\"$value\" />\n";
		echo "<param name=\"wmode\" value=\"transparent\">\n";
		echo "<embed src=\"$value\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowfullscreen=\"true\" allowscriptaccess=\"always\" ";
		echo $flashvar2;
		echo "width=\"$v_width2\" height=\"$v_height2\">\n";
		echo "</embed>\n";
		echo "</object>\n\n";
        echo $after_widget;
    }


function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title2'] = strip_tags( $new_instance['title2'] );
        $instance['v_width2'] = strip_tags( $new_instance['v_width2'] );
        $instance['v_height2'] = strip_tags( $new_instance['v_height2'] );
        $instance['v_autoplay2'] = strip_tags( $new_instance['v_autoplay2'] );
        $instance['v_id2'] = strip_tags( $new_instance['v_id2'] );
		$instance['v_source'] = strip_tags( $new_instance['v_source'] );
        return $instance;
}


function form($instance) {
$instance = wp_parse_args( (array) $instance, array( 'title2' => '', 'v_width2' => '', 'v_height2' => '', 'v_loop2' => '','v_autoplay2' => '','v_id2' => '','v_source' => '') );
        $instance['title2'] = strip_tags( $instance['title2'] );
        $instance['v_width2'] = strip_tags( $instance['v_width2'] );
        $instance['v_height2'] = strip_tags( $instance['v_height2'] );
        $instance['v_autoplay2'] = strip_tags( $instance['v_autoplay2'] );
        $instance['v_id2'] = strip_tags( $instance['v_id2'] );
		$instance['v_source'] = strip_tags( $instance['v_source'] );


?>

        
<p>
<label for="<?php echo $this->get_field_id('title2'); ?>">Title:</label> 
<input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" type="text" value="<?php echo $instance['title2']; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'v_source' ); ?>">Select Video Source:</label> 
<select id="<?php echo $this->get_field_id( 'v_source' );?>" name="<?php echo $this->get_field_name( 'v_source' );?>" class="widefat" style="width:100%;">';
<option value='YouTube' <?php  if($instance['v_source'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['v_source'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['v_source'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['v_source'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['v_source'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['v_source'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['v_source'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['v_source'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['v_source'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['v_source'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['v_source'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['v_source'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['v_source'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('v_id2'); ?>">Video ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('v_id2'); ?>" name="<?php echo $this->get_field_name('v_id2'); ?>" type="text" value="<?php echo $instance['v_id2']; ?>" /></p>

<p>
<label for="<?php echo $this->get_field_id('v_width2'); ?>">Width: </label>
<input class="widefat" id="<?php echo $this->get_field_id('v_width2'); ?>" name="<?php echo $this->get_field_name('v_width2'); ?>" type="text" value="<?php echo $instance['v_width2']; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('v_height2'); ?>">Height: </label>
<input class="widefat" id="<?php echo $this->get_field_id('v_height2'); ?>" name="<?php echo $this->get_field_name('v_height2'); ?>" type="text" value="<?php echo $instance['v_height2']; ?>" />
</p>

<p>
<?php

$source = $instance['v_source']; 
$msg = "<p>Sorry, auto play option not supported by ".$source."</p>";
switch ($source) {
		
	    case WordPress:
	    echo $msg;
        break;
		
		case Tudou:
	    echo $msg;
        break;
		
		case Youku:
	    echo $msg;
        break;
		
		case cn6:
	    echo "<p>Sorry, auto play option not supported by 6.cn</p>";
        break;
	}	

?>
<label for="<?php echo $this->get_field_id( 'v_autoplay2' ); ?>">Auto Play:</label> 
<select id="<?php echo $this->get_field_id( 'v_autoplay2' );?>" name="<?php echo $this->get_field_name( 'v_autoplay2' );?>" class="widefat" style="width:100%;">';
<option value='1' <?php  if($instance['v_autoplay2'] == '1'){echo 'selected="selected"';}?>>Yes</option>
<option value='0' <?php  if($instance['v_autoplay2'] == '0'){echo 'selected="selected"';}?>>No</option>
</select>
</p>

        <?php

    }

}

?>