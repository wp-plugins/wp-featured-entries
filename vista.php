<?php
/* Pantalla principal del administrador */
function jhfeatured_admin(){
	require_once('modelo.php');
	?>
	<div class="wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
		<h2><?php _e('Featured entries', 'jh-featured'); ?></h2>
		
		<div>
			<h3><?php _e('New featured group', 'jh-featured'); ?></h3>
			<form action="" method="post">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="i-title"><?php _e('Title', 'jh-featured'); ?></label>
						</th>
						<td>
							<input id="i-title" type="text" name="title" required="required" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="i-style"><?php _e('Style', 'jh-featured'); ?></label>
						</th>
						<td>
							<select id="i-style" name="style" required="required">
								<option value="default">Default</option>
							<select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="i-animation"><?php _e('Animation', 'jh-featured'); ?></label>
						</th>
						<td>
							<select id="i-animation" name="animation" required="required">
								<option value="slide">Slide</option>
							<select>
						</td>
					</tr>
				</table>
				
				<p class="submit">
					<input type="submit" name="save-ft" class="button button-primary" value="<?php _e('Save', 'jh-featured'); ?>" />
				</p>
			</form>
		</div>
		
		<div>
			<h3><?php _e('Created featured groups', 'jh-featured'); ?></h3>
			<table class="wp-list-table widefat fixed">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php _e('Title', 'jh-featured'); ?></th>
						<th><?php _e('Style', 'jh-featured'); ?></th>
						<th><?php _e('Animation', 'jh-featured'); ?></th>
						<th>Shortcode</th>
						<th><?php _e('PHP Function', 'jh-featured'); ?></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					if ($fts = jh_get_featured_groups())
					foreach ($fts as $ft) {
					?>
					<tr>
						<td><?php echo $ft->id; ?></td>
						<td><?php echo $ft->title; ?></td>
						<td><?php echo $ft->style ?></td>
						<td><?php echo $ft->animation ?></td>
						<td>[jhfeatured id="<?php echo $ft->id; ?>"]</td>
						<td><?php echo 'jhfeatured_show('.$ft->id.');'; ?></td>
						<td>
							<a href="admin.php?page=jhfeatured-general&view-ft=<?php echo $ft->id; ?>"><?php _e('View entries', 'jh-featured'); ?></a>
						</td>
						<td>
							<a class="a-eliminar" href="admin.php?page=jhfeatured-general&accion=eliminar-g&idFt=<?php echo $ft->id; ?>"><?php _e('Remove', 'jh-featured'); ?></a>
						</td>
					</tr>
					<?php
					}
					wp_enqueue_script('jquery-ui-dialog');
					wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css');
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div style="display: none" id="dialog" title="<?php _e('Confirm', 'jh-featured'); ?>"><?php _e('Are you sure you want to remove this group?', 'jh-featured'); ?></div>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".a-eliminar").click(function(event) {
			event.preventDefault();
			
			var ref = jQuery(this).attr("href");
			jQuery("#dialog").dialog({
				modal: true,
				buttons: {
					<?php _e('OK', 'jh-featured'); ?>: function() {
						window.location.href = ref;
						jQuery(this).dialog("close");
					},
					<?php _e('Cancel', 'jh-featured'); ?>: function() {
						jQuery(this).dialog("close");
					}
				}
			});
		});
	});
	</script>
	
	<p><?php _e('If you like this plugin and find it useful, you can support us by clicking the Donate button', 'jh-featured'); ?></p>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
	">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
	</form>


	
<?php
}

