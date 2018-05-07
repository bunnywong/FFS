<?php 
/**
 * The Footer for Optimizer
 *
 * Displays the footer area of the template.
 *
 * @package Optimizer
 * 
 * @since Optimizer 1.0
 */
global $optimizer;?>

	<?php /*To Top Button */?>
	<a class="to_top <?php if (empty ($optimizer['totop_id'])) { ?>hide_totop<?php } ?>"><i class="fa-angle-up fa-2x"></i></a>



<!--Footer Start-->
<div class="footer_wrap layer_wrapper <?php if(!empty($optimizer['hide_mob_footwdgt'])){ echo 'mobile_hide_footer';} ?>">
<?php 
$footerClass = !empty ($optimizer['copyright_center']) ? 'footer_center' : '';

if(!is_active_sidebar( 'foot_sidebar' ))
{
    $footerClass .= ' no-sidebar';
}

?>
<div id="footer" class="<?php echo $footerClass?>">
    <div class="center">
    <?php if ( is_active_sidebar( 'foot_sidebar' ) ) { ?>
        <!--Footer Widgets START-->
        <div class="widgets">
        	<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Footer Widgets', 'optimizer')) ) : ?><?php endif; ?>
        	</ul>
        </div>
        <!--Footer Widgets END-->
	<?php } ?>
        
    </div>
    <?php 
    /*
        <!--Copyright Footer START-->
            <div id="copyright" class="soc_right<?php if (!empty ($optimizer['copyright_center'])) { ?> copyright_center<?php } ?>">
                <div class="center">
                    <!--Site Copyright Text START-->
                	<div class="copytext"><?php if (!empty ($optimizer['footer_text_id'])) { ?><?php $foot = html_entity_decode($optimizer['footer_text_id']); $foot = stripslashes($foot); echo do_shortcode($foot); ?><?php } ?></div>
        					<!--<div class="copytext"><?php //printf( __( 'Theme by %s', 'optimizer' ), '<a target="_blank" href="https://optimizerwp.com/">Layerthemes</a>' ); ?></div>-->

                    <!--Site Copyright Text END-->
               
               
                
                </div><!--Center END-->

            </div>
        <!--Copyright Footer END-->
    */
     ?>
</div>
<!--Footer END-->



    
</div><!--layer_wrapper class END-->


<?php wp_footer(); ?>
<script type="text/javascript">
(function($){
	$(document).ready(function(){

	    jQuery(".sidr-class-pll-parent-menu-item > a *").click(function(event){
	    	event.preventDefault();
	    	event.stopPropagation();
	    	jQuery(this).parent().parent().find('ul').toggle()
	    });
	});

	$("#menu-site-navigation-menu").find('li').hover(function(){
        var subMenu = $(this).children('ul');
        if(subMenu.length == 1)
        {
            var hoverMenuWidth = subMenu.width();
    		var currentWidth = $(this).width();
            if(hoverMenuWidth > currentWidth)
    		{
    			var offset = ((hoverMenuWidth - currentWidth) / 2) * -1;
    			subMenu.css('margin-left', offset + 'px');
    		}
        }
	});





})(jQuery);
</script>
<script>
(function($){
$(document).ready(function(event){
/*$(".single_post .images .thumbnails > a:first-child").trigger("click");*/
$('.woocommerce-breadcrumb').text($('.woocommerce-breadcrumb').text().replace('>  >',' > '));
var totalPoints = 0;
$('.shop_table').each(function(){
  $(this).find('tr .quantity input.qty').each(function(){
    totalPoints += parseInt($(this).val()); //<==== a catch  in here !! read below
  });
});
// console.log(totalPoints);
 $(".topmenu span.cart-contents-count").text(totalPoints);
 
 //when update button is click 
$(document).on("click", ".shop_table input[name='update_cart']", function(){
	var totalPoints = 0;
	$('.shop_table').each(function(){
		$(this).find('tr .quantity input.qty').each(function(){
		totalPoints += parseInt($(this).val()); //<==== a catch  in here !! read below
		});
	});
	$("a.cart-contents .cart-contents-count").text(totalPoints);
})

$(document).on("click", ".shop_table td.product-remove a", function(){
	var totalPoints = 0;
	$('.shop_table').each(function(){
	$(this).find('tr .quantity input.qty').each(function(){
		totalPoints += parseInt($(this).val()); //<==== a catch  in here !! read below
	  });
	});
	totalPoints = totalPoints - parseInt($(this).parent().parent().find(".quantity input.qty").val());
	$("a.cart-contents .cart-contents-count").text(totalPoints);
});
});

var WW =  $(window).width();


if(WW < 960){
$('ul.product-categories').each(function() {

	var $select = $('<select />');
	$select.addClass("product-categories");

	$(this).find('a').each(function() {
		var $option = $('<option />');
		$option.attr('value', $(this).attr('href')).html($(this).html());
		$select.append($option);
	});

	$(this).replaceWith($select);
});
}

$(document).ready(function() {
  $("select.product-categories").change(function(){
    if ($(this).val()!='') {
		console.log($(this).val());
      window.location.href=$(this).val();
    }
  });
});

/*
$(document).ready(function(e){
	$(".menu-header ul li.menu-item-object-woocs ul li").each(function(){
	var dacur = $(this).find("a").attr("data-currency");
	console.log("data-cur"+dacur);
	$(this).find("a").attr("href","?&currency="+dacur);
	});
	
	
});	*/

})(jQuery);


</script>

</body>
</html>



