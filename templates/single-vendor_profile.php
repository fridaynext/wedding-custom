<?php

// ******** Copied from wp-content/themes/Divi/single.php ******** //

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
                <div class="et_post_meta_wrapper">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
					
					<?php
					
					// Display the address, 'Visit our Website', Phone (call), Phone ('text us now')
					
					// address
					?>
                    <!-- Generator: Adobe Illustrator 24.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    <div class="vendor-meta">
						<?php $address = get_field( 'address' );
						if ( $address ) : ?>
                            <div class="vendor-address">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 21 28" style="enable-background:new 0 0 21 28;"
                                     xml:space="preserve">
                                                        <style type="text/css">
                                                            .st0 {
                                                                fill: #8CBCBF;
                                                            }
                                                        </style>
                                    <path class="st0" d="M10.64,0.38c-5.5,0-9.96,4.55-9.96,10.17c0,5.61,9.96,16.92,9.96,16.92s9.96-11.31,9.96-16.92
                C20.6,4.93,16.14,0.38,10.64,0.38z M10.63,13.69c-2.06,0-3.73-1.7-3.73-3.8c0-2.1,1.67-3.8,3.73-3.8c2.06,0,3.73,1.7,3.73,3.8
                C14.36,11.99,12.69,13.69,10.63,13.69z"/>
                                                    </svg>
								
								<?php
								$address        = get_field( 'address' );
								$address_string = '';
								$address_string .= ! empty( $address['address_line_1'] ) ? $address['address_line_1'] : '';
								$address_string .= ! empty( $address['address_line_2'] ) ? ', ' . $address['address_line_2'] : '';
								$address_string .= ! empty( $address['city'] ) ? ', ' . $address['city'] : '';
								$address_string .= ! empty( $address['state'] ) ? ', ' . $address['state'] : '';
								$address_string .= ! empty( $address['zip'] ) ? ' ' . $address['zip'] : '';
								
								?>
                                <div class="vendor-address-text" data-micromodal-trigger="map-modal-1" onclick="MicroModal.show('map-modal-1', {awaitCloseAnimation:true})">
                                    <?php echo $address_string; ?>
                                </div>
                            </div>
						<?php if ( get_field( 'vendor_google_map' ) ) : ?>
						<? // set up the MicroModal for beautiful popup ?>
                            <div id="map-modal-1" class="modal micromodal-slide" aria-hidden="true">
                                <div class="modal__overlay" tabindex="-1" data-custom-close="map-modal-1">
                                    <div role="dialog" class="modal__container" aria-modal="true"
                                         aria-labelledby="map-modal-1">
                                        <header class="modal__header">
                                            <div id="map-modal-1-title" class="modal__title">
                                                <p><?php echo get_the_title(); ?><br/>
                                                    <span style="font-size:.8em;font-weight:400;text-transform:none;font-family:'Encode Sans Condensed',sans-serif;"><?php echo $address_string; ?></span>
                                                </p>
                                            </div>
											<?php $location = get_field( 'vendor_google_map' ); ?>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $location['lat'] . ',' . $location['lng']; ?>"
                                               class="directions" target="_blank">Get Directions</a>
                                            <button aria-label="Close modal" class="modal__close"
                                                    data-custom-close="map-modal-1" onclick="MicroModal.close('map-modal-1',{awaitCloseAnimation:true})"></button>
                                        </header>
                                        <div id="map-modal-1-content" class="acf-map modal__content" data-zoom="16">
                                            <div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>"
                                                 data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
						<?php endif; ?>
						<?php endif; ?>
						
						<?php // website
						?>
                        <div class="vendor-meta-second-line">

                            <div class="vendor-website meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <path d="M336.5 160C322 70.7 287.8 8 248 8s-74 62.7-88.5 152h177zM152 256c0 22.2 1.2 43.5 3.3 64h185.3c2.1-20.5 3.3-41.8 3.3-64s-1.2-43.5-3.3-64H155.3c-2.1 20.5-3.3 41.8-3.3 64zm324.7-96c-28.6-67.9-86.5-120.4-158-141.6 24.4 33.8 41.2 84.7 50 141.6h108zM177.2 18.4C105.8 39.6 47.8 92.1 19.3 160h108c8.7-56.9 25.5-107.8 49.9-141.6zM487.4 192H372.7c2.1 21 3.3 42.5 3.3 64s-1.2 43-3.3 64h114.6c5.5-20.5 8.6-41.8 8.6-64s-3.1-43.5-8.5-64zM120 256c0-21.5 1.2-43 3.3-64H8.6C3.2 212.5 0 233.8 0 256s3.2 43.5 8.6 64h114.6c-2-21-3.2-42.5-3.2-64zm39.5 96c14.5 89.3 48.7 152 88.5 152s74-62.7 88.5-152h-177zm159.3 141.6c71.4-21.2 129.4-73.7 158-141.6h-108c-8.8 56.9-25.6 107.8-50 141.6zM19.3 352c28.6 67.9 86.5 120.4 158 141.6-24.4-33.8-41.2-84.7-50-141.6h-108z"/>
                                </svg>
                                <div class="vendor-website-text"><a
                                            href="<?php the_field( "website", get_the_ID() ); ?>"
                                            target="_blank">Visit our Website</a></div>
                            </div>
							
							<?php // phone (call)
							?>
                            <div class="vendor-phone-call meta-item" data-micromodal-trigger="phone-modal" onclick="MicroModal.show('phone-modal', {awaitCloseAnimation:true})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"/>
                                </svg>
								<?php
								$phone_call = get_field( "business_phone_number", get_the_ID() );
								if ( preg_match( '/(\d{3})(\d{3})(\d{4})/', $phone_call, $matches ) ) {
									$phone_call = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
								}
								?>
                                <div class="vendor-phone-call-text">
                                    <?php echo $phone_call; ?>
                                </div>
                            </div>
							<?php /********** PHONE CALL MODAL **********/ ?>
                            <div id="phone-modal" class="modal micromodal-slide" aria-hidden="true">
                                <div class="modal__overlay" tabindex="-1" data-custom-close="phone-modal">
                                    <div role="dialog" class="modal__container" aria-modal="true"
                                         aria-labelledby="phone-modal">
                                        <header class="modal__header">
                                            <div id="phone-modal-title" class="modal__title">
                                                <p>Mention that you found them on<br />San Antonio Weddings!</p>
                                            </div>
                                            <button aria-label="Close modal" class="modal__close"
                                                    data-custom-close="phone-modal" onclick="MicroModal.close('phone-modal', {awaitCloseAnimation:true})"></button>
                                        </header>
                                        <div id="phone-modal-content" class="modal__content">
                                            <div class="phone-number">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"/>
                                                </svg>
                                                <a href="tel:<?php echo $phone_call; ?>"><?php echo $phone_call; ?></a>
                                            </div>
                                            <p class="right-text">Click to Call</p>
                                            <p class="didnt-get-in-touch">Didn't get in touch with them?</p>
                                            <p class="teal"><a href="#">Email a Message</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							<?php // phone (text)
							?>
                            <div class="vendor-phone-text meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"/>
                                </svg>
								<?php
								$phone_text = get_field( "text_phone_number", get_the_ID() );
								if ( preg_match( '/(\d{3})(\d{3})(\d{4})/', $phone_text, $matches ) ) {
									$phone_text = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
								}
								?>
								<?php /* TODO: Change this to be a Twilio link for SMS capability! */ ?>
                                <div class="vendor-phone-text-text"><a href="#" onclick="event.preventDefault();MicroModal.show('phone-text-modal', {awaitCloseAnimation:true})">Text Us Now</a></div>
                            </div>
                            
                            <?php /********** PHONE TEXT MODAL **********/ ?>
                            <div id="phone-text-modal" class="modal micromodal-slide" aria-hidden="true">
                                <div class="modal__overlay" tabindex="-1" data-custom-close="phone-text-modal">
                                    <div role="dialog" class="modal__container" aria-modal="true"
                                         aria-labelledby="phone-text-modal">
                                        <header class="modal__header">
                                            <div id="phone-text-modal-title" class="modal__title">
                                                <p>Text this vendor, and tell them you found<br />them on San Antonio Weddings!</p>
                                            </div>
                                            <button aria-label="Close modal" class="modal__close"
                                                    data-custom-close="phone-text-modal" onclick="MicroModal.close('phone-text-modal', {awaitCloseAnimation:true})"></button>
                                        </header>
                                        <div id="phone-text-modal-content" class="modal__content">
                                            <?php gravity_form(4, false, false, false, array('twilio_cell_number' => get_field('text_phone_number')), true); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                MicroModal.init({
                                    awaitCloseAnimation: true
                                });
                            </script>
                        </div>
                    </div>
					
					
					<?php
					$thumb = '';
					
					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
					
					$height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext   = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb     = $thumbnail["thumb"];
					
					//                                        $post_format = et_pb_post_format();
					
					$text_color_class = et_divi_get_post_text_color();
					
					$inline_style = et_divi_get_post_bg_inline_style();
					
					?>
                </div> <!-- .et_post_meta_wrapper -->
				
				<?php // **** Add a sticky nav bar that will work all the way down the page ***** // ?>
				
				
				<?php
				/* TODO: Do a check to see if these sections need to exist, then print their links and related sections */
				$vendor_gallery = get_field( 'photo_gallery' );
				$video_gallery  = get_field( 'videos' );
				$about_vendor   = get_field( 'about_this_vendor' );
				$special_offers = get_posts( array(
					'post_type'  => 'special_offers',
					'meta_key'   => 'vendor',
					'meta_value' => get_the_ID() // ensures we're only getting special offers for this vendor
				) );
				$reviews        = get_field( 'wedding_wire_reviews_html' );
				$vendor_posts   = get_posts( array(
					'post_type'  => array(
						'spotlight',
						'styled_shoot',         // this query is "in the press"
						'wedding_story'
					),
					'meta_key'   => 'vendor',
					'meta_value' => get_the_ID()
				) );
				// TODO: Create a check for Comparison Guides! (Just hide it altogether for now)
				$url_360 = get_field( '360-virtual-tour' );
				
				?>


                <div class="vendor-sticky-nav">
                    <ul class="vendor-page-nav">
						<?php if ( $vendor_gallery ) : ?>
                            <li class="nav-item"><a href="#vendor-gallery">Gallery</a></li><?php endif; ?>
						<?php if ( $about_vendor ) : ?>
                            <li class="nav-item"><a href="#about-vendor">About</a></li><?php endif; ?>
						<?php if ( $special_offers ) : ?>
                            <li class="nav-item"><a href="#special-offers">Offers/Events</a></li><?php endif; ?>
						<?php if ( $reviews ) : ?>
                            <li class="nav-item"><a href="#vendor-reviews">Reviews</a></li><?php endif; ?>
						<?php if ( $vendor_posts ) : ?>
                            <li class="nav-item"><a href="#in-the-press">In the Press</a></li><?php endif; ?>
						<?php if ( false )  : //TODO: UPDATE ?>
                            <li class="nav-item"><a href="#comparison-guides">Comparison Guide</a></li><?php endif; ?>
						<?php if ( $url_360 ) : ?>
                            <li class="nav-item"><a href="#360-tours">360° Tour</a></li><?php endif; ?>
                    </ul>
                </div>


                <div id="left-area">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						/**
						 * Fires before the title and post meta on single posts.
						 *
						 * @since 3.18.8
						 */
						do_action( 'et_before_post' );
						?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>


                            <div class="entry-content">
								<?php
								do_action( 'et_before_content' );
								
								// Insert the photo gallery, and video gallery
								if ( $vendor_gallery ) :
									$size = "full";
									
									$total = sizeof( $vendor_gallery ); ?>
                                    <div id="vendor-gallery" class="swiper-container">
                                        <div class="swiper-wrapper">
											<?php foreach ( $vendor_gallery as $image_id ): ?>
                                                <div class="swiper-slide">
													<?php echo wp_get_attachment_image( $image_id, $size ); ?>
                                                </div>
											<?php endforeach; ?>
                                        </div>
                                        <div class="swiper-pagination"></div>

                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>

                                    <script type="text/javascript">
                                        var swiper = new Swiper('.swiper-container', {
                                            slidesPerView: 'auto',
                                            centeredSlides: true,
                                            loop: false,
                                            loopedSlides: <?php echo $total; ?>,
                                            spaceBetween: 5,
                                            navigation: {
                                                nextEl: '.swiper-button-next',
                                                prevEl: '.swiper-button-prev'
                                            },
                                            on: {
                                                init: function () {
                                                    // find width of image and dynamically assign width of parent div (.swiper-slide)
                                                    // set widths of all parent div containers of images
                                                    jQuery('.swiper-slide').each(function (index, element) {
                                                        // in each swiper-slide, get the child image's width to calculate this wrapper's width
                                                        let imgWidth = jQuery(this).children().first().width();
                                                        let imgHeight = jQuery(this).children().first().height();
                                                        let wrapperHeight = jQuery('.swiper-wrapper').height();
                                                        jQuery(this).width(imgWidth * wrapperHeight / imgHeight);
                                                        console.log("updated width: ");
                                                        console.log(jQuery(this).width());
                                                    });
                                                    // var $img_height = jQuery('.swiper-slide-active img').height();
                                                    // var $img_width = jQuery('.swiper-slide-active img').width();
                                                    // var $container_height = jQuery('.swiper-container').height();
                                                    // if($img_height > $container_height) {
                                                    //     $new_img_width = $container_height * $img_width / $img_height;
                                                    //     jQuery('.swiper-slide-active').width($new_img_width);
                                                    //     jQuery('.swiper-slide-active').height('auto');
                                                    // }
                                                }//,
                                                //     slideChange: function () {
                                                //         // do the same, but when the slides change
                                                //         var $img_height = jQuery('.swiper-slide-active img').height();
                                                //         var $img_width = jQuery('.swiper-slide-active img').width();
                                                //         var $container_height = jQuery('.swiper-container').height();
                                                //         if($img_height > $container_height) {
                                                //             // do $container_height * $img_width / $img_height - for new image width
                                                //             var $new_img_width = $container_height * $img_width / $img_height;
                                                //             jQuery('.swiper-slide-active').width($new_img_width);
                                                //             jQuery('.swiper-slide-active img').width($new);
                                                //         }
                                                //         var $prev_img_height = jQuery('.swiper-slide-prev img').height();
                                                //         var $prev_img_width = jQuery('.swiper-slide-prev img').width();
                                                //         if($prev_img_height > $container_height) {
                                                //             var $new_img_width = $container_height * $prev_img_width / $prev_img_height;
                                                //             jQuery('.swiper-slide-prev').width($new_img_width);
                                                //             jQuery('.swiper-slide-prev').height('');
                                                //         }
                                                //         var $next_img_height = jQuery('.swiper-slide-next img').height();
                                                //         var $next_img_width = jQuery('.swiper-slide-next img').height();
                                                //         if($next_img_height > $container_height) {
                                                //             var $new_img_width = $container_height * $next_img_width / $next_img_height;
                                                //             jQuery('.swiper-slide-next').width($new_img_width);
                                                //             jQuery('.swiper-slide-next').height('100%');
                                                //         }
                                                //     }
                                                //
                                            },
                                        });
                                    </script>
								<?php endif; ?>
								
								<?php if ( $about_vendor ) : ?>
                                    <h2 id="about-vendor"><span
                                                class="vendor-header-triangle"></span>About <?php echo get_the_title(); ?>
                                    </h2>
									<?php
									the_field( "about_this_vendor", get_the_ID() );
								endif;
								
								/******************** Special Offers & Events ********************/
								if ( $special_offers ) : ?>
                                    <h2 id="special-offers"><span class="vendor-header-triangle"></span>Special Offers &
                                        Events</h2>
									<?php
									// $special_offers is gotten at the top of this page, to determine whether or not its sticky menu item should show
									// we have some matches - let's grab them ?>
                                    <div class="special-offer-container">
										<?php foreach ( $special_offers as $offer ) {
											if ( $end_date = get_field( 'offer_end_date', $offer->ID ) ) {
												$end_date = "Offer Ends: " . get_field( 'offer_end_date', $offer->ID );
											} else {
												$end_date = "Permanent Promotion";
											}
											?>
                                            <div class="special-offer">
                                                <h4><?php echo get_the_title( $offer->ID ); ?></h4>
                                                <span class="offer-timeline"><?php echo $end_date; ?></span>
                                                <p><?php echo $offer->post_content; ?></p>
                                                <div class="saw-button right" onclick="event.preventDefault();MicroModal.show('special-offer-modal',{awaitCloseAnimation:true})">
                                                    <a href="#">Tell Me More <i class="fa fa-angle-double-right pl-lg-2 pl-1"
                                                                                aria-hidden="true"></i></a>
                                                </div>
                                            </div>
											<? // Special Offer Contact Form Modal ?>
                                            <div id="special-offer-modal" class="modal micromodal-slide" aria-hidden="true">
                                                <div class="modal__overlay" tabindex="-1" data-custom-close="special-offer-modal">
                                                    <div role="dialog" class="modal__container" aria-modal="true"
                                                         aria-labelledby="special-offer-modal">
                                                        <header class="modal__header">
                                                            <div id="special-offer-modal-title" class="modal__title">
                                                                Special Offers & Events from <?php echo get_the_title(); ?>
                                                            </div>
                                                            <button aria-label="Close modal" class="modal__close"
                                                                    data-custom-close="special-offer-modal" onclick="MicroModal.close('special-offer-modal',{awaitCloseAnimation:true})"></button>
                                                        </header>
                                                        <div id="special-offer-modal-content" class="modal__content" data-zoom="16">
                                                            <p>I am interested in <span style="color:var(--main-teal-color);font-size:1.2em;"><?php echo get_the_title($offer->ID); ?></span></p>
                                                            <p>Please fill out this form, and we will contact you with all the information you need.</p>
	                                                        <?php gravity_form(5, false, false, false, array('vendor_email' => get_field('reply_email', $offer->ID), 'special_offer_title' => get_the_title($offer->ID) . ' - Contact from SA Weddings'), true); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>
                                    </div> <!-- END .special-offer-container -->
								<?php endif;
								
								/******************** Reviews ********************/
								if ( $reviews ) : ?>
                                    <h2 id="vendor-reviews"><span class="vendor-header-triangle"></span>Reviews</h2>
									<?php echo get_field( 'wedding_wire_reviews_html', get_the_ID() );
								endif;
								
								/******************** In the Press ********************/
								if ( sizeof( $vendor_posts ) > 0 ) : ?>
                                    <h2 id="in-the-press"><span class="vendor-header-triangle"></span>In the Press</h2>
                                    <div class="in-the-press">
										<?php
										// check each post type to see that the vendor meta_key is equal to this vendor's post ID
										
										// $vendor_posts is created at the top of this page while checking for nav bar menu items to display
										
										$post_types = [ 'spotlight', 'styled_shoot', 'wedding_story' ];
										foreach ( $post_types as $this_type ) {
											foreach ( $vendor_posts as $vendor_post ) {
												if ( $vendor_post->post_type == $this_type ) { ?>
                                                    <div class="individual-press-post <?php echo $this_type; ?>">
                                                        <div class="left-half">
                                                            <div class="press-type">
																<?php switch ( $this_type ) {
																	case 'spotlight':
																		echo 'Featured Spotlight';
																		break;
																	case 'styled_shoot':
																		echo 'Styled Shoot';
																		break;
																	case 'wedding_story':
																		echo 'Our Wedding Story';
																		break;
																	default:
																		echo 'Blog Article';
																		break;
																} ?>
                                                            </div>
                                                            <div class="featured-image">
																<?php echo get_the_post_thumbnail( $vendor_post->ID ); ?>
                                                            </div>
                                                        </div>
                                                        <div class="right-half">
                                                            <h2 class="press-title">
																<?php echo get_the_title( $vendor_post->ID ); ?>
                                                            </h2>
                                                            <div class="read-more saw-button">
                                                                <a href="<?php echo get_permalink( $vendor_post->ID ); ?>">Read
                                                                    More <i
                                                                            class="fa fa-angle-double-right pl-lg-2 pl-1"
                                                                            aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="third-half">
                                                            <div class="press-social-slider">
                                                                <div class="share-tab">Share</div>
                                                                <div class="icon-container">
                                                                    <img class="facebook-share"
                                                                         src="<?php echo esc_url( plugins_url( '../public/img/Social-Media-Icons-SAW-FB.png', __FILE__ ) ); ?>"
                                                                         alt="facebook-share">
                                                                    <img class="instagram-share"
                                                                         src="<?php echo esc_url( plugins_url( '../public/img/Social-Media-Icons-SAW-Instagram.png', __FILE__ ) ); ?>"
                                                                         alt="instagram-share">
                                                                    <img class="pinterest-share"
                                                                         src="<?php echo esc_url( plugins_url( '../public/img/Social-Media-Icons-SAW-Pinterest.png', __FILE__ ) ); ?>"
                                                                         alt="pinterest-share">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
												<?php }
											}
										}
										wp_reset_query();
										
										?>
                                        <script type="text/javascript">
                                            jQuery(".press-social-slider .share-tab").click(function () {
                                                    jQuery(this).parent().toggleClass("visible");
                                                }
                                            );
                                        </script>
                                    </div>
								<?php endif; ?>
								
								<?php /******************** Comparison Guides ********************/
								/************** TODO: If musician, this won't be here, but it will be musical samples ************/ ?>
								<?php if ( false ) : // TODO: CHANGE THIS WHEN WE ACTUALLY HAVE COMPARISON GUIDES ?>
                                    <h2 id="comparison-guides"><span class="vendor-header-triangle"></span>Comparison
                                        Guides</h2>
								<?php endif; ?>
								
								<?php /******************** 360° Virtual Tours ********************/
								if ( $url_360 ) : ?>
                                    <h2 id="360-tours"><span class="vendor-header-triangle"></span>360° Virtual Tours
                                        of <?php echo get_the_title(); ?></h2>
									<?php $url_360 = get_field( '360-virtual-tour', get_the_ID() ); ?>
                                    <a href="<?php echo $url_360; ?>"><img
                                                src="<?php echo esc_url( plugins_url( '../public/img/San-Antonio-Weddings-360-Virtual-Tour-Animated.gif', __FILE__ ) ); ?>"
                                                width="100%" height="auto"/></a>
								<?php endif; ?>
								
								
								<?php wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ),
									'after'  => '</div>'
								) );
								?>
                            </div> <!-- .entry-content -->
                            <div class="et_post_meta_wrapper">
								<?php
								if ( et_get_option( 'divi_468_enable' ) === 'on' ) {
									echo '<div class="et-single-post-ad">';
									if ( et_get_option( 'divi_468_adsense' ) !== '' ) {
										echo et_core_intentionally_unescaped( et_core_fix_unclosed_html_tags( et_get_option( 'divi_468_adsense' ) ), 'html' );
									} else { ?>
                                        <a href="<?php echo esc_url( et_get_option( 'divi_468_url' ) ); ?>"><img
                                                    src="<?php echo esc_attr( et_get_option( 'divi_468_image' ) ); ?>"
                                                    alt="468" class="foursixeight"/></a>
									<?php }
									echo '</div> <!-- .et-single-post-ad -->';
								}
								
								/**
								 * Fires after the post content on single posts.
								 *
								 * @since 3.18.8
								 */
								do_action( 'et_after_post' );
								
								if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) ) {
									comments_template( '', true );
								}
								?>
                            </div> <!-- .et_post_meta_wrapper -->
                        </article> <!-- .et_pb_post -->
					
					<?php endwhile; ?>
                </div> <!-- #left-area -->
                <div id="sidebar">
					<?php if ( is_active_sidebar( 'vendor-profile-sidebar' ) ) :
						dynamic_sidebar( 'vendor-profile-sidebar' );
						
						echo do_shortcode( '[vendor_url]' );
					endif; ?>
                </div>
				<?php //get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->


