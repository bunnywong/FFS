<?php
/*
Template Name: Page with Left Sidebar
*/
?>
<?php global $optimizer;?>
<?php get_header(); ?>

    <div class="page_leftsidebar_wrap layer_wrapper">
        <div id="content">
            <div class="center">                
                <!--SIDEBAR START--> 
                    <?php get_sidebar(); ?>
                <!--SIDEBAR END--> 
                <div class="single_wrap left_sidebar<?php if ( !is_active_sidebar( 'sidebar' ) ) { ?> no_sidebar<?php } ?>">
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
                            <h1><?php the_title(); ?></h1>
                            <!--PAGE CONTENT START-->   
                            <div class="single_post_content">
                            
                                    <!--THE CONTENT START-->
                                        <div class="thn_post_wrap">
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
                          </div>
                      <!--COMMENT START: Calling the Comment Section. If you want to hide comments from your posts, remove the line below-->     
                      <?php if (!empty ($optimizer['post_comments_id'])) { ?>
                          <div class="comments_template">
                              <?php comments_template('',true); ?>
                          </div>
                      <?php }?> 
                      <!--COMMENT END-->
                  <?php endif ?>
                
                    </div>
               
                <!--PAGE END-->
            </div>
          </div>
    </div><!--layer_wrapper class END-->
<div class="footer_wrap">
  <div class="newsletter">
    <h3 class="widget-title"><?php _e('Stay In The Loop', 'optimizer-custom') ?></h3>
    <?php es_subbox( $namefield = "NO", $desc = "", $group = "", __("Sign up for Laurine Watches news", 'optimizer-custom' )); ?>
  </div>
</div>
<?php get_footer(); ?>