<?php

	/* Featured */
	function jh_get_featured_groups(){
		global $wpdb;
		$table_name = $wpdb->prefix . "jh_featured"; 
		
		$query = "SELECT * FROM $table_name"; 
		$imgs = $wpdb->get_results($query);			
		return $imgs;
	}
	function jh_get_featured($id){
		global $wpdb;
		$table_name = $wpdb->prefix . "jh_featured"; 
		
		$query = "SELECT * FROM $table_name WHERE id=$id"; 
		$imgs = $wpdb->get_row($query);			
		return $imgs;
	}

	function jh_guardar_ft($title, $style, $animation){
		global $wpdb;
		$table_name = $wpdb->prefix . "jh_featured"; 
		$query = "INSERT INTO `$table_name` (`id`, `title`, `style`, `animation`) VALUES (NULL, '$title', '$style', '$animation')"; 
		$wpdb->query($query);
		return true;
	}
	function jh_edit_ft($id, $title, $style, $animation){
		global $wpdb;
		$table_name = $wpdb->prefix . "jh_featured"; 

		$query = "UPDATE `$table_name` SET title='$title', style='$style', animation='$animation' WHERE id='$id'"; 			
		$wpdb->query($query);		
		return true;		
	}
	function jh_borrar_ft($id){			
		global $wpdb;
		$table_name = $wpdb->prefix . "jh_posts";
		$table_name2 = $wpdb->prefix . "jh_featured";

		$query = "DELETE FROM `$table_name` WHERE id_destacado='$id'"; 
		$wpdb->query($query);
		$query2 = "DELETE FROM `$table_name2` WHERE id='$id'"; 
		$wpdb->query($query2);
		
		return true;			
	}
	
	/* Posts Jh */
	function jh_getPostsEnDestacado($id) {
		global $wpdb;
		$table = $wpdb->prefix . 'jh_posts';
		$table2 = $wpdb->prefix . 'posts';
		
		$res = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT p.*
				FROM $table jp, $table2 p
				WHERE jp.id_destacado=%d
				AND p.ID=jp.id_post
				ORDER BY orden
				",
				$id
			)
		);
		return $res;
	}
	function jh_anyadirPostDestacado($id_post, $id_destacado) {
		global $wpdb;
		$table = $wpdb->prefix . 'jh_posts';
		
		$res = $wpdb->query(
			$wpdb->prepare(
				"
				INSERT INTO $table
				(id, id_post, id_destacado, orden)
				VALUES ('', %d, %d, 999)
				",
				$id_post,
				$id_destacado
			)
		);
		return $res;
	}
	function jh_eliminarPostDestacado($id_post, $id_destacado) {
		global $wpdb;
		$table = $wpdb->prefix . 'jh_posts';
		
		$res = $wpdb->query(
			$wpdb->prepare(
				"
				DELETE FROM $table
				WHERE id_post=%d
				AND id_destacado=%d
				",
				$id_post,
				$id_destacado
			)
		);
		return $res;
	}
	function jh_reordenarPostDestacado($id_post, $id_destacado, $orden) {
		global $wpdb;
		$table = $wpdb->prefix . 'jh_posts';
		
		$res = $wpdb->query(
			$wpdb->prepare(
				"
				UPDATE $table
				SET orden=%d
				WHERE id_post=%d
				AND id_destacado=%d
				",
				$orden,
				$id_post,
				$id_destacado
			)
		);
		return $res;
	}
	
	
	/* Posts WP */
	function jh_getPostsPosiblesFt($id) {
		global $wpdb;
		$table = $wpdb->prefix . 'posts';
		$table2 = $wpdb->prefix . 'jh_posts';
		
		$res = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT p.*
				FROM $table p
				WHERE p.post_type='post'
				AND p.post_status='publish'
				AND NOT EXISTS (
					SELECT *
					FROM $table2 pf
					WHERE pf.id_post=p.ID
					AND pf.id_destacado=%d
					)
				ORDER BY p.post_date DESC
				LIMIT 0, 10
				",
				$id
			)
		);
		return $res;
	}
	function jh_buscarPostsFt($q, $id_destacado) {
		global $wpdb;
		$table = $wpdb->prefix . 'posts';
		$table2 = $wpdb->prefix . 'jh_posts';
		
		$res = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT p.*
				FROM $table p
				WHERE p.post_title LIKE %s
				AND p.post_type='post'
				AND NOT EXISTS (
					SELECT *
					FROM $table2 pn
					WHERE pn.id_post=p.ID
					AND pn.id_destacado=%d
					)
				ORDER BY p.post_date DESC
				",
				'%'.$q.'%',
				$id_destacado
			)
		);
		return $res;
	}
?>