<?php //********************* JS for Google Map *********************// ?>
    <style type="text/css">
        .acf-map {
            width: 100%;
            height: 400px;
            border: #ccc solid 1px;
            margin: 20px 0;
        }

        /* Fixes potential theme css conflict. */
        .acf-map img {
            max-width: inherit !important;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1SQ_pAK657gUt1SrStTNFIuIiwgf5I3w"></script>
    <script type="text/javascript">
        (function ($) {

            /**
             * initMap
             *
             * Renders a Google Map onto the selected jQuery element
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   jQuery $el The jQuery element.
             * @return  object The map instance.
             */
            function initMap($el) {

                // Find marker elements within map.
                var $markers = $el.find('.marker');

                // Create gerenic map.
                var mapArgs = {
                    zoom: $el.data('zoom') || 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map($el[0], mapArgs);

                // Add markers.
                map.markers = [];
                $markers.each(function () {
                    initMarker($(this), map);
                });

                // Center map based on markers.
                centerMap(map);

                // Return map instance.
                return map;
            }

            /**
             * initMarker
             *
             * Creates a marker for the given jQuery element and map.
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   jQuery $el The jQuery element.
             * @param   object The map instance.
             * @return  object The marker instance.
             */
            function initMarker($marker, map) {

                // Get position from marker.
                var lat = $marker.data('lat');
                var lng = $marker.data('lng');
                var latLng = {
                    lat: parseFloat(lat),
                    lng: parseFloat(lng)
                };

                // Create marker instance.
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });

                // Append to reference for later use.
                map.markers.push(marker);

                // If marker contains HTML, add it to an infoWindow.
                if ($marker.html()) {

                    // Create info window.
                    var infowindow = new google.maps.InfoWindow({
                        content: $marker.html()
                    });

                    // Show info window when marker is clicked.
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }
            }

            /**
             * centerMap
             *
             * Centers the map showing all markers in view.
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   object The map instance.
             * @return  void
             */
            function centerMap(map) {

                // Create map boundaries from all map markers.
                var bounds = new google.maps.LatLngBounds();
                map.markers.forEach(function (marker) {
                    bounds.extend({
                        lat: marker.position.lat(),
                        lng: marker.position.lng()
                    });
                });

                // Case: Single marker.
                if (map.markers.length == 1) {
                    map.setCenter(bounds.getCenter());

                    // Case: Multiple markers.
                } else {
                    map.fitBounds(bounds);
                }
            }

            // Render maps on page load.
            $(document).ready(function () {
                $('.acf-map').each(function () {
                    var map = initMap($(this));
                });
            });

        })(jQuery);
    </script>

<?php

get_footer();
