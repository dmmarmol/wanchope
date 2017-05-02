<?php // ==== NAVIGATION ==== //

if (!function_exists('render_sandwich')) {
	function render_sandwich($message="") {
		$html = '<span class="sr-only">'.__($message, 'wanchope').'</span>';
		$html .= '<span class="icon-bar"></span>';
		$html .= '<span class="icon-bar"></span>';
		$html .= '<span class="icon-bar"></span>';

		return $html;
	}
}

if (!function_exists('render_collapse_button')) {
	function render_collapse_button($menu_slug, $settings=[]) {
		// $settings['show_brand'] = $settings['show_brand'] || false;

		$html .= '<div class="navbar-header">';
		$html .= '<button type="button"';
		$html .= 'class="navbar-toggle collapsed"';
		$html .= 'data-toggle="collapse"';
		$html .= 'data-target="#'.$menu_slug.'-navbar-collapse"';
		$html .= 'aria-expanded="false">';
		$html .= render_sandwich('Toggle Menu');
		$html .= '</button>';
		// if ($settings['show_brand']) {
			// $html .= '<a class="navbar-brand" href="#">'.SITE_NAME.'</a>';
		// }
		$html .= '</div>';

	    return $html;
	}
}

if (!function_exists('render_menu')) {
	function render_menu($menu_slug) {
		if (empty($menu_slug)) trigger_error('You need to specify a menu id', E_USER_WARNING);

	    $count = 0;
	    $submenu = false;
	    $html = '';

	    $html .= render_collapse_button($menu_slug);

	    $html .= '<div class="collapse navbar-collapse" id="'.$menu_slug.'-navbar-collapse">';
		$html .= '<ul class="nav navbar-nav">';

		// wp_nav_menu( array( 'theme_location' => 'header', 'menu_id' => 'menu-header', 'menu_class' => 'menu-inline' ) );
		$items = wp_get_nav_menu_items($menu_slug, array( 'order' => 'DESC' ));
		foreach ($items as $item):

			// item does not have a parent so menu_item_parent equals 0 (false)
			if (!$item->menu_item_parent):
				// save this id for later comparison with sub-menu items
				$parent_id = $item->ID;
			endif;

			$item_has_parent = $parent_id == $item->menu_item_parent;

			$item_primary_class = array(
				'post-'.$item->ID,
				(($item_has_parent) ? 'dropdown' : ''),
			);

			$html .= '<li class="'.implode(' ', $item_primary_class).'">';
			$html .= '<a href="'.$item->url.'"';
			if ($item_has_parent):
				$html .= 'class="dropdown-toggle"';
				$html .= 'data-toggle="dropdown"';
				$html .= 'role="button"';
				$html .= 'aria-haspopup="true"';
				$html .= 'aria-expanded="false"';
				// $html .= 'onClick="toggleDropdown(this);"';
			endif;
			$html .= '">'; // close the </a>
			$html .= $item->title;
			$html .= ($item_has_parent) ? '<span class="caret">' : '';
			$html .= '</a>';

				// If the item has parent
				if ($item_has_parent):

					if ( !$submenu ):
						$submenu = true;
		            	$html .= '<ul class="sub-menu dropdown-menu">';
		            endif;

			            // Build the nested <li>
			            $html .= '<li class="item">';
						$html .= '<a href="'.$item->url.'" class="title">'.$item->title.'</a>';
		                $html .= '</li>';

	                if ( $items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ):
			            $html .= '</ul>';
		            	$submenu = false;
		            endif;
				endif;

			$html .= '</li>';
			$count++;
		endforeach;

		$html .= '</ul>'; // navbar-collapse
		$html .= '</div>'; // navbar-nav

		return $html;
	}
}
?>
