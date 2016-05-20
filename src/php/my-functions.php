<?php 
/** 
 * List of usefull ready-to-use functions
 * for a wordpress site that may help any developer.
 *
 * @since 1.0
 * @author Diego Martin Marmol <http://diegomarmol.com.ar>
 * @license opensource.org/licenses/MIT
 */



/** @var Path to your 'css' assets folder */
define('CSSPATH',	'src/css/');
/** @var Path to your 'js' assets folder */
define('JSPATH', 	'src/js/');
/** @var Path to your 'images' assets folder */
define('IMGPATH', 	'src/images/');
/** @var Path to your 'templates' folder */
define('TPLPATH', 	'template/');
/** @var Path to your 'post-format' type folder */
define('TYPEPATH',	'post-format/');



/**
 * Destruye el procesamiento del codigo e imprime un array/string
 * Kills the page loading process and print an array|string
 *
 * @author Diego Martin Marmol
 * @param array|string $data Ussually an array, sometimes a string
 * @param string $where place a flag where you call the test() function
 * @param boold $dontDie tell if you want to kill the loading process or not
 * @return mixed
 */
if ( !function_exists('test') ) {
	function test($data, $where='', $dontDie=false) {
		if( is_array($data) || is_object($data) ) {
	        echo '<pre>';
	        print_r($data);
	        echo '</pre>';			
		} else {
			echo $data;
		}
		echo '<hr/>';
		echo ($where!='') ? $where : 'Preguntá por: "<strong>test()</strong>"';
		if ( !$dontDie ) {
	        die();
		}
	}
}



/**
 * Obtiene la ruta hacia la carpeta con los css
 *
 * @author Diego Martin Marmol
 * @param bool $return (Imprime la ruta si es TRUE. Devuelve la ruta si es FALSE o vacio)
 * @return mixed
 */
if ( !function_exists('get_css_dir') ) {
	function get_css_dir($return=false) {
		$url = get_template_directory_uri();
		$url .= '/';
		$url .= CSSPATH;
		if (!$return) { return $url; }
		else { echo $url; }
	}
}



/**
 * Obtiene la ruta hacia la carpeta con los css
 * @author Diego Martin Marmol
 * @param bool $return (Imprime la ruta si es TRUE. Devuelve la ruta si es FALSE o vacio)
 * @return mixed
 */
if ( !function_exists('get_js_dir') ) {
	function get_js_dir($return=false) {
		$url = get_template_directory_uri();
		$url .= '/';
		$url .= JSPATH;
		if (!$return) { return $url; }
		else { echo $url; }
	}
}



/**
 * Obtiene la ruta hacia la carpeta con las imagenes
 * @author Diego Martin Marmol
 * @param bool $return (Imprime la ruta si es TRUE. Devuelve la ruta si es FALSE o vacio)
 * @return mixed
 */
if ( !function_exists('get_img_dir') ) {
	function get_img_dir($return=false) {
		$url = get_template_directory_uri();
		$url .= '/';
		$url .= IMGPATH;
		if (!$return) { return $url; }
		else { echo $url; }
	}
}



/**
 * Localiza y devuelve un template ubicado dentro de la carpeta 'template/'
 * @author Diego Martin Marmol
 * @param bool $return (Devuelve la ruta si es TRUE. Almacena la ruta si es FALSE o vacio)
 * @return mixed
 */
/*
if ( !function_exists('get_tpl') ) {
	function get_tpl($template_file, $data=array()) {
		$template = TPLPATH . $template_file . '.php';
		return $template;		
	}
}
*/
if ( !function_exists('get_tpl') ) {
	function get_tpl($template_file, $settings=array(), $wp_query='wp_query') {
		global ${$wp_query};
		// test($query);

		// Find the template
		$template = TPLPATH . $template_file . '.php';
		// test($template);

		// The settings
		$s = my_loop_config( $settings );
		extract( $s );

		// Include template
		include( locate_template( $template ) );
	}
}
if (!function_exists('my_loop_config')) {
	function my_loop_config($settings=null) {
		// test( $settings == null );
		if ( $settings == null ) {
			$settings = array(
				'post_cols' => 'c12-12 cols', 		// Ancho total del post
				'post_image_size' => 'c3-12', 		// Ancho total de la imagen del post
				'post_link_size' => 'c9-12 cols', 	// Ancho total del contenido del post
				'show_tags' => true, 				// Si/No muestra los tags
				'max_excerpt' => 35, 				// Maximo de palabras para las bajadas
			);
			// Clase del post
			$settings['post_class'] = 'post-single';
			if ( is_search() || is_archive() ) {
				$settings['post_class'] = 'post-wide'; 		
			}
		}
		return $settings;
	}
}
/*
 * Localiza y devuelve un template segun el tipo de post (post_type)
 * ubicado dentro de la carpeta 'post-type/'
 *
 * @author Diego Martin Marmol
 * @param bool $return (Devuelve la ruta si es TRUE. Almacena la ruta si es FALSE o vacio)
 * @return mixed
 */
