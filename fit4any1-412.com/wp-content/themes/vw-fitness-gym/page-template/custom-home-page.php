<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'vw_fitness_gym_before_slider' ); ?>

  <?php if( get_theme_mod( 'vw_fitness_gym_slider_hide_show') != '') { ?>

  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod( 'vw_fitness_gym_slider_speed',3000)) ?>"> 
      <?php $vw_fitness_gym_slider_pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'vw_fitness_gym_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $vw_fitness_gym_slider_pages[] = $mod;
          }
        }
        if( !empty($vw_fitness_gym_slider_pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $vw_fitness_gym_slider_pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <?php the_post_thumbnail(); ?>
            <div class="carousel-caption">
              <div class="inner_carousel">
                <h1><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_fitness_gym_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_fitness_gym_slider_excerpt_number','30')))); ?></p>
                <?php if( get_theme_mod('vw_fitness_gym_slider_button_text','READ MORE') != ''){ ?>
                  <div class="more-btn">
                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_fitness_gym_slider_button_text',__('READ MORE','vw-fitness-gym')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_fitness_gym_slider_button_text',__('READ MORE','vw-fitness-gym')));?></span></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
          <div class="no-postfound"></div>
      <?php endif;
      endif;?>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Previous','vw-fitness-gym' );?></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Next','vw-fitness-gym' );?></span>
      </a>
    </div>
    <div class="clearfix"></div>
  </section>

  <?php } ?>

  <?php do_action( 'vw_fitness_gym_after_slider' ); ?>

  <section id="about-us">
    <div class="container">
      <?php if( get_theme_mod( 'vw_fitness_gym_section_title') != '' ) { ?>
        <h2><?php echo esc_html(get_theme_mod('vw_fitness_gym_section_title',''));?></h2>
      <?php }?>
      <?php if( get_theme_mod( 'vw_fitness_gym_sectio_sub_title') != '' ) { ?>
        <h3><?php echo esc_html(get_theme_mod('vw_fitness_gym_sectio_sub_title',''));?></h3>
      <?php }?>
      <div class="row">
        <?php if( get_theme_mod( 'vw_fitness_gym_about_image') != '' ) { ?>
        <div class="col-lg-4 col-md-4">        
            <img src="<?php echo esc_url(get_theme_mod('vw_fitness_gym_about_image','')); ?>" alt="About Image"/>
        </div>
        <?php }?>
        <div class="<?php if( get_theme_mod( 'vw_fitness_gym_about_image') != '') { ?>col-lg-8 col-md-8"<?php } else { ?>col-lg-12 col-md-12 <?php } ?> ">
          <div class="row">
            <?php
              $vw_fitness_gym_catData =  get_theme_mod('vw_fitness_gym_services','');
              if($vw_fitness_gym_catData){
              $page_query = new WP_Query(array( 'category_name' => esc_html($vw_fitness_gym_catData,'vw-fitness-gym'))); ?>
              <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
              <div class="<?php if( get_theme_mod( 'vw_fitness_gym_about_image') != '') { ?>col-lg-6 col-md-6"<?php } else { ?>col-lg-4 col-md-4 <?php } ?> ">
                <div class="serv-box">
                  <?php the_post_thumbnail(); ?>
                  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h4>
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_fitness_gym_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_fitness_gym_services_excerpt_number','30')))); ?></p>
                </div>
              </div>
              <?php endwhile;
              wp_reset_postdata();
            } ?>
          </div>
        </div>
      </div>
    </div>  
  </section>

  <?php do_action( 'vw_fitness_gym_after_second_section' ); ?>

  <div class="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
