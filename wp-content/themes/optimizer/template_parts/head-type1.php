<?php 
/**
 * Header type 1 for Optimizer
 *
 * Displays The Header type 1. This file is imported in header.php
 *
 * @package Optimizer
 * 
 * @since Optimizer 1.0
 */
global $optimizer;?>

<!--HEADER STARTS-->
    <div class="header">

        <div class="center">
            <div class="head_inner">
            <!--LOGO START-->
                <div class="logo">
                    <?php if(!empty($optimizer['logo_image_id']['url'])){   ?>
                        <a class="logoimga" title="<?php bloginfo('name') ;?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php $logo = $optimizer['logo_image_id']; echo $logo['url']; ?>" /></a>                       
                    <?php }else{ ?>
                            <?php if ( is_home() ) { ?>   
                            <h1><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h1>                           
                            <?php }else{ ?>
                            <h2><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h2>                          
                            <?php } ?>
                    
                    <?php } ?>
                </div>
            <!--LOGO END-->
            
            <!--MENU START--> 
                <!--MOBILE MENU START-->
              <!--  <a id="simple-menu" href="#sidr"><i class="fa-bars"></i></a>-->
                <!--MOBILE MENU END-->                
                <div id="topmenu" class="<?php if ('header' == $optimizer['social_bookmark_pos'] ) { ?> has_bookmark<?php } ?>">
                    <div class="">
                    <?php if ( is_active_sidebar( 'head_sidebar' ) ) { ?>
                        <!--header Widgets START-->
                        <div class="widgets">
                        	<ul>
                				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Header Widgets', 'optimizer')) ) : ?><?php endif; ?>
                        	</ul>
                        </div>
                        <!--header Widgets END-->
                	<?php } ?>
                        
                    </div>
                    <div class="desc">
                    <?php echo bloginfo('description'); ?>
                    </div>
<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php
    }
        ?></a>
 
<?php } ?>
                <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'is_header_menu' => true ) ); ?>
 
                <!--LOAD THE HEADR SOCIAL LINKS-->
					<div class="head_soc">
						<?php if ($optimizer['social_bookmark_pos'] == 'header') { ?><?php get_template_part('framework/core','social'); ?><?php } ?>
                    </div>
                </div>
            <!--MENU END-->
            
            </div>
    </div>
    </div>
<!--HEADER ENDS-->