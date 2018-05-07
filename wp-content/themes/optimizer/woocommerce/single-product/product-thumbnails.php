<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     2.6.3
 */

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

$variations = get_class($product) == 'WC_Product_Variable' ? $product->get_available_variations() : array();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 5 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop === 0 || $loop % $columns === 0 ) {
				$classes[] = 'first';
			}

			if ( ( $loop + 1 ) % $columns === 0 ) {
				$classes[] = 'last';
			}

			$image_class = implode( ' ', $classes );
			$props       = wc_get_product_attachment_props( $attachment_id, $post );
			//var_dump($props);
			if ( ! $props['url'] ) {
				continue;
			}
			
			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $image_class ),
					esc_attr( $props['caption'] ),
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
				),
				$attachment_id,
				$post->ID,
				esc_attr( $image_class )
			);

			$loop++;
		}
	?></div>
	<script type="text/javascript">
    function sortNumber(a,b) {
        return a - b;
    }
    
    function getLargestImageFromSrcset(srcset)
    {
    	var srcArray = srcset.split(',');
    	
    	var widths = []; 
    	var imageSet = {};
    	
    	for(var i = 0; i < srcArray.length; i++)
    	{
    		var raw = srcArray[i].trim();
    		var rx = /(.*)\s(\d+)w$/gi;
    		var parts = rx.exec(raw);
    		var key = '_' + parts[2];
    		imageSet[key] = parts[1]; 
    		
    		widths.push(parseInt(parts[2]));
    	}
    	
    	widths.sort(sortNumber);
    	var largestKey = '_' + widths[widths.length - 1];
    	return imageSet[largestKey];
    }

	

    jQuery(".thumbnails").on("click", "a", function(event){
    	event.preventDefault();
    	event.stopPropagation();
    	var srcset = jQuery(this).find("img").attr('srcset');
        var src = getLargestImageFromSrcset(srcset);
    	jQuery('.single-product-main-image img').attr("src", src).attr('srcset', srcset).trigger("customChange");
    });
    
	
    jQuery(".thumbnails").on("click", "img", function(event){
    	event.preventDefault();
    	event.stopPropagation();
    	var srcset = jQuery(this).attr('srcset');
        var src = getLargestImageFromSrcset(srcset);
        jQuery('.single-product-main-image img').attr("src", src).attr('srcset', srcset).trigger("customChange");
    });
    </script>
	<?php
}
