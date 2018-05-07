<?php
/**
 * Template Name: About us-2
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
global $optimizer;?>
<?php get_header(); ?>
<style>
html, body {
    background: url(/wp-content/uploads/2016/12/aboutus-background-image.jpg) top center no-repeat;
        background-size: auto auto;
    background-size: cover;
}
.header {
	background-color: #fff !important;
}
.siteorigin-widget-tinymce
{
	padding: 22px;
}
.panel-widget-style > .textwidget
{
	padding-left: 12px;
}
</style>

    <div class="page_centerpage_wrap layer_wrapper clearfix">
    <div id="content">
        <div class="">
            <div class="single_wrap no_sidebar">
                <div class="single_post">
					  <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                      <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">  
                      
                        <!--EDIT BUTTON START-->
                            <?php if ( is_user_logged_in() && is_admin() ) { ?>
                                    <div class="edit_wrap">
                            			<a href="<?php echo get_edit_post_link(); ?>">
                            				<?php _e('Edit','optimizer'); ?>
                                		</a>
                            		</div>
                            <?php } ?>
                        <!--EDIT BUTTON END-->
                        
                        <!--PAGE CONTENT START--> 
                        <div class="single_post_content">

                                <!--THE CONTENT START-->
                                    <div class="thn_post_wrap clearfix">
                                        <?php the_content(); ?>
                                    </div>
                                        <div style="clear:both"></div>
                                    <div class="thn_post_wrap wp_link_pages">
                                        <?php wp_link_pages('<p class="pages"><strong>'.__('Pages:', 'optimizer').'</strong> ', '</p>', 'number'); ?>
                                    </div>
                                <!--THE CONTENT END-->
                        </div>
                        <!--PAGE CONTENT END-->                       
                  </div>
                  <?php endwhile ?> 
                  </div><!--single_post class END-->
                      
                  <!--COMMENT START: Calling the Comment Section. If you want to hide comments from your posts, remove the line below-->     
                  <?php if (!empty ($optimizer['post_comments_id'])) { ?>
                      <div class="comments_template">
                          <?php comments_template('',true); ?>
                      </div>
                  <?php }?> 
                  <!--COMMENT END-->
                  
              <?php endif ?>
            
              </div><!--single_wrap class END-->
           
            
            </div>
        </div>
   </div><!--layer_wrapper class END-->
<?php get_footer(); ?>