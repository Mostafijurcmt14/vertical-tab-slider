
// Vertical tab slider js
function vertical_tab_slider_js(){
    ?>
        <script>
            jQuery(document).ready(function($){
				
				
    var $previousItem = null;
				
				$(".v-slider-wrap .v-item:first-child").addClass("active");

    function handleTabClickMobile() {
        var $this = $(this);
        var currentIndex = $(".v-slider-wrap .v-item").index($this);
        var previousIndex = $previousItem ? $(".v-slider-wrap .v-item").index($previousItem) : -1;
        var direction = currentIndex > previousIndex ? 'down' : 'up';

        // Close all items except the clicked one
        $(".v-slider-wrap .v-item").not($this).removeClass("active");
        $(".v-slider-wrap .v-item").not($this).find('.show-hide').slideUp(300);
        $(".v-slider-wrap .v-item").not($this).find('.left-column').slideUp(300);

        // Show/hide the current item based on the direction
        $this.toggleClass("active");
        $this.find('.show-hide').slideToggle(300);
        $this.find('.left-column').slideToggle(300);

        // Update previousItem
        $previousItem = $this;
    }

    function handleTabClickDesktop() {
        var $this = $(this);
        $(".v-slider-wrap .v-item").removeClass("active");
        $(".v-slider-wrap .v-item .show-hide").hide();
        $(".v-slider-wrap .left-column").hide();
        $this.addClass("active");

        // Using setTimeout to delay the fadeIn effect
        setTimeout(function() {
            $this.find('.show-hide').slideDown(300); 
            $this.find('.left-column').slideDown(300); 
        }, 300);
    }

    function handleResize() {
        var windowWidth = $(window).width();
        if (windowWidth <= 767) {
            $(".v-slider-wrap .v-item").off('click').on('click', handleTabClickMobile);
        } else {
            $(".v-slider-wrap .v-item").off('click').on('click', handleTabClickDesktop);
        }
    }

    // Initial setup on document ready
    handleResize();

    // Listen for window resize event
    $(window).resize(function() {
        handleResize();
    });
});
        </script>
    <?php
}
add_action('wp_footer', 'vertical_tab_slider_js');





// Vartical tab slider markup
function vartical_tab_slider(){
	ob_start();
	?>
		<div class="v-slider-wrap">
			<div class="row">
				<?php
				$args = array(
					'post_type' => 'zing_tab_slider',
					'post_status' => 'publish',
					'posts_per_page' => 5
				);

				$query = new WP_Query($args);

				if($query->have_posts()){
					while($query->have_posts()){
						$query->the_post();
				?>
			
				<div class="v-item">
					<div class="v-item-row">
						<div class="left-column">
							<h3 class="v-subheading show-hide"><?php echo get_field('sub_title'); ?></h3>
							<h2 class="v-heading show-hide"><?php echo the_title(); ?></h2>
							<div class="left-v-content show-hide"><?php echo the_content(); ?>
							</div>
							<div class="left-v-content-two show-hide"><?php echo get_field('second_sub_title'); ?></div>
							<a href="<?php echo get_field('scroll_the_seasons_button_url'); ?>" class="v-read-more show-hide"><?php echo get_field('scroll_the_seasons_button_text'); ?> <i aria-hidden="true" class="icon icon-arrow-right"></i></a>
						</div>
						<div class="right-column">
							<div class="v-content show-hide">
								<?php echo get_field('right_side_text'); ?>
							</div>
							<div class="v-slider-number"><span><?php echo get_field('slide_number'); ?></span><h3 class="show-hide">Early Fall</h3></div>
						</div>
					</div>
				</div>
				
<?php
					}
				}
	else{
		echo 'No posts found!';	
	}
?>
				
			</div>	
		</div>
			
	<?php
	return ob_get_clean();
	wp_reset_postdata();
}
add_shortcode('vartical_tab_slider_shortcode', 'vartical_tab_slider');
