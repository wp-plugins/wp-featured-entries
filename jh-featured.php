<?php
/*
Plugin Name: Featured entries
Plugin URI: http://www.jahertor.com/posts-destacados-plugin-wp-featured-posts/
Description: Create Featured Groups of Entries to put into your desired pages and entries by means of shortcode or PHP funcion. It uses the "Featured image" and the "Excerpt" or the 50 first words of the entry
Version: 1.0
Author: Jahertor
Author URI: http://www.jahertor.com
*/

require_once('vista.php');
require_once('controlador.php');

load_plugin_textdomain('jh-featured', false, basename( dirname( __FILE__ ) ) . '/locale' );
register_activation_hook(__FILE__,'jhfeatured_install');
add_action('admin_menu', 'jhfeatured_inicializar');
function jhfeatured_inicializar() {
  add_menu_page(__('Featured entries', 'jh-featured'), __('Featured entries', 'jh-featured'), 'administrator' , 'jhfeatured-general', 'jhfeatured_admin_page', plugins_url('jh-featured/icon.png'));
}
function jhfeatured_install() {
	jhfeatured_crear_bd(); //Crea la base de datos	
}
function jhfeatured_admin_page(){	
	/* Ver destacado */
	if(isset($_GET['view-ft'])) {
		$id = htmlentities(stripslashes($_GET['view-ft']),ENT_QUOTES, 'UTF-8');
		
		jhfeatured_view_ft($id);
	}
	else {
		jhfeatured_admin(); //Imprime vista principal
	}
}

/* Acciones por POST */
if(isset($_POST['save-ft'])){
	jhfeatured_guardarFt($_POST['title'], $_POST['style'], $_POST['animation']);
}
if(isset($_POST['edit-ft'])){
	jhfeatured_editarFt($_POST['id'], $_POST['title'], $_POST['style'], $_POST['animation']);
}
/*****/

/* Acciones por GET */
if(isset($_GET['accion'])){
	if ($_GET['accion'] == 'eliminar-g') {
		if(isset($_GET['idFt'])){
			jhfeatured_eliminarFt($_GET['idFt']);
		}
	}
}
/*****/

/* Shortcode */
function jhfeatured_shortcode( $atts )  
{
	// $atts ===== array ( 'id' => 1 )
    if ( empty ($atts) )
		return 'Debes especificar algún grupo';

	require_once('modelo.php');
	if ( $grupo = jh_get_featured($atts['id']) ) {
		wp_register_style( 'jhfeatured-style', plugins_url('css/'.$grupo->style.'.css', __FILE__) );
        wp_enqueue_style( 'jhfeatured-style' );
		wp_register_script( 'jhfeatured-script', plugins_url('js/ft_slide.js', __FILE__) );
        wp_enqueue_script( 'jhfeatured-script' );
        
		$res = '
		<div class="jft_posts">';
		
		$i = 1;
		if ($ft_posts = jh_getPostsEnDestacado($grupo->id))
		foreach ($ft_posts as $ft_post) {
			$arr_content = explode(" ",strip_tags(strip_shortcodes($ft_post->post_content)));
			$arr_content = array_slice($arr_content,0,30);
			$content = implode(" ",$arr_content);
			
			$res .= '
			<div class="jft_post" id="jft_post-'.$i.'" data-id="'.$i.'">
				<div class="jft_img">
					<a href="'.get_permalink( $ft_post->ID ).'">'.get_the_post_thumbnail( $ft_post->ID, 'thumbnail' ).'</a>
				</div>
				<div class="jft_content">
					<h2><a href="'.get_permalink( $ft_post->ID ).'">'.get_the_title( $ft_post->ID ).'</a></h2>
					'.$content.'&hellip;
				</div>
			</div>';
			$i++;
		}
		
		$res .= '
			<div class="jft_pag">';
		for ($i = 1; $i <= count($ft_posts); $i++) {
			$res .= '
				<a href="#" id="jft_p_i-'.$i.'" data-ref="'.$i.'">'.$i.'</a>';
		}
		$res .= '
			</div>';
		
		$res .= '
		</div>
		<div class="clear"></div>';
		
		$res .= '
		';
	}
	
	return $res;
}
add_shortcode( 'jhfeatured', 'jhfeatured_shortcode' );

/* Function */
function jhfeatured_show( $id )  
{
	require_once('modelo.php');
	if ( $grupo = jh_get_featured($id) ) {
		wp_register_style( 'jhfeatured-style', plugins_url('css/'.$grupo->style.'.css', __FILE__) );
        wp_enqueue_style( 'jhfeatured-style' );
		wp_register_script( 'jhfeatured-script', plugins_url('js/ft_slide.js', __FILE__) );
        wp_enqueue_script( 'jhfeatured-script' );
        
		$res = '
		<div class="jft_posts">';
		
		$i = 1;
		if ($ft_posts = jh_getPostsEnDestacado($grupo->id))
		foreach ($ft_posts as $ft_post) {
			$content = $ft_post->post_excerpt;
			if (empty($content)) {
				$arr_content = explode(" ",strip_tags(strip_shortcodes($ft_post->post_content)));
				$arr_content = array_slice($arr_content,0,50);
				$content = implode(" ",$arr_content) . '...';
			}
			
			
			$res .= '
			<div class="jft_post" id="jft_post-'.$i.'" data-id="'.$i.'">
				<div class="jft_img">
					<a href="'.get_permalink( $ft_post->ID ).'">'.get_the_post_thumbnail( $ft_post->ID, 'thumbnail' ).'</a>
				</div>
				<div class="jft_content">
					<h2><a href="'.get_permalink( $ft_post->ID ).'">'.get_the_title( $ft_post->ID ).'</a></h2>
					'.$content.'
				</div>
			</div>';
			$i++;
		}
		
		$res .= '
			<div class="jft_pag">';
		for ($i = 1; $i <= count($ft_posts); $i++) {
			$res .= '
				<a href="#" id="jft_p_i-'.$i.'" data-ref="'.$i.'">'.$i.'</a>';
		}
		$res .= '
			</div>';
		
		$res .= '
		</div>
		<div class="clear"></div>';
		
		$res .= '
		';
	}
	
	echo $res;
}
add_shortcode( 'jhfeatured_show', 'jhfeatured_show' );
