<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$current = max( 1, get_query_var( 'paged' ) );

?>
<nav class="customized-woocommerce-pagination">
	<?php
		$links = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => false,
			'current'      => $current,
			'total'        => $wp_query->max_num_pages,
			'prev_text'    =>  __( 'PREV', 'optimizer-custom' ),
			'next_text'    =>  __( 'NEXT', 'optimizer-custom' ),
			'type'         => 'array',
			'end_size'     => 3,
			'mid_size'     => 3
		) ) );
		
		if($current != 1)
		{
		    $firstURL = esc_url_raw(remove_query_arg( 'add-to-cart', get_pagenum_link( 1, false ) ) );
		    $firstLink = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $lastLink ) ) . "'>" . __( 'FIRST', 'optimizer-custom' ) . "</a>"; 
		    array_unshift($links, $firstLink);
		}
		
		if($current != $wp_query->max_num_pages)
		{
		    $lastURL = esc_url_raw(remove_query_arg( 'add-to-cart', get_pagenum_link( $wp_query->max_num_pages, false ) ) );
		    $lastLink = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $lastURL ) ) . "'>" . __( 'LAST', 'optimizer-custom' ) . "</a>";
    		$links[] = $lastLink;
		}
    		
		$r = "<ul class='page-numbers'>\n\t<li>";
		$r .= join("</li>\n\t<li>", $links);
		$r .= "</li>\n</ul>\n";
		
		echo $r;
	?>
</nav>