function jhfeatured_view_ft($id){
	require_once('modelo.php');
	
	$ft = jh_get_featured($id);
?>
	<div class="wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
		<h2><?php _e('Entries of the featured group', 'jh-featured'); ?> <?php echo $ft->title; ?></h2>
		
		<div id="ft_contenedor">
			<div id="ft_posts" class="ft_cont_selectable">
				<h3><?php _e('Entries', 'jh-featured'); ?></h3>
				<div class="d-search">
					<input type="text" id="query-s" />
					<button class="button" id="search-posts"><?php _e('Search', 'jh-featured'); ?></button>
				</div>
				<ol class="selectable">
					<?php
					$posts_array = jh_getPostsPosiblesFt($id);
					foreach ($posts_array as $post) {
						?>
						
						<li class="ui-widget-content" data-id="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?> <span class="spandate">(<?php echo date_i18n(get_option('date_format'), strtotime($post->post_date)); ?>)</span></li>
						
						<?php
					}
					
					wp_enqueue_script('jquery-ui-selectable');
					wp_enqueue_script('jquery-ui-sortable');
					wp_register_style('jqueryui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css');
					wp_register_style( 'ft-style', plugins_url('css/style.css', __FILE__) );
					wp_enqueue_style( 'ft-style' );
					wp_enqueue_style( 'jqueryui-style' );
					?>
				</ol>
			</div>
			
			<div id="ft_botones" class="ft_cont_selectable">
				<p>
					<button class="button" id="ft_add"><?php _e('Add', 'jh-featured'); ?> &rarr;</button>
				</p>
				<p>
					<button class="button" id="ft_rmv">&larr; <?php _e('Remove', 'jh-featured'); ?></button>
				</p>
				<div class="limpiar"></div>
				<div class="ajax-container">
					<div class="ajax-loader"></div>
				</div>
			</div>
			
			<div id="ft_destacados" class="ft_cont_selectable">
				<h3><?php _e('Featured', 'jh-featured'); ?></h3>
				<div class="d-search"></div>
				<ol class="selectable">
					<?php
					$posts_ft = jh_getPostsEnDestacado($id);
					foreach ($posts_ft as $post) {
						?>
						
						<li class="ui-widget-content" data-id="<?php echo $post->ID; ?>"><div class='handle'><span class='ui-icon ui-icon-carat-2-n-s'></span></div><?php echo $post->post_title; ?> <span class="spandate">(<?php echo date_i18n(get_option('date_format'), strtotime($post->post_date)); ?>)</span></li>
						
						<?php
					}
					?>
				</ol>
			</div>
			
			<div id="ft_res" class="limpiar"></div>
			
			<div>
				<h3><?php _e('Edit featured group', 'jh-featured'); ?></h3>
				<form action="" method="post">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="i-title"><?php _e('Title', 'jh-featured'); ?></label>
							</th>
							<td>
								<input id="i-title" type="text" name="title" required="required" class="regular-text" value="<?php echo $ft->title; ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="i-style"><?php _e('Style', 'jh-featured'); ?></label>
							</th>
							<td>
								<select id="i-style" name="style" required="required">
									<option value="default"<?php if ($ft->style == 'default') echo ' selected="selected"'; ?>>Default</option>
								<select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="i-animation"><?php _e('Animation', 'jh-featured'); ?></label>
							</th>
							<td>
								<select id="i-animation" name="animation" required="required">
									<option value="slide"<?php if ($ft->animation == 'slide') echo ' selected="selected"'; ?>>Slide</option>
								<select>
							</td>
						</tr>
					</table>
					
					<p class="submit">
						<input type="hidden" name="id" value="<?php echo $id; ?>" />
						<input type="submit" name="edit-ft" class="button button-primary" value="Guardar" />
					</p>
				</form>
			</div>
			
			<script type="text/javascript">
			function cargaJS() {
				jQuery("#ft_destacados ol").sortable(
					{ 
						handle: ".handle" ,
						stop: function() {
							jQuery(".ajax-loader").addClass("visible");
							
							var affected = jQuery("#ft_destacados ol li");
							var datosajax = new Array();
							affected.each(function(i) {
								datosajax[i] = jQuery(this).attr("data-id");
							});
							
							var data = {
								data: datosajax,
								id: '<?php echo $id; ?>',
								action: 'reordenar_ft'
							};
							
							jQuery.post(ajaxurl, data, function() { 
								jQuery(".ajax-loader").removeClass("visible");
							});
						}
					})
				jQuery( ".selectable" ).selectable();
			}
			
			jQuery(document).ready(function() {
				cargaJS();
				
				jQuery("#ft_add").click(function(event) {
					event.preventDefault();
					
					jQuery(".ajax-loader").addClass("visible");
					var move = jQuery("#ft_posts ol li.ui-selected");
					
					var datosajax = new Array();
					move.each(function(i) {
						datosajax[i] = jQuery(this).attr("data-id");
					});
					
					var data = {
						data: datosajax,
						id: '<?php echo $id; ?>',
						action: 'addpost_ft'
					};
					
					jQuery.post(ajaxurl, data, function() {
						jQuery(".ajax-loader").removeClass("visible"); 
						move.prepend( "<div class='handle'><span class='ui-icon ui-icon-carat-2-n-s'></span></div>" );
						jQuery("#ft_destacados ol").append(move);
						jQuery(".selectable li").removeClass("ui-selected");
						cargaJS();
					});
				});
				
				jQuery("#ft_rmv").click(function(event) {
					event.preventDefault();
					
					jQuery(".ajax-loader").addClass("visible");
					var move = jQuery("#ft_destacados ol li.ui-selected");
					
					var datosajax = new Array();
					move.each(function(i) {
						datosajax[i] = jQuery(this).attr("data-id");
					});
					
					var data = {
						data: datosajax,
						id: '<?php echo $id; ?>',
						action: 'rmpost_ft'
					};
					
					jQuery.post(ajaxurl, data, function() {
						jQuery(".ajax-loader").removeClass("visible"); 
						move.find(".handle").remove();
						jQuery("#ft_posts ol").append(move);
						jQuery(".selectable li").removeClass("ui-selected");
						move.find(".ft-right").remove();
						cargaJS();
					});
				});
				
				jQuery("#search-posts").click(function(event) {
					event.preventDefault();
					
					Buscar();
				});
				
				jQuery("#query-s").keypress(function(event) {
					if (event.which == 13) {
						Buscar();
					}
				});
				
				function Buscar() {
					var query = jQuery("#query-s").val();
					
					if (query != '') {
						jQuery(".ajax-loader").addClass("visible");
						
						var data = {
							data: query,
							id: '<?php echo $id; ?>',
							action: 'search_ft'
						};
						
						jQuery.post(ajaxurl, data, function(data, response) {
							if (data != '') {
								jQuery("#ft_posts ol").html('');
								var obj = jQuery.parseJSON(data);
								
								for (var i = 0; i < obj.length; i++) {
									jQuery("#ft_posts ol").append("<li class='ui-widget-content' data-id='"+obj[i].id+"'>"+obj[i].title+" <span class='spandate'>("+obj[i].date+")</span></li>");
								}
							}
							
							jQuery(".ajax-loader").removeClass("visible"); 
						});
					}
					else {
						jQuery(".ajax-loader").addClass("visible");
						var data = {id: '<?php echo $id; ?>', action: 'ultimos_ft'}
						jQuery.post(ajaxurl, data, function(data, response) {
							var obj = jQuery.parseJSON(data);
							
							jQuery("#ft_posts ol").html('');
							for (var i = 0; i < obj.length; i++)
								jQuery("#ft_posts ol").append('<li class="ui-widget-content" data-id="'+obj[i].id+'">'+obj[i].title+' <span class="spandate">('+obj[i].date+')</span></li>');
							
							jQuery(".ajax-loader").removeClass("visible");
						});
					}
					
					cargaJS();
				}
			});
			</script>
		</div>
	</div>
<?php
}

