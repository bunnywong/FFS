<?php
/**
 * The Default Woocommerce Template for Optimizer
 *
 * Displays the Woocommerce pages.
 *
 * @package Optimizer
 * 
 * @since Optimizer 1.0
 */


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

global $optimizer;
$enableSidebar = is_active_sidebar( 'woopage_sidebar' ) && !is_singular('product');

?>

<?php get_header(); ?>

<div class="page_wrap layer_wrapper woopage">   
    <div id="content">
        <?php if (!is_product_category()) { ?>
        <div class="center">            
            <div class="layerbread"><?php woocommerce_breadcrumb(); ?></div>
        </div>
        <?php } ?>
        <div class="center  clearfix">
            <!--SIDEBAR START--> 
            <?php if ($enableSidebar) : ?>
            <div id="sidebar" class="woopage_sidebar">
                <div class="widgets">  
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Woo Page Widgets', 'optimizer')) ) : ?><?php endif; ?>
                 </div>
            </div>
            <?php endif; ?>
            <!--SIDEBAR END-->
            <div class="single_wrap <?php echo $enableSidebar ? '' : 'no-sidebar'?>">
                <div class="single_post">
                     <?php if(!is_singular()) { ?>
                    <!--CUSTOM PAGE HEADER STARTS-->
                        <?php get_template_part('framework/core','pageheader'); ?>
                    <!--CUSTOM PAGE HEADER ENDS-->
                    <?php } ?>
                    <?php woocommerce_content(); ?>
                </div>
            </div>
            <!--PAGE END-->
        </div>
    </div>
</div>
<!--layer_wrapper class END-->

<?php get_footer(); ?>