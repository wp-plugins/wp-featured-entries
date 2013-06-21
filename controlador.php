<?php

/* Crea la base de datos cuando se activa el plugin por primera vez*/
function jhfeatured_crear_bd(){
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   //Creando tabla jh_galeria
	$table_name = $wpdb->prefix . "jh_featured";    
	$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `style` varchar(255) NOT NULL,
		  `animation` varchar(255) NOT NULL DEFAULT 'slide',
		  `animation_time` int(11) NOT NULL DEFAULT '400',
		  `time` int(11) NOT NULL DEFAULT '8000',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";	
	dbDelta($sql);
	
   //Creando tabla jh_imagen
	$table_name = $wpdb->prefix . "jh_posts";
	$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `id_post` int(11) NOT NULL,
		  `id_destacado` int(11) NOT NULL,
		  `orden` int(11) NOT NULL DEFAULT '999',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";	
	dbDelta($sql);
}

/* Featureds */
function jhfeatured_guardarFt($title, $style, $animation){
	$title = htmlentities(stripslashes($title),ENT_QUOTES, 'UTF-8');
	$style = htmlentities(stripslashes($style),ENT_QUOTES, 'UTF-8');
	$animation = htmlentities(stripslashes($animation),ENT_QUOTES, 'UTF-8');
	require_once('modelo.php');
	jh_guardar_ft($title, $style, $animation);
	return true;
}
function jhfeatured_editarFt($id, $title, $style, $animation){
	$id = htmlentities(stripslashes($id),ENT_QUOTES, 'UTF-8');
	$title = htmlentities(stripslashes($title),ENT_QUOTES, 'UTF-8');
	$style = htmlentities(stripslashes($style),ENT_QUOTES, 'UTF-8');
	$animation = htmlentities(stripslashes($animation),ENT_QUOTES, 'UTF-8');
	require_once('modelo.php');
	jh_edit_ft($id, $title, $style, $animation);
	return true;
}
function jhfeatured_eliminarFt($id){
	$id = htmlentities(stripslashes($id),ENT_QUOTES, 'UTF-8');
	require_once('modelo.php');
	jh_borrar_ft($id);
	return true;
}
?>