/* *
 * Ajax
 * */
require_once('modelo.php');

add_action('wp_ajax_search_ft', 'search_ft_callback');
function search_ft_callback() {
	global $wpdb;
	$q = $_POST['data'];
	$id = $_POST['id'];
	
	$res = array();
	
	$posts = jh_buscarPostsFt($q, $id);
	foreach ($posts as $post) {
		$res[] = array(
			"id"=>$post->ID,
			"title"=>$post->post_title,
			"date"=>date_i18n(get_option('date_format'), strtotime($post->post_date))
		);
	}
	echo json_encode($res);

	die(); // this is required to return a proper result
}

add_action('wp_ajax_ultimos_ft', 'ultimos_ft_callback');
function ultimos_ft_callback() {
	global $wpdb;
	$id = $_POST['id'];
	
	$res = array();
	$posts = jh_getPostsPosiblesFt($id);
	foreach ($posts as $post) {
		$res[] = array(
			"id"=>$post->ID,
			"title"=>$post->post_title,
			"date"=>date_i18n(get_option('date_format'), strtotime($post->post_date))
		);
	}
	echo json_encode($res);

	die(); // this is required to return a proper result
}

add_action('wp_ajax_addpost_ft', 'addpost_ft_callback');
function addpost_ft_callback() {
	global $wpdb;
	$id = $_POST['id'];
	
	foreach ($_POST['data'] as $key=>$value) {
		jh_anyadirPostDestacado($value, $id);
	}

	die(); // this is required to return a proper result
}

add_action('wp_ajax_rmpost_ft', 'rmpost_ft_callback');
function rmpost_ft_callback() {
	global $wpdb;
	$id = $_POST['id'];
	
	foreach ($_POST['data'] as $key=>$value) {
		jh_eliminarPostDestacado($value, $id);
	}

	die(); // this is required to return a proper result
}

add_action('wp_ajax_reordenar_ft', 'reordenar_ft_callback');
function reordenar_ft_callback() {
	global $wpdb;
	$id = $_POST['id'];
	
	$orden = 1;
	foreach ($_POST['data'] as $key=>$value) {
		jh_reordenarPostDestacado($value, $id, $orden);
		$orden++;
	}

	die(); // this is required to return a proper result
}
?>