if ( !function_exists('get_tpl_type') ) {
	function get_tpl_type($template_file, $data=array()) {
		$template = TYPEPATH . 'post-'. $template_file .'.php';
		// test($template);
		return $template;
	}
}

/*
 * Devuelve el valor si no esta vacio
 *
 * @author Diego Martin Marmol
 * @param mixed
 * @return mixed
 */
if ( !function_exists('isNotEmpty') ) {
	function isNotEmpty($element) {
		if ( !empty($element) ) {
			return $element;
		}
	}
}


 
/*
 * Busqueda de post personalizada
 *
 * @author Diego Martin Marmol
 * @param mixed
 * @return mixed
 */
function search_posts( $query ) {
    // No afecte a los queries de Admin
    if( $query->is_admin == 1 ) {
    	die('is_admin');
        return;
    }
    // Si no es el query principal
    if( !$query->is_main_query() ) {
    	// die('is_main_query');
        return;
    }
    // No parar si no estamos en una pagina de archivo de taxonomias
    if( $query->is_tax == 1 ) {
    	die('is_tax');
        return;
    }

    if ( is_search() ) {
    	// echo 'is_search'.'<br>';

	    $s = get_query_var('s');
	    // test( $s );
	    // Mostramos solo 8 resultados
	    // $query->set( 'posts_per_page', 8 );

	    $tax_query = array(
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array( $s ),
			),
			array(
				'taxonomy' => 'tag',
				'field' => 'slug',
				'terms' => array( $s ),
			),
		);
	    $query->set( 'name', $s );
	    $query->set( 'tax_query', $tax_query );
    }
}
// Cambiamos el query con pre_get_posts
// add_action( 'pre_get_posts', 'search_posts' );
       
    
 



/*
 * Carga de estilos (CSS) y scripts (JS) propios
 */
function my_loadStyles() {
	/**
	 * CSS files
	 */
	wp_enqueue_style( 'wanchope', get_css_dir().'wanchope.css' ); // Wanchope styles
    // wp_enqueue_style('app', get_css_dir() . 'app.css', array(), '1.0');
    // wp_enqueue_style('cq', get_css_dir() . 'cq.css', array(), '1.0');    
    // Admin Dashicons
    // wp_enqueue_style( 'dashicons' );     

    /**
     * javascript files
     */
	// wp_enqueue_script('navigation', get_js_dir() . 'navigation.js', array('jQuery'), '0.0.1', TRUE);
    // wp_enqueue_style('app'); // Enqueue it!
	// wp_enqueue_script('jQuery', get_js_dir() . 'jquery.min.js', array(), '1.11.2', TRUE);
    // wp_enqueue_script('jQuery'); // Enqueue it!

	/* swipe.js */
    // wp_enqueue_style('swipe', get_js_dir() . 'plugins/swipejs/swipe.css', array(), '2.0.0');
	// wp_enqueue_script('swipe', get_js_dir() . 'plugins/swipejs/swipe.js', array(), '2.0.0', TRUE);
}
add_action('wp_enqueue_scripts', 'my_loadStyles'); // Add Theme Scripts




/*
 * admin()
 *
 * Funcion propia del theme para chequear si el usuario es un administrador
 *
 * @author Diego Martin Marmol
 * @param none
 * @return bool
 * @version 1.0
 */
if ( !function_exists('admin') ) {
	function admin() {
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		} else {
			return false;
		}
	}	
}


/*
 * back_button()
 *
 * Genera un boton para volver hacia atras
 *
 * @author Diego Martin Marmol
 * @param none
 * @return 'string'
 * @version 1.0
 */
