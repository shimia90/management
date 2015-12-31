<?php 

//add menu

if ( function_exists( 'register_nav_menu' ) ) {
 register_nav_menu( 'main-menu','Main Menu' );
}

/* Function: @metabox*/



include_once('metabox/metabox.php');



/*--create post type--*/
require_once(dirname(__FILE__).'/create_posttype.php');

//add widget
function flink_left()
{
register_sidebar( array(

'name' => 'flink_left',

 'class' => 'flink_left',

 'description' => 'this is flink_left',

 'before_title' => '',

 'after_title' => '',

 'before_widget' => '',

 'after_widget' => '',
) );
}
add_action('widgets_init','flink_left');



function post_type_tags_fix($request) {
	if ( isset($request['tag']) && !isset($request['post_type']) )
	//$request['post_type'] = 'skills';
	 $request['post_type'] = array( 'skills',  'works' ,'post');
	return $request;
} 
add_filter('request', 'post_type_tags_fix');

function filter_search($query) {
    if ($query->is_search) {
	$query->set('post_type', array('page','post', 'works','skills'));
    };
    return $query;
};

add_filter('pre_get_posts', 'filter_search');
/* wp navi */
function my_posts_nav_link( $type = '', $label = '',  $maxPageNum = '' ) {
	$args = array_filter( compact('type', 'label', 'maxPageNum') );
	echo my_get_posts_nav_link($args);
}

function my_get_posts_nav_link($args = array()) {
	$return = '';
	$defaults = array(
		'maxPageNum' => '0',
	);
	$max_num_pages = $args['maxPageNum'];
	$args = wp_parse_args( $args, $defaults );
	$paged = get_query_var('paged');
	if ( $max_num_pages > 1 ) {
		if ($args['type'] == "next") {
			$return = get_previous_posts_link($args['label']);
		}
		if ($args['type'] == "prev") {
			$return = my_get_next_posts_link($args['label'], $max_num_pages);
		}
	}
	return $return;
}

function my_get_next_posts_link( $label = 'Next Page &raquo;', $max_page = 0 ) {
	global $paged, $wp_query;
	if ( !$paged ) {
		$paged = 1;
	}
	$nextpage = intval($paged) + 1;
	if ( !is_single() && ( empty($paged) || $nextpage <= $max_page) ) {
		$attr = apply_filters( 'next_posts_link_attributes', '' );
		return '<a href="' . next_posts( $max_page, false ) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&$1', $label) . '</a>';
	}
}

add_filter( ‘option_posts_per_page’, ‘tdd_tax_filter_posts_per_page’ );
function tdd_tax_filter_posts_per_page( $value ) {
return (is_tax(‘custom-taxonomy’)) ? 1 : $value;
}


/*<!--$option_posts_per_page = get_option( 'posts_per_page' );
add_action( 'init', 'my_modify_posts_per_page', 0);
function my_modify_posts_per_page() {
    add_filter( 'option_posts_per_page', 'my_option_posts_per_page' );
}
function my_option_posts_per_page( $value ) {
    global $option_posts_per_page;
    if ( is_tax( 'works-cat') ) {
        return 2;
    } else {
        return $option_posts_per_page;
    }
}-->*/

// Add Shortcode
function unRemoveCharacter( $atts , $content = null ) {

	$content = str_replace('/', '\\', $content);
	return $content;

}
add_shortcode( 'origin_path', 'unRemoveCharacter' );