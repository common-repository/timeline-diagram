<?php
/*
Plugin Name: Time Line Wordpress
Plugin URI: Description:Wordpress Time Line CSS 3 Effect. You can easy create your one wordpress time line page. 
Author: Md. Shiddikur Rahman
Author URI: http://phpdev.us/siddik
Version: 1.0
*/
/*Some Set-up*/
define('TIME_LINE_WORDPRESS', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
/* Including all files */
function time_line_wordpress_files() {	
wp_enqueue_style('time-line-wordpress-css', TIME_LINE_WORDPRESS.'css/style.css',array(), 1.0, false);
wp_enqueue_script( 'time-line-wordpress-easing-js',TIME_LINE_WORDPRESS.'js/jquery.easing.1.3.js', array('jquery'),'1.3', true);
wp_enqueue_script( 'time-line-wordpress-script-js',TIME_LINE_WORDPRESS.'js/script.js', array('jquery'), 1.0, true);
}
add_action( 'wp_enqueue_scripts', 'time_line_wordpress_files' );


/*---------------------------------------------------
 *This custom post for  Time Line WOrdpress Plugin
 ----------------------------------------------------*/
add_action('init', 'timeline_Feature_thumb');
function timeline_Feature_thumb() {
add_theme_support( 'post-thumbnails' );
add_post_type_support( 'time-line', 'thumbnail' );
post_type_supports( 'time-line', 'thumbnail' );
add_image_size( 'feature_thumb',200,200, true );
}
add_action( 'init', 'timeline_custom_post' );
function timeline_custom_post() {
	$labels = array(
		'name'               => _x( 'Time Line Items', 'time-line' ),
		'singular_name'      => _x( 'Time Line Item',  'time-line' ),
		'menu_name'          => _x( 'Time Line Items', 'time-line' ),
		'name_admin_bar'     => _x( 'Time Line Item',  'time-line' ),
		'add_new'            => _x( 'Add New Time Line Item', 'time-line' ),
		'add_new_item'       => __( 'Add New Time Line Items', 'time-line' ),
		'new_item'           => __( 'New Time Line Items', 'time-line' ),
		'edit_item'          => __( 'Edit Time Line Items', 'time-line' ),
		'view_item'          => __( 'View Time Line Items', 'time-line' ),
		'all_items'          => __( 'All Time Line Items', 'time-line' ),
		'search_items'       => __( 'Search Time Line Items', 'time-line' ),
		'parent_item_colon'  => __( 'Parent Time Line Items:', 'time-line' ),
		'not_found'          => __( 'No Time Line Items found.', 'time-line' ),
		'not_found_in_trash' => __( 'No Time Line Items found in Trash.', 'time-line' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'time-lines' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor','thumbnail' )
	);

	register_post_type( 'time-line', $args );
}

/*--------------------------------------------------------
 *Shortcode for Time Line 
 ---------------------------------------------------------*/
 function time_line_shortode($atts){
	extract( shortcode_atts( array(
	), $atts, 'time-line' ) );
	
    $q = new WP_Query(
        array('posts_per_page' =>-1, 'post_type' => 'time-line')
        );
$list = ' <div class="container"><div id="ss-container" class="ss-container">';
while($q->have_posts()) : $q->the_post();
    //get the ID of your post in the loop
    $id = get_the_ID(); 
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	$list .= '<div class="ss-row ss-medium">
                    <div class="ss-left">
                        <span class="ss-circle ss-circle-1" style="background-image:url('.$url.');">
						</span>
                    </div>
                    <div class="ss-right">
						<div class="ss-right-bg">
							<h3>
								<span>'.get_the_time('F, Y').'</span>
								<a href="#">'.get_the_title().'</a>
							</h3>
							 <p>'.get_the_content().'</p>
						</div>
                    </div>
                </div>';   
			
endwhile;
$list.= '</div></div>';
wp_reset_query();
return $list;
}
add_shortcode('time-line', 'time_line_shortode');	



?>