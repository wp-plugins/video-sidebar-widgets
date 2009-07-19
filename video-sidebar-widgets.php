<?php
/*
Plugin Name: Video Sidebar Widgets
Plugin URI: http://denzeldesigns.com/wordpress-plugins/video-sidebar-widgets/
Version: 2.0
Description: A video sidebar widget using WordPress 2.8 Widgets API to display videos such as Vimeo, YouTube, MySpace Videos etc. Requires at least WordPress 2.8.1. Now including Random Video Sidebar Widget to randomly display 1 out of 5 preset video.
Author: Denzel Chia
Author URI: http://denzeldesigns.com/
*/ 


add_action('widgets_init', 'load_video_sidebar_widgets');

function load_video_sidebar_widgets() {
register_widget('VideoSidebarWidget');
register_widget('RandomVideoSidebarWidget');
}



class VideoSidebarWidget extends WP_Widget {

function VideoSidebarWidget() {
$widget_ops = array( 'classname' => 'videosidebar', 'description' => __('A Video Widget to display video in sidebar from various video sharing networks', 'videosidebar') );
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
<select id="<?php echo $this->get_field_id( 'v_source' );?>" name="<?php echo $this->get_field_name( 'v_source' );?>" class="widefat" style="width:100%;">
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




//Random video widget starts here


class RandomVideoSidebarWidget extends WP_Widget {

function RandomVideoSidebarWidget() {
$widget_ops = array( 'classname' => 'randomvideosidebar', 'description' => __('A Random Video Widget. Randomly selects 1 of the 5 preset videos for display', 'randomvideosidebar') );
$control_ops = array( 'width' => 200, 'height' => 600, 'id_base' => 'randomvideosidebar' );
$this->WP_Widget( 'randomvideosidebar', __('Random Video Sidebar Widget', 'randomvideosidebar'), $widget_ops, $control_ops );
}


function widget( $args, $instance ) {
extract( $args );

        $RV_title = apply_filters('widget_title', $instance['RV_title'] );
        $RV_width = $instance['RV_width'];
        $RV_height = $instance['RV_height'];
        $RV_autoplay = $instance['RV_autoplay'];
        $RV_id1 = $instance['RV_id1'];
		$RV_source1 = $instance['RV_source1'];
		$RV_id2 = $instance['RV_id2'];
		$RV_source2 = $instance['RV_source2'];
		$RV_id3 = $instance['RV_id3'];
		$RV_source3 = $instance['RV_source3']; 
		$RV_id4 = $instance['RV_id4'];
		$RV_source4 = $instance['RV_source4'];
		$RV_id5 = $instance['RV_id5'];
		$RV_source5 = $instance['RV_source5']; 
					
        echo $before_widget;

        if ( $RV_title )
        echo $before_title . $RV_title . $after_title;
		
		//using rand() to select which video to show 
		
		$selection = rand(1,5); 

        switch($selection){
	
		case 1:
		$Embed_id = $RV_id1;
		$Embed_source = $RV_source1;
		break;
		
		case 2:
		$Embed_id = $RV_id2;
		$Embed_source = $RV_source2;
		break;
		 
		case 3:
		$Embed_id = $RV_id3;
		$Embed_source = $RV_source3;
		break;
		
		case 4:
		$Embed_id = $RV_id4;
		$Embed_source = $RV_source4;
		break;
		
		case 5:
		$Embed_id = $RV_id5;
		$Embed_source = $RV_source5;
		break;
		
		}	
		
		//test for empty $Embed_id and empty $Embed_source. if empty, 
		//assign to same as first video id and source
		
		If(empty($Embed_id)){
		$Embed_id = $RV_id1;
		$Embed_source = $RV_source1;		
		}
				
		$select_source = $Embed_source;
	
		switch ($select_source) {
		
		case null:
		$rv_value = null;
		$rv_flashvar = null;
		$rv_flashvar2 = null;
		break;		
		
        case YouTube:
		$rv_value = "http://www.youtube.com/v/$Embed_id&autoplay=$RV_autoplay&loop=0&rel=0";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
		case Vimeo:
		$rv_value =  "http://vimeo.com/moogaloop.swf?clip_id=$Embed_id&amp;server=vimeo.com&amp;loop=0&amp;fullscreen=1&amp;autoplay=$RV_autoplay";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
		case MySpace:
		$rv_value =  "http://mediaservices.myspace.com/services/media/embed.aspx/m=$Embed_id,t=1,mt=video,ap=$RV_autoplay";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
		case Veoh:
		$rv_value = "http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.20.1002&permalinkId=$Embed_id";
		$rv_value.= "&player=videodetailsembedded&id=anonymous&videoAutoPlay=$RV_autoplay";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
	    case Blip:
		if($RV_autoplay=='1'){
		$R_autoplay2 = "true";
		}else{$R_autoplay2 = "false";}
		$rv_value =  "http://blip.tv/play/$Embed_id?autostart=$R_autoplay2";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
	    case WordPress:
		$rv_value =  "http://v.wordpress.com/$Embed_id";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
		
		case Viddler:
		$rv_value =  "http://www.viddler.com/player/$Embed_id";
		if($RV_autoplay=='1'){
		$rv_flashvar = "<param name=\"flashvars\" value=\"autoplay=t\" />\n";
		$rv_flashvar2 = 'flashvars="autoplay=t" ';
		}
        break;
		
		case DailyMotion:
		$rv_value =  "http://www.dailymotion.com/swf/$Embed_id&autoStart=$RV_autoplay&related=0";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
        break;
				
		
		case Revver:
		$rv_value = "http://flash.revver.com/player/1.0/player.swf?mediaId=$Embed_id&autoStart=$RV_autoplay";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
		break;
		
		case Metacafe:
		$rid = split('/',$Embed_id);
		$rv_value = "http://www.metacafe.com/fplayer/$rid[0]/$rid[1].swf";
		if($RV_autoplay=='1'){
		$rv_flashvar = null;
		$rv_flashvar2 = 'flashVars="playerVars=showStats=no|autoPlay=yes|"';
		}
		break;
		
		case Tudou:
		$rv_value = "$Embed_id";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
		break;
		
		case Youku:
		$rv_value = "$Embed_id";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
		break;
		
		case cn6:
		$rv_value = "$Embed_id";
		$rv_flashvar = null;
		$rv_flashvar2 = null;
		break;
	
		}
		
		
		
        echo "\n<object width=\"$RV_width\" height=\"$RV_height\">\n";
		echo $rv_flashvar;
		echo "<param name=\"allowfullscreen\" value=\"true\" />\n";
		echo "<param name=\"allowscriptaccess\" value=\"always\" />\n";
		echo "<param name=\"movie\" value=\"$rv_value\" />\n";
		echo "<param name=\"wmode\" value=\"transparent\">\n";
		echo "<embed src=\"$rv_value\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" allowfullscreen=\"true\" allowscriptaccess=\"always\" ";
		echo $rv_flashvar2;
		echo "width=\"$RV_width\" height=\"$RV_height\">\n";
		echo "</embed>\n";
		echo "</object>\n\n";
        echo $after_widget;
    }


function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['RV_title'] = strip_tags( $new_instance['RV_title'] );
        $instance['RV_width'] = strip_tags( $new_instance['RV_width'] );
        $instance['RV_height'] = strip_tags( $new_instance['RV_height'] );
        $instance['RV_autoplay'] = strip_tags( $new_instance['RV_autoplay'] );
        $instance['RV_id1'] = strip_tags( $new_instance['RV_id1'] );
		$instance['RV_source1'] = strip_tags( $new_instance['RV_source1'] );
		$instance['RV_id2'] = strip_tags( $new_instance['RV_id2'] );
		$instance['RV_source2'] = strip_tags( $new_instance['RV_source2'] );
		$instance['RV_id3'] = strip_tags( $new_instance['RV_id3'] );
		$instance['RV_source3'] = strip_tags( $new_instance['RV_source3'] );
		$instance['RV_id4'] = strip_tags( $new_instance['RV_id4'] );
		$instance['RV_source4'] = strip_tags( $new_instance['RV_source4'] );
		$instance['RV_id5'] = strip_tags( $new_instance['RV_id5'] );
		$instance['RV_source5'] = strip_tags( $new_instance['RV_source5'] );			
        return $instance;
}


function form($instance) {
$instance = wp_parse_args( (array) $instance, array( 'RV_title' => '', 'RV_width' => '', 'RV_height' => '', 'RV_autoplay' => '','RV_id1' => '','RV_source1' => '', 'RV_id2' => '','RV_source2' => '', 'RV_id3' => '','RV_source3' => '', 'RV_id4' => '','RV_source4' => '', 'RV_id5' => '','RV_source5' => '') );
        $instance['RV_title'] = strip_tags( $instance['RV_title'] );
        $instance['RV_width'] = strip_tags( $instance['RV_width'] );
        $instance['RV_height'] = strip_tags( $instance['RV_height'] );
        $instance['RV_autoplay'] = strip_tags( $instance['RV_autoplay'] );
        $instance['RV_id1'] = strip_tags( $instance['RV_id1'] );
		$instance['RV_source1'] = strip_tags( $instance['RV_source1'] );
		$instance['RV_id2'] = strip_tags( $instance['RV_id2'] );
		$instance['RV_source2'] = strip_tags( $instance['RV_source2'] );
		$instance['RV_id3'] = strip_tags( $instance['RV_id3'] );
		$instance['RV_source3'] = strip_tags( $instance['RV_source3'] );
		$instance['RV_id4'] = strip_tags( $instance['RV_id4'] );
		$instance['RV_source4'] = strip_tags( $instance['RV_source4'] );
		$instance['RV_id5'] = strip_tags( $instance['RV_id5'] );
		$instance['RV_source5'] = strip_tags( $instance['RV_source5'] );			


?>

<!--Title -->        
<p>
<label for="<?php echo $this->get_field_id('RV_title'); ?>">Title:</label> 
<input class="widefat" id="<?php echo $this->get_field_id('RV_title'); ?>" name="<?php echo $this->get_field_name('RV_title'); ?>" type="text" value="<?php echo $instance['RV_title']; ?>" />
</p>

<!--Width -->
<p>
<label for="<?php echo $this->get_field_id('RV_width'); ?>">Width: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_width'); ?>" name="<?php echo $this->get_field_name('RV_width'); ?>" type="text" value="<?php echo $instance['RV_width']; ?>" />
</p>

<!--Height -->
<p>
<label for="<?php echo $this->get_field_id('RV_height'); ?>">Height: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_height'); ?>" name="<?php echo $this->get_field_name('RV_height'); ?>" type="text" value="<?php echo $instance['RV_height']; ?>" />
</p>

<!--first video setting -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_source1' ); ?>">Select Video 1 Source:</label> 
<select id="<?php echo $this->get_field_id( 'RV_source1' );?>" name="<?php echo $this->get_field_name( 'RV_source1' );?>" class="widefat" style="width:100%;">
<option value='YouTube' <?php  if($instance['RV_source1'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['RV_source1'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['RV_source1'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['RV_source1'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['RV_source1'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['RV_source1'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['RV_source1'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['RV_source1'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['RV_source1'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['RV_source1'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['RV_source1'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['RV_source1'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['RV_source1'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('RV_id1'); ?>">Video 1 ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_id1'); ?>" name="<?php echo $this->get_field_name('RV_id1'); ?>" type="text" value="<?php echo $instance['RV_id1']; ?>" /></p>


<!--second video setting -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_source2' ); ?>">Select Video 2 Source:</label> 
<select id="<?php echo $this->get_field_id( 'RV_source2' );?>" name="<?php echo $this->get_field_name( 'RV_source2' );?>" class="widefat" style="width:100%;">
<option value='YouTube' <?php  if($instance['RV_source2'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['RV_source2'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['RV_source2'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['RV_source2'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['RV_source2'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['RV_source2'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['RV_source2'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['RV_source2'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['RV_source2'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['RV_source2'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['RV_source2'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['RV_source2'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['RV_source2'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('RV_id2'); ?>">Video 2 ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_id2'); ?>" name="<?php echo $this->get_field_name('RV_id2'); ?>" type="text" value="<?php echo $instance['RV_id2']; ?>" /></p>


<!--third video setting -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_source3' ); ?>">Select Video 3 Source:</label> 
<select id="<?php echo $this->get_field_id( 'RV_source3' );?>" name="<?php echo $this->get_field_name( 'RV_source3' );?>" class="widefat" style="width:100%;">
<option value='YouTube' <?php  if($instance['RV_source3'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['RV_source3'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['RV_source3'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['RV_source3'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['RV_source3'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['RV_source3'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['RV_source3'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['RV_source3'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['RV_source3'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['RV_source3'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['RV_source3'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['RV_source3'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['RV_source3'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('RV_id3'); ?>">Video 3 ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_id3'); ?>" name="<?php echo $this->get_field_name('RV_id3'); ?>" type="text" value="<?php echo $instance['RV_id3']; ?>" /></p>


<!--fourth video setting -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_source4' ); ?>">Select Video 4 Source:</label> 
<select id="<?php echo $this->get_field_id( 'RV_source4' );?>" name="<?php echo $this->get_field_name( 'RV_source4' );?>" class="widefat" style="width:100%;">
<option value='YouTube' <?php  if($instance['RV_source4'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['RV_source4'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['RV_source4'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['RV_source4'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['RV_source4'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['RV_source4'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['RV_source4'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['RV_source4'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['RV_source4'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['RV_source4'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['RV_source4'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['RV_source4'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['RV_source4'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('RV_id4'); ?>">Video 4 ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_id4'); ?>" name="<?php echo $this->get_field_name('RV_id4'); ?>" type="text" value="<?php echo $instance['RV_id4']; ?>" /></p>


<!--fifth video setting -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_source5' ); ?>">Select Video 5 Source:</label> 
<select id="<?php echo $this->get_field_id( 'RV_source5' );?>" name="<?php echo $this->get_field_name( 'RV_source5' );?>" class="widefat" style="width:100%;">
<option value='YouTube' <?php  if($instance['RV_source5'] == 'YouTube'){echo 'selected="selected"';}?> >YouTube Video</option>
<option value='Vimeo' <?php  if($instance['RV_source5'] == 'Vimeo'){echo 'selected="selected"';}?> >Vimeo Video</option>
<option value='MySpace' <?php  if($instance['RV_source5'] == 'MySpace'){echo 'selected="selected"';}?> >MySpace Video</option>
<option value='Veoh' <?php  if($instance['RV_source5'] == 'Veoh'){echo 'selected="selected"';}?> >Veoh Video</option>
<option value='Blip' <?php  if($instance['RV_source5'] == 'Blip'){echo 'selected="selected"';}?> >blip.tv Video</option>
<option value='WordPress' <?php  if($instance['RV_source5'] == 'WordPress'){echo 'selected="selected"';}?> >WordPress Video</option>
<option value='Viddler' <?php  if($instance['RV_source5'] == 'Viddler'){echo 'selected="selected"';}?> >Viddler Video</option>
<option value='DailyMotion' <?php  if($instance['RV_source5'] == 'DailyMotion'){echo 'selected="selected"';}?> >DailyMotion Video</option>
<option value='Revver' <?php  if($instance['RV_source5'] == 'Revver'){echo 'selected="selected"';}?> >Revver Video</option>
<option value='Metacafe' <?php  if($instance['RV_source5'] == 'Metacafe'){echo 'selected="selected"';}?> >Metacafe Video</option>
<option value='Tudou' <?php  if($instance['RV_source5'] == 'Tudou'){echo 'selected="selected"';}?> >Tudou Video</option>
<option value='Youku' <?php  if($instance['RV_source5'] == 'Youku'){echo 'selected="selected"';}?> >Youku Video</option>
<option value='cn6' <?php  if($instance['RV_source5'] == 'cn6'){echo 'selected="selected"';}?> >6.cn Video</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('RV_id5'); ?>">Video 5 ID: </label>
<input class="widefat" id="<?php echo $this->get_field_id('RV_id5'); ?>" name="<?php echo $this->get_field_name('RV_id5'); ?>" type="text" value="<?php echo $instance['RV_id5']; ?>" /></p>


<!--auto play -->
<p>
<label for="<?php echo $this->get_field_id( 'RV_autoplay' ); ?>">Auto Play:</label> 
<select id="<?php echo $this->get_field_id( 'RV_autoplay' );?>" name="<?php echo $this->get_field_name( 'RV_autoplay' );?>" class="widefat" style="width:100%;">';
<option value='1' <?php  if($instance['RV_autoplay'] == '1'){echo 'selected="selected"';}?>>Yes</option>
<option value='0' <?php  if($instance['RV_autoplay'] == '0'){echo 'selected="selected"';}?>>No</option>
</select>
</p>

        <?php

    }

}






?>