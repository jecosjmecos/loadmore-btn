<?php
/* 
 * Plugin name: Loadmore btn
 * Plugin URI:  https://jecosjmecos.com.ua/
 * Description: Добавляет кнопку Loadmore к циклу
 * Version: 1.1.1
 * Author: jecosjmecos
 * Author URI: https://jecosjmecos.com.ua/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: loadmore-btn
 * Domain Path: /languages
 *
 * Network: true
 */


/*
* Action
*/
add_action('init_loadmore_btn', 'display_loadmore_btn');

/*
* Add settings submenu
*/

// add_action('admin_menu', 'register_my_loadmore_submenu');

// function register_my_loadmore_submenu()
// {
// 	add_submenu_page(
// 		'options-general.php',
// 		'Loadmore btn settings',
// 		'Loadmore btn',
// 		'manage_options',
// 		'loadmore_btn',
// 		'loadmore_submenu_page_callback'
// 	);
// }

// function loadmore_submenu_page_callback()
// {
// 	require_once 'submenu-content.php';
// }



/*
* Add scripts
*/
function loadmore_btn_script()
{
	wp_register_script('loadmore-btn', plugin_dir_url(__FILE__) . '/loadmore-btn.js', array('jquery'));

	wp_localize_script('loadmore-btn', 'params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
	));

	wp_enqueue_script('loadmore-btn');
}

add_action('wp_enqueue_scripts', 'loadmore_btn_script');

/*
* Ajax callback function
*/
function loadmore_ajax_handler()
{

	$args = [
		'paged' => $_POST['current_page'] + 1,
		'post_status' => 'publish'
	];

	query_posts($args);

	if (have_posts()) :

		while (have_posts()) : the_post();

			get_template_part('template-parts/article');

		endwhile;

	endif;
	die;
}



add_action('wp_ajax_loadmore_btn', 'loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore_btn', 'loadmore_ajax_handler'); 


/*
* display btn 
*/
function display_loadmore_btn()
{
	global $wp_query;
	$output = '';
	$current_page = get_query_var( 'paged' ) ? get_query_var('paged') : 1;
	$max_page = $wp_query->max_num_pages;

	$output .= '<div id="loadmoreBtn" class="articles__more col-lg-12">';
		$output .= '<a href="#" data-current="' . $current_page . '" data-max="' . $max_page . '" class="site-btn">';
			$output .= '<span class="loading-text" style="display: none">' . __('loading...', 'loadmore-btn') . '</span>';
			$output .= '<span class="deafult-text">' . __('more', 'loadmore-btn') . '</span>';
		$output .= '</a>';
	$output .= '</div>';					

	echo $output;
}