if ( !function_exists('back_button') ) {
	function back_button($text='Volver', $args=array('') ) {
		$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
		$class = 'post-back-button button';

		$output = '<a ';
		$output .= 'href="'.$url.'" ';
		$output .= 'class="'.$class.'" ';
		// foreach ($args as $attr => $value) {
		// 	$output .= $attr.'="'.$value.'"';			
		// 	$output .= ' ';			
		// }
		$output .= '>';
		$output .= $text;
		$output .= '</a>';
  		echo $output;
	}	
}



/*
 * my_post_format()
 *
 * Devuelve el formato del post dentro del loop
 *
 * @author Diego Martin Marmol
 * @param none
 * @return 'string'
 * @version 1.0
 */
if ( !function_exists('my_post_format') ) {
	function my_post_format($postID='') {
		// Formato: standard, gallery, video, status, etc.
		$post_format = '';
		if ( !empty($postID) ) { 
			$post_format = get_post_format($postID);			
		} else {
			$post_format = get_post_format();
		}
		$post_format = ($post_format === false) ? 'standard' : $post_format;
		return $post_format;
	}	
}


/*
 * my_excerpt()
 *
 * Funcion propia del theme para personalizar "the_excerpt()"
 *
 * @author Diego Martin Marmol
 * @param $limit | Limite de palabras dentro del "excerpt"
 * @param $separator | Caracteres ubicados al final del string
 * @return 'string'
 */
function my_excerpt($limit = 13, $separator = '...') {
	$excerpt = get_the_excerpt();
	// test($excerpt);
	$newexcerpt = wp_trim_words( $excerpt, $limit, $separator );
    return $newexcerpt;
}

/*
 * my_title()
 *
 * Funcion propia del theme para personalizar "the_title()"
 *
 * @author Diego Martin Marmol
 * @param $limit | Limite de palabras dentro del "title"
 * @param $separator | Caracteres ubicados al final del string
 * @return 'string'
 */
function my_title($limit = 10, $separator = '...') {
	$title = wp_trim_words( get_the_title(), $limit, $separator );
    return $title;
}


/*
 * my_content()
 *
 * Funcion propia del theme para personalizar "the_content()"
 *
 * @author Diego Martin Marmol
 * @param $post | STD Class Object
 * @return 'string'
 * @since 0.8.1
 */
function my_content($post) {
	$content = $post->post_content;
    return $content;
}


/*
 * my_slug()
 *
 * Convierte cualquier 'string' en un 'slug' separado por guiones
 * 
 * @author Diego Martin marmol
 * @params $text | string
 * @params $separator | string
 * @return 'string'
 */
function my_slug($text, $separator='-') {
	// replace non letter or digits by -
	$text = preg_replace('~[^\\pL\d]+~u', $separator, $text);
	// trim
	$text = trim($text, $separator);
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// lowercase
	$text = strtolower($text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	if (empty($text)) {
		return 'n-a';
	}
	return $text;
}


/*
 * my_tags()
 *
 * @author Diego Martin Marmol
 * @params $post_tags | STD Class Object
 * @return html 'string';
 */
function my_tags($post_tags, $post_tags_max = 5, $as_link=false) {
	$tag_list_class = 'tags';
	$tag_item_class = 'tag';
	$tag_item_link_class = 'tag-link';
	$output = '';
	// test($post_tags);
	if ( $post_tags ) { 
		$t=0;
		$output .= '<ul class="'.$tag_list_class.' list list-horizontal">';
			foreach ($post_tags as $tag) { 
				$t++;
				if ( $t <= $post_tags_max ) {
					$output .= '<li class="'.$tag_item_class.' item">';
					if ( $as_link ) {
						$output .= '<a class="'.$$tag_item_link_class.'" href="'.get_tag_link($tag->term_id).'">';
					}
					$output .= $tag->name;						
					if ( $as_link ) {
						$output .= '</a>';
					}
					$output .= '</li>';
				} // endif
			} // endforeach
		$output .= '</ul>';
	} // endif tags
	return $output;
}


/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/
/* 
 * my_post_class()
 *
 * Agrega a "post_class()" la clase "element"
 * @param array | $class | Lista de clases a sumar
 * @since 0.8.8
 */
function my_post_class( $classes = '' ) {
	/*
	 * 'element' se refiere a cualquier elemento 
	 * (post, opinion, pagina, categoria) del sitio
	 */
	$classes[] = 'element'; 
	return $classes;
}
add_filter( 'post_class', 'my_post_class' );






/*
 * Paginador personalizado
 */
// add_action('init', 'my_pagination');



// Muestra la barra de admin en front end
if (is_user_logged_in()) {
    show_admin_bar(true);
}