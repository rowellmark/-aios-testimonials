<?php get_header();

    use AIOS\Testimonials\Controllers\Options;
    $testimonials_settings 		= Options::options();
    if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

    $post_id    = get_the_ID();
    $role  = get_post_meta( $post_id, 'aios_testimonials_role', true );
    
?>
<?php if(have_posts()) : ?>

    <?php while(have_posts()) : the_post(); ?>

    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>