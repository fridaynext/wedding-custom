<?php
/**
 * @package FN_Extras
 * @version 1.2.1
 */

define( 'FRIDAY_NEXT_EXTRAS_VERSION', '1.2.1' );

/********************* ACF JSON *********************/
//add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
//function my_acf_json_save_point( $path ) {
//	// update path
//	$path = dirname( __FILE__ ) . '/private/acf-json';
//
//	// return
//	return $path;
//}
//
//add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
//function my_acf_json_load_point( $paths ) {
//	// remove original path (optional)
//	unset( $paths[0] );
//
//	// append path
//	$paths[] = dirname( __FILE__ ) . '/private/acf-json';
//
//	// return
//	return $paths;
//}

/* Remove admin bar for editors (Actually, EVERYONE - need to do a check later for only editors) */
show_admin_bar( false );

add_action( 'wp_print_styles', 'fn_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'fn_enqueue_scripts' );

//add_filter( 'posts_where', 'this_vendor_title_posts_where' );
//function this_vendor_title_posts_where( $where ) {
//	global $wpdb;
//	if ( isset( $_GET['this_vendor_title'] ) && ! empty( $_GET['this_vendor_title'] ) ) {
//		$this_vendor_title = $_GET['this_vendor_title'];
//		$where             .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $this_vendor_title ) ) . '%\'';
//	}
//
//	return $where;
//}

// read in csv, and import into WP database
//function import_vendors_func() {
//
//
//	$row = 1;
//	if ( ! file_exists( "/home2/sawtsite/www/wp-content/plugins/fn-saw/public/vendor_data.csv" ) ) {
//		die( 'File does not exist' );
//	}
//
//
////	if ( $handle = fopen( "/home2/sawtsite/www/wp-content/plugins/fn-saw/public/company-category.csv", "r" ) !== false ) {
////		$handle = fopen( "/home2/sawtsite/www/wp-content/plugins/fn-saw/public/company-category.csv", "r" );
//	if ( $handle = fopen( "/home2/sawtsite/www/wp-content/plugins/fn-saw/public/vendor_data.csv", "r" ) !== false ) {
//		$handle = fopen( "/home2/sawtsite/www/wp-content/plugins/fn-saw/public/vendor_data.csv", "r" );
//
//		$repeat_ven = 1;
//		$last_ven   = '';
//		$tag_count = 0;
//		$all_tags = get_terms(array("taxonomy" => "post_tag", "hide-empty" => false));
//		$tag_name_array = array();
//
//
//		foreach ($all_tags as $single_tag) {
//		    $tag_name_array[$single_tag->name] = $single_tag->term_id;
//        }
//		while ( ( $data = fgetcsv( $handle, 1000, "," ) ) !== false ) {
//
//			$num = count( $data );
//			echo "<p> $num fields in line $row: <br /></p>\n";
//			$row ++;
//			echo "Row: $row<br />";
////			$vendor_id   = $data[0];
////			$vendor_name = $data[1];
////			$cat_name    = $data[2];
////
////			if ( $vendor_name == $last_ven ) { // checking the previous row with this one
////				$repeat_ven ++;
////			} else {
////				$repeat_ven = 1;
////			}
////			$last_ven = $data[1]; // after doing the check, set $last_ven to the current row
////
////			$this_cat = get_terms( array(
////				'taxonomy' => 'category',
////				'name'     => $cat_name
////			) );
////			foreach ( $this_cat as $cat ) {
////				$premium_listings = get_field( 'field_5ef380bcbbd1b', $vendor_id );
////				$field_row        = array(
////					'field_5ef3814abbd1d' => 5,
////					'field_5ef38122bbd1c' => $cat->term_id// taxonomy,
////				);
////				if ( sizeof( $premium_listings ) >= $repeat_ven ) {
////					echo "Updating row " . $repeat_ven . " for " . $vendor_name . ', with category: ' . $cat_name . '<br />';
////					update_row( 'field_5ef380bcbbd1b', $repeat_ven, $field_row, $vendor_id );
////				} else {
////					add_row( 'field_5ef380bcbbd1b', $field_row, $vendor_id );
////					echo "Adding row for " . $vendor_name . ', with category: ' . $cat_name . '<br />';
////				}
////				break; // break immediately, since there should only be one category per line
////			}
////            $row++;
//
//			for ( $c = 0; $c < $num; $c ++ ) {
//				if ( $data[ $c ] != '' ) {
//					$this_id = $data[0];
//					switch ( $c ) {
////						case 3: // About Us
////							update_field( 'about_this_vendor', $data[ $c ], $this_id );
////							break;
////						case 5: // Subject Line
////							update_field( 'subject_line', $data[ $c ], $this_id );
////							break;
////						case 7: // Facebook
////							update_field( 'facebook', $data[ $c ], $this_id );
////							break;
////						case 9: // Instagram
////							update_field( 'instagram', $data[ $c ], $this_id );
////							break;
////						case 10: // Pinterest
////							update_field( 'pinterest', $data[ $c ], $this_id );
////							break;
//						case 11: // Meta Title
//							update_field( 'meta_title', $data[ $c ], $this_id );
//							break;
//						case 12: // Meta Description
//							update_field( 'meta_description', $data[ $c ], $this_id );
//							break;
//						case 13: // Meta Keywords
//
//                            $keywords = explode( ",", $data[ $c ] );
//							$keyword_id_arr = array();
//							foreach ($keywords as $keyword) {
//								$tag_count += 1;
//							    // get the tag id
////                                $this_term = get_term_by('name', trim($keyword), 'tag');
//                                if(key_exists(trim($keyword), $tag_name_array)) {
//                                    $keyword_id_arr[] = $tag_name_array[trim($keyword)];
//                                } else {
//	                                echo "Tag " . $tag_count . " wasn't found, creating it now...<br />";
//	                                $this_term = wp_insert_term( trim( $keyword ), 'post_tag' );
//	                                if ( ! is_wp_error( $this_term ) && ( $this_term != false && ! is_null( $this_term ) ) ) {
//		                                echo "Now adding tag " . $tag_count . " as id: " . $this_term['term_id'] . "<br />";
//		                                $keyword_id_arr[] = $this_term['term_id'];
//	                                } else {
//		                                echo "<strong>Still couldn't create tag " . $tag_count . " for some reason</strong><br />";
//		                                echo $this_term->get_error_message() . "<br />";
//	                                }
//                                }
//                            }
//							update_field( 'meta_keywords', $keyword_id_arr, $this_id );
//							break;
//						case 17: // 360 Virtual Tour
//							update_field( '360-virtual-tour', $data[ $c ], $this_id );
//							break;
//					}
//				}
//			}
//
//
//			/*update_field( 'address', $address, $new_vendor_id );
//			for ( $c = 0; $c < $num; $c ++ ) {
//
//			}
//			$html .= "Success adding: " . $data[0] . "<br>";
//		}
//	else {
//			$html .= "Error adding: " . $data[0] . "<br>";
//		}*/
//		}
//		fclose( $handle );
//	}
//
////    return $html;
////    $vendors = get_posts(array('post_type' =>'vendor_profile', 'posts_per_page' => -1));
////    foreach ($vendors as $vendor) {
////        $website = 'https://' . get_field('website', $vendor->ID);
////        update_field('website', $website, $vendor->ID);
////    }
//}

add_shortcode( 'import_vendors', 'import_vendors_func' );

/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function () {
	while ( @ob_end_flush() ) {
		;
	}
} );

/* Adding Google Maps API Key for ACF Form Fields */
function my_acf_init() {
	acf_update_setting( 'google_api_key', 'AIzaSyA1SQ_pAK657gUt1SrStTNFIuIiwgf5I3w' );
}

add_action( 'acf/init', 'my_acf_init' );

function fn_enqueue_styles() {
	wp_register_style( 'fn_default_styles', plugins_url( 'public/css/default.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'fn_default_styles' );
	wp_register_style( 'swiper_style', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'swiper_style' );
	wp_register_style( 'header_style', plugins_url( 'public/css/header.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'header_style' );
	wp_register_style( 'footer_style', plugins_url( 'public/css/footer.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'footer_style' );
	wp_register_style( 'jquery-ui-style', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'jquery-ui-style' );
	
	// For jQuery Tables on Admin pages
	//   TODO: Do a check for what page we're on, and only enqueue these if we're in the admin section!!!
	wp_register_style( 'datatables_style', '//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_register_style( 'datatables_buttons_style', '//cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_register_style( 'datatables_custom', plugins_url( 'public/css/table.css', __FILE__ ), array(
		'datatables_style',
		'datatables_buttons_style'
	), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'datatables_custom' );
	wp_register_style( 'admin-styles', plugins_url( 'public/css/admin.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'admin-styles' );
	
	// TODO: Only render these styles for the article pages!
	wp_register_style( 'article_styles', plugins_url( 'public/css/article.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'article_styles' );
	
	wp_register_style( 'open_sans_light', '//fonts.googleapis.com/css2?family=Encode+Sans+Condensed:wght@100;300;700&family=Encode+Sans:wght@100;300;700&family=Open+Sans+Condensed:wght@700&display=swap', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'open_sans_light' );
	
	// 'Vendor List' Page Style
	if ( get_post_field( 'post_name', get_post() ) == 'vendor-list' ) {
		wp_register_style( 'vendor_list_style', plugins_url( 'public/css/vendor-style.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
		wp_enqueue_style( 'vendor_list_style' );
	}
	// 'Vendor Profile' Styles
	if ( get_post_type() == 'vendor_profile' ) {
		wp_register_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css');
		wp_register_style( 'vendor_profile_style', plugins_url( 'public/css/vendor-profile.css', __FILE__ ), array( 'animate' ), FRIDAY_NEXT_EXTRAS_VERSION );
		wp_enqueue_style( 'vendor_profile_style' );
	}
	// Homepage
	if ( is_page( 'home' ) ) {
		wp_register_style( 'homepage_style', plugins_url( 'public/css/homepage.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
		wp_enqueue_style( 'homepage_style' );
	}
}

//*********************************  WP_ENQUEUE_SCRIPTS *******************************//
function fn_enqueue_scripts() {
	// Scripts
	wp_register_script( 'facebook_share', 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0' );
//    wp_enqueue_script( 'facebook_share' );
	wp_register_script( 'pinterest_share', 'https://assets.pinterest.com/js/pinit.js' );
//    wp_enqueue_script( 'pinterest_share' );
	
	// For jQuery Tables on Admin pages
	//   TODO: Do a check for what page we're on, and only enqueue these if we're in the admin section!!!
	wp_register_script( 'datatables_script', '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array(), null, true );
	wp_register_script( 'datatables_buttons_script', '//cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js', array(), null, true );
	wp_localize_script( 'datatables_script', 'datatablesajax', array( 'url' => admin_url( 'admin-ajax.php?action=article_datatables' ) ) );
	wp_enqueue_script( 'datatables_script' );
	wp_enqueue_script( 'datatables_buttons_script' );
	
	// Just for the Vendor Profile Page (save bandwidth elsewhere)
	if ( get_post_type() == 'vendor_profile' ) {
		wp_register_script( 'swiper_slider', '//unpkg.com/swiper/swiper-bundle.min.js');
		wp_register_script( 'animated_modal', plugins_url('public/js/animatedModal.min.js', __FILE__));
		wp_register_script( 'micromodal', plugins_url('public/js/micromodal.min.js', __FILE__));
		wp_register_script( 'sticky_bits', plugins_url( 'public/js/jquery.stickybits.min.js', __FILE__ ), array(
			'swiper_slider',
			'animated_modal',
			'micromodal',
			'jquery-ui-tabs'
		), FRIDAY_NEXT_EXTRAS_VERSION);
		wp_enqueue_script( 'sticky_bits' );
	}
	
	wp_register_script( 'fn_scripts', plugins_url( 'public/js/scripts.js', __FILE__ ), array(
		'jquery',
		'facebook_share',
		'pinterest_share',
		'jquery-ui-core',
		'jquery-ui-tabs',
		'datatables_script',
		'datatables_buttons_script'
	), FRIDAY_NEXT_EXTRAS_VERSION, true );
	wp_localize_script( 'fn_scripts', 'fnajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'fn_scripts' );
	
	if ( is_page( 'home' ) ) {
		wp_register_script( 'swiper_slider', 'https://unpkg.com/swiper/swiper-bundle.min.js' );
		wp_enqueue_script( 'swiper_slider' );
	}
}

add_action( 'wp_head', 'acf_reqs' );
function acf_reqs() {
	// TODO: Check to see if admin page, then add this!
	acf_form_head();
}

/**
 * Enable unfiltered_html capability for Editors.
 */
function allow_editors_to_html( $allow_unfiltered_html) {
    return true;
}
add_filter('acf/allow_unfiltered_html', 'allow_editors_to_html');

// Login Redirect
function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} elseif ( in_array( 'editor', $user->roles ) ) {
			// Redirect editors to the saw-admin section!
			return get_page_link( 6433 );
		} elseif ( in_array( 'vendor', $user->roles ) ) {
			// Redirect vendors to the vendor admin section!
			// TODO: RETURN VENDORS TO THEIR VENDOR ADMIN PAGE!!!!!
			return home_url();
		} else {
			// logged in user that is not admin, editor, or vendor
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

// Custom Login Logo
function saw_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo plugins_url('public/img/saw-login-logo.png', __FILE__); ?>);
            height: 65px;
            width: 320px;
            background-size: 320px 65px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'saw_login_logo' );

// add async / defer to facebook script
function add_async_attribute( $tag, $handle ) {
	if ( ( 'facebook_share' !== $handle ) || ( 'pinterest_share' !== $handle ) ) {
		return $tag;
	}
	
	return str_replace( ' src', ' async defer crossorigin="anonymous" nonce="Szqdsx5f" src', $tag );
}

add_filter( 'script_loader_tag', 'add_async_attribute', 10, 2 );

// Vendor Profile Sidebar
function vendor_profile_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Vendor Profile', 'fn_extras' ),
			'id'            => 'vendor-profile-sidebar',
			'description'   => __( 'Vendor Profile Sidebar', 'fn_extras' ),
			'before_widget' => '<div class="vendor-profile-sidebar-content">',
			'after_widget'  => "</div>",
			'before_title'  => '<div class="vendor-profile-sidebar-title">',
			'after_title'   => '</div>',
		)
	);
}

add_action( 'widgets_init', 'vendor_profile_sidebar' );

/* Create Vendor User Role */
add_role(
	'vendor', //  System name of the role.
	__( 'Vendor' ), // Display name of the role.
	array(
		'read'                   => true,
		'delete_posts'           => true,
		'delete_published_posts' => true,
		'edit_posts'             => true,
		'publish_posts'          => true,
		'upload_files'           => true,
		'edit_pages'             => true,
		'edit_published_pages'   => true,
		'publish_pages'          => true,
		'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
	)
);

add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );
function mytheme_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	) );
}

// ***** Add Vendor Column to Special Offers CPT Page ******
add_filter( 'manage_special_offers_posts_columns', 'set_custom_edit_special_offers_columns' );
function set_custom_edit_special_offers_columns( $columns ) {
	// Add expiration date, Vendor to columns
	$columns['vendor']     = __( 'Vendor', 'fn_extras' );
	$columns['expiration'] = __( 'Expires', 'fn_extras' );
	
	return $columns;
}

// ***** Get text for Vendor and Expires date columns *****
add_action( 'manage_special_offers_posts_custom_column', 'special_offers_columns', 10, 2 );
function special_offers_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'vendor':
			$vendor_profile_obj = get_field( 'vendor', $post_id );
			$vendor_name        = get_the_title( $vendor_profile_obj );
			if ( is_string( $vendor_name ) ) {
				echo '<a href="' . get_edit_post_link( $vendor_profile_obj ) . '">' . $vendor_name . '</a>';
			} else {
				echo "No Vendor Selected";
			}
			break;
		case 'expiration':
			$offer_exp = get_field( "offer_end_date" );
			if ( $offer_exp == null ) {
				echo "Permanent";
			} else {
				echo $offer_exp;
			}
			break;
	}
}

// ****** Make the columns sortable ****** //
add_filter( 'manage_edit-special_offers_sortable_columns', 'saw_sortable_offers' );
function saw_sortable_offers( $columns ) {
	$columns['vendor'] = 'vendor';
	
	return $columns;
}

add_action( 'pre_get_posts', 'special_offers_orderby' );
function special_offers_orderby( $query ) {
	if ( ! is_admin() ) {
		return;
	}
	$orderby = $query->get( 'orderby' );
	if ( 'vendor' == $orderby ) {
		$query->set( 'meta_key', 'vendor' );
		$query->set( 'orderby', 'meta_value' );
	}
}

// Add custom meta box with Special Offer items in Vendor profile
add_action( 'add_meta_boxes_vendor_profile', 'add_special_offers_box' );
function add_special_offers_box( $post ) {
	add_meta_box( 'special-offer-box', 'Special Offers', 'special_offer_format', 'vendor_profile', 'side', 'default' );
}

function special_offer_format( $post, $args ) {
	$vendor_id = $post->ID;
	
	// store matching vendor
	$matching_offers = array();
	
	// go find all special offers with this vendor as their matching vendor
	$args       = array(
		'post_type'      => 'special_offers',
		'posts_per_page' => - 1
	);
	$all_offers = get_posts( $args );
	foreach ( $all_offers as $offer ) {
		$this_offer_id = $offer->ID;
		// get custom field with Vendor from Special Offers CPT
		$this_vendor = get_field( "vendor", $offer->ID );
		if ( $this_vendor->ID == $vendor_id ) {
			$matching_offers[] = $this_offer_id;
		}
	}
	echo '<p class="special-offers" style="line-height:2.3em;">';
	
	if ( ! empty( $matching_offers ) ) {
		
		// Loop through the Special Offers, and print out links to them
		foreach ( $matching_offers as $offer_id ) {
			echo '<a href="' . get_edit_post_link( $offer_id ) . '" target="_blank">' . get_the_title( $offer_id ) . '</a><br>';
		}
	}
}

// TODO: Change this to be for the profile page
add_filter( 'single_template', 'vendor_profile_template' );
function vendor_profile_template( $single_template ) {
	global $post;
	if ( $post->post_type == 'vendor_profile' ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'templates/single-vendor_profile.php' ) ) {
			return plugin_dir_path( __FILE__ ) . 'templates/single-vendor_profile.php';
		}
	}
	
	return $single_template;
}

// Could use this to populate archive pages - will see!
// [vendors]
function vendors_func( $atts ) {
	// Get all vendors and list here
	//  Get a count, divide by four, and use count(vendors) / 4, per column
	// $vendor_args = array(
// 		'post_type'			=> 'vendor',
// 		'posts_per_page'	=> -1,
// 		'post_status'		=> 'publish',
// 		'orderby'			=> 'title'
// 	);
// 	$vendors = query_posts( $vendor_args );
//
// 	$num_vendors = count( $vendors );
// 	$num_per_column = float;
// 	$num_per_column = $num_vendors / 4;
// 	$num_per_column = round( $num_per_column );
//
// 	// Print Info
// 	$vendor_html = '<div class="wf-column><ul>';
// 	foreach ($vendors as $key => $vendor) {
// 		$website = get_field( 'website', $vendor->ID );
// 		$phone_number = get_field( 'phone_number', $vendor->ID );
//
// 		$vendor_html .= '<li><a href="' . $website . '" target="_blank">' . $vendor->post_title . '</a>
// 		' . $phone_number . '</li>';
// 		if( ($num_vendors % $num_per_column == 0) && ($num_vendors / $num_per_column !== 4) ) {
// 			$vendor_html .= '</ul></div><div class="wf-column"><ul>';
// 		}
// 	}
// 	$vendor_html .= '</ul></div>';
// 	return $vendor_html;
}

// add_shortcode( 'vendors', 'vendors_func' );

function photographer_func( $atts ) {
	if ( isset( $_GET['ssid'] ) ) {
		$post_id = $_GET['ssid'];
	} else {
		$post_id = get_the_ID();
	}
	if ( true == get_field( 'non-existing', $post_id ) ) {
		if ( get_field( 'photographer-manual', $post_id ) ) {
			// non-existing vendor, with a manual name
			$return_string = 'Photography by: ' . get_field( 'photographer-manual', $post_id );
			if ( get_field( 'author', $post_id ) ) {
				$auth_pres     = true;
				$return_string .= ' | Written by: ' . get_field( 'author', $post_id );
			}
			
			return $return_string;
		} else if ( get_field( 'author', $post_id ) ) {
			// no photographer, maybe an author, though!
			return 'Written by: ' . get_field( 'author', $post_id );
		} else {
			return '';
		}
	} else {
		if ( get_field( 'photographer', $post_id ) ) {
			// Got a Vendor - now check for URL
			$photographer = get_field( 'photographer', $post_id );
			if ( get_field( 'website', $photographer->ID ) ) {
				$return_string = 'Photography by: <a href="' . get_permalink( $photographer->ID ) . '" alt="' . get_the_title( $photographer->ID ) . '" style="color:inherit;" target="_blank">' . get_the_title( $photographer->ID ) . '</a>';
			} else {
				// Vendor doesn't have a website URL in their profile yet
				$return_string = 'Photography by: ' . get_field( 'photographer', $post_id )->title;
			}
			if ( get_field( 'author', $post_id ) ) {
				$return_string .= ' | Written by: ' . get_field( 'author', $post_id );
			}
			
			return $return_string;
		} else {
			// There's only an author maybe? let's check that
			if ( get_field( 'author', $post_id ) ) {
				$return_string = 'Written by: ' . get_field( 'author', $post_id );
				
				return $return_string;
			}
			
			return '';
		}
	}
}

add_shortcode( 'photographer', 'photographer_func' );

/************************* AJAX FOR DATATABLES *********************************/
// Add Post title to custom meta
add_action( 'transition_post_status', 'duplicate_title', 10, 3 );
function duplicate_title( $new, $old, $post ) {
	if ( $post->post_type == 'post' || $post->post_type == 'spotlight' || $post->post_type == 'styled_shoot' || $post->post_type == 'wedding_story' ) {
		update_post_meta( $post->ID, 'd_title', $post->post_title );
	}
}

add_action( 'wp_ajax_article_datatables', 'my_ajax_getpostsfordatatables' );
add_action( 'wp_ajax_nopriv_article_datatables', 'my_ajax_getpostsfordatatables' );

function my_ajax_getpostsfordatatables() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0 => 'featuredImage',
		1 => 'type',
		2 => 'title',
		3 => 'author',
		4 => 'postDate',
		5 => 'isActive',
		6 => 'action'
	);
	
	$args = array(
		'post_type'      => array( 'spotlight', 'styled_shoot', 'wedding_story', 'post' ),
		'posts_per_page' => $request['length'],
		'offset'         => $request['start'],
		'order'          => $request['order'][0]['dir']
	);
	
	if ( $request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 2 || $request['order'][0]['column'] == 3 || $request['order'][0]['column'] == 5 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} elseif ( $request['order'][0]['column'] == 4 ) {
		$args['orderby'] = 'date';
	} else {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['s'] = $request['search']['value'];
	}
	
	$article_query = new WP_Query( $args );
	$totalData     = $article_query->found_posts;
	
	if ( $article_query->have_posts() ) {
		$data = array();
		while ( $article_query->have_posts() ) {
			
			$article_query->the_post();
			$active_class = 'deactivate-post';
			$active_text  = 'Deactivate';
			if ( ! get_field( 'is_active' ) ) {
				$active_class = 'activate-post';
				$active_text  = 'Activate';
			}
			
			$image        = get_the_post_thumbnail( get_the_ID(), array( 90, 90 ) );
			$nestedData   = array();
			$nestedData[] = $image;
			$nestedData[] = get_post_type();
			$nestedData[] = '<a href="' . get_the_permalink() . '" alt="' . get_the_title() . '" target="_blank">' . get_the_title() . '</a>';
			$nestedData[] = get_field( 'author' );
			$nestedData[] = get_the_date( "m/d/Y" ) . '<br>' . get_the_date( "g:i A" );
			$nestedData[] = ( get_field( 'is_active' ) ? "Yes" : "No" );
			$nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-article?a_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#" class="' . $active_class . '" id="' . get_the_ID() . '">' . $active_text . '</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Article">Delete</a></li>
					    </ul>
					</div>';
			
			$data[] = $nestedData;
		}
		
		wp_reset_query();
		
		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalData ),
			"data"            => $data
		);
		
		echo json_encode( $json_data );
		
	} else {
		$json_data = array(
			"data" => array()
		);
		echo json_encode( $json_data );
	}
	wp_die();
}

add_action( 'wp_ajax_vendor_datatables', 'render_vendors' );
add_action( 'wp_ajax_nopriv_vendor_datatables', 'render_vendors' );

function render_vendors() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0 => 'companyName',
		1 => 'categories',
		2 => 'url_slug',
		3 => 'group',
		4 => 'premium',
		5 => 'isActive',
		6 => 'action'
	);
	
	$args = array(
		'post_type'      => 'vendor_profile',
		'posts_per_page' => $request['length'],
		'offset'         => $request['start'],
		'order'          => $request['order'][0]['dir']
	);
	
	if ( $request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 3 || $request['order'][0]['column'] == 5 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} elseif ( $request['order'][0]['column'] == 4 ) {
		$args['orderby'] = 'date';
	} else {
		$args['orderby'] = 'title';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['s'] = $request['search']['value'];
	}
	
	$vendor_query = new WP_Query( $args );
	$totalData    = $vendor_query->found_posts;
	
	if ( $vendor_query->have_posts() ) {
		$data = array();
		while ( $vendor_query->have_posts() ) {
			
			$vendor_query->the_post();
			$active_class = 'deactivate-post';
			$active_text  = 'Deactivate';
			if ( ! get_field( 'is_active' ) ) {
				$active_class = 'activate-post';
				$active_text  = 'Activate';
			}
			
			$nestedData   = array();
			$nestedData[] = '<a href="' . get_the_permalink() . '" alt="' . get_the_title() . '" target="_blank">' . get_the_title() . '</a>';
			$cats         = get_field( 'field_5ef380bcbbd1b' );
			$cat_array    = array();
			if ( $cats ) {
				foreach ( $cats as $cat ) {
					if ( $cat['category'] != '' ) {
						$category    = get_term( $cat['category'] );
						$cat_array[] = $category->name;
					}
				}
			}
			$nestedData[] = join( ', ', $cat_array );
			$nestedData[] = get_post_field( 'post_name' );
			$nestedData[] = get_field( 'group' ); // TODO: filter out individual taxonomy
			$nestedData[] = ''; // TODO: premium level for each category
			$nestedData[] = ( get_field( 'is_active' ) ? "Yes" : "No" );
			$nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-advertiser?ven_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#" class="' . $active_class . '" id="' . get_the_ID() . '">' . $active_text . '</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Vendor">Delete</a></li>
					    </ul>
					</div>';
			
			$data[] = $nestedData;
		}
		
		wp_reset_query();
		
		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalData ),
			"data"            => $data
		);
		
		echo json_encode( $json_data );
		
	} else {
		$json_data = array(
			"data" => array()
		);
		echo json_encode( $json_data );
	}
	wp_die();
}

add_action( 'wp_ajax_deactivate_post', 'my_ajax_deactivate_post' );
function my_ajax_deactivate_post() {
	$post_id = intval( $_POST['article_id'] );
	
	// this isn't a post. let's check to see if it's a category
	if ( get_term( $post_id, 'category' ) ) {
		// it's a category
		if ( get_term_meta( $post_id, 'is_active', true ) ) {
			// it's active
			update_term_meta( $post_id, 'is_active', false );
			$resp = array(
				'title'     => 'Activation Status',
				'content'   => 'Category was deactivated!',
				'post_type' => 'category'
			);
			wp_send_json( $resp );
			wp_die();
		}
	} else {
		// change the 'isActive' custom field to 'No' (aka false)
		if ( get_field( 'is_active', $post_id ) ) {
			update_field( 'is_active', false, $post_id );
		}
		$resp = array(
			'title'     => 'Activation Status',
			'content'   => 'Post was deactivated!',
			'post_type' => get_post_type( $post_id )
		);
		wp_send_json( $resp );
		wp_die();
	}
}

add_action( 'wp_ajax_activate_post', 'my_ajax_activate_post' );
function my_ajax_activate_post() {
	$post_id = intval( $_POST['article_id'] );
	
	// Let's check to see if it's a category
	if ( get_term( $post_id, 'category' ) ) {
		// it's a category
		if ( ! get_term_meta( $post_id, 'is_active', true ) ) {
			// it's not active
			update_term_meta( $post_id, 'is_active', true );
			$resp = array(
				'title'     => 'Activation Status',
				'content'   => 'Category was Activated!',
				'post_type' => 'category'
			);
			wp_send_json( $resp );
			wp_die();
		}
	} else {
		// change the 'isActive' custom field to 'Yes' (aka true)
		update_field( 'is_active', true, $post_id );
		$resp = array(
			'title'     => 'Activation Status',
			'content'   => 'Post was deactivated!',
			'post_type' => get_post_type( $post_id )
		);
		wp_send_json( $resp );
		wp_die();
	}
}

/* Get Post Type for Javascript */
add_action( 'wp_ajax_get_post_type', 'my_ajax_get_post_type' );
function my_ajax_get_post_type() {
	if ( in_array( get_post_type(), [ 'wedding_story', 'styled_shoot', 'post', 'spotlight' ] ) ) {
		$resp = array(
			'title'     => 'Post Type',
			'content'   => 'Found Article',
			'post_type' => get_post_type()
		);
		wp_send_json( $resp );
		wp_die();
	} else {
		$resp = array(
			'title'     => 'Post Type',
			'content'   => 'Not Wedding Story',
			'post_type' => get_the_ID()
		);
		wp_send_json( $resp );
		wp_die();
	}
}

/* Vendors Table Shortcode */
function vendor_table_func( $atts ) {
	$vtable = '<table id="vendor_table" class="dataTable compact display" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Company Name</th>
				<th>Categories</th>
				<th>URL Permalink</th>
				<th>Group</th>
				<th>Premium Level</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
	
	return $vtable;
}

add_shortcode( 'vendors_table', 'vendor_table_func' );

function article_table_func( $atts ) {
	return '<table id="article_table" class="dataTable compact display" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Thumbnail</th>
				<th>Type</th>
				<th>Title</th>
				<th>Author</th>
				<th>Post Date</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
}

add_shortcode( 'articles_table', 'article_table_func' );

function category_table_func( $atts ) {
	$table = '<table id="category_table" class="dataTable compact display responsive" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Name</th>
				<th>URL slug</th>
				<th>Keywords</th>
				<th>Description</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
	
	return $table;
}

add_shortcode( 'categories_table', 'category_table_func' );

add_action( 'wp_ajax_category_datatables', 'render_categories' );
add_action( 'wp_ajax_nopriv_category_datatables', 'render_categories' );

function render_categories() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0 => 'categoryName',
		1 => 'slug',
		2 => 'keywords',
		3 => 'description',
		4 => 'isActive',
		5 => 'action'
	);
	
	$args = array(
		'hide_empty' => 0,
		'order'      => $request['order'][0]['dir']
	);
	
	if ( $request['order'][0]['column'] == 0 || $request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 4 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} else {
		$args['orderby'] = 'title';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['search'] = $request['search']['value'];
	}
	
	// grab all categories to display on the table
	$categories = get_categories( $args );
	$totalData  = count( $categories );
	$data       = array(); // will store all nested data
	
	// check for offset and post limit
	$num_cats = $request['length'];
	$offset   = $request['start'];
	
	for ( $i = ( 0 + $offset ); $i < ( $num_cats + $offset ); $i ++ ) {
		if ( $i >= $totalData ) {
			break;
		} // don't keep going if we've reached the end
		$category       = $categories[ $i ];
		$nested_data    = array();
		$cid            = $category->term_id;
		$is_active      = get_term_meta( $cid, 'is_active', true );
		$nested_data[]  = $category->name;
		$nested_data[]  = $category->slug;
		$keyword_string = '';
		$keywords       = get_term_meta( $cid, 'meta_keywords', true );
		if ( count( $keywords ) > 0 ) {
			$keyword_arr = array();
			foreach ( $keywords as $keyword ) {
				$this_tag      = get_tag( $keyword );
				$keyword_arr[] = $this_tag->name;
			}
			$keyword_string = join( ', ', $keyword_arr );
		}
		$nested_data[] = $keyword_string;
		$nested_data[] = $category->description;
		$nested_data[] = ( $is_active ? "Yes" : "No" );
		$nested_data[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-category?cid=' . $cid . '">Edit</a></li>
							<li><a href="#" class="' . ( $is_active ? "deactivate-post" : "activate-post" ) . '" id="' . $cid . '">' . ( $is_active ? "Deactivate" : "Activate" ) . '</a></li>
							<li><a href="#">Delete</a></li>
					    </ul>
					</div>';
		$data[]        = $nested_data;
	}
	
	$json_data = array(
		"draw"            => intval( $request['draw'] ),
		"recordsTotal"    => $totalData,
		"recordsFiltered" => $totalData,
		"data"            => $data
	);
	echo json_encode( $json_data );
	
	wp_die();
}

function vendor_admin_form_func( $atts ) {
	if ( isset( $_GET['ven_id'] ) ) {
		$vendor_id = $_GET['ven_id'];
		$args      = array(
			'post_id'               => $vendor_id,
			'post_title'            => true,
			'updated_message'       => 'Advertiser successfully updated!',
			'instruction_placement' => 'field',
            'kses'                  => false
		);
		$html      = '<h2>' . get_the_title( $vendor_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'No advertiser selected. Head back to the <a href="/saw-admin/advertisers" alt="SAW Advertisers">Advertisers table</a> and try again!';
	}
	
}

add_shortcode( 'vendor_edit_form', 'vendor_admin_form_func' );

/* Change Advertiser Title label to 'Company Name' */
function change_post_title_name( $field ) {
	if ( is_page( array( 'add-advertiser', 'advertisers', 'edit-advertiser' ) ) ) { // if on the vendor page
		$field['label'] = 'Company Name';
	} elseif ( is_page( array( 'add-article', 'articles', 'edit-article' ) ) ) {
		$field['label'] = 'URL Title';
	} elseif ( is_page( array( 'add-special-offer', 'special-offers', 'edit-special-offer' ) ) ) {
		$field['label'] = 'Special Offer Title';
	}
	
	return $field;
}

add_filter( 'acf/load_field/name=_post_title', 'change_post_title_name' );

function vendor_admin_add_form_func( $atts ) {
	$args = array(
		'post_id'               => 'new_post',
		'post_title'            => true,
		'new_post'              => array(
			'post_type'   => 'vendor_profile',
			'post_status' => 'publish'
		),
		'submit_value'          => 'Create new Advertiser',
		'instruction_placement' => 'field',
		'return'                => '/saw-admin/edit-advertiser?ven_id=%post_id%',
		'uploader'              => 'basic'
	);
	ob_start();
	acf_form( $args );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

add_shortcode( 'vendor_add_form', 'vendor_admin_add_form_func' );

/* Auto-fill existing URL slug */
function acf_vendor_permalinks( $value, $post_id, $field ) {
	
	$possible_post_types = array(
		'vendor_profile'
	);
	if ( in_array( get_post_type( $post_id ), $possible_post_types ) && ! acf_is_empty( $value ) ) {
		
		$new_slug = sanitize_title( $value );
		
		wp_update_post( array(
				'ID'        => $post_id,
				'post_name' => $new_slug,
			)
		);
		return $new_slug;
	}
	
	return $value;
}

add_filter( 'acf/update_value/name=permalink_title', 'acf_vendor_permalinks', 10, 3 );

function edit_article_text() {
	if ( isset( $_GET['a_id'] ) ) {
		$article_id    = $_GET['a_id'];
		$post_type_obj = get_post_type_object( get_post_type( $article_id ) );
		
		return 'Edit ' . esc_html( $post_type_obj->labels->singular_name );
	} else {
		return 'Edit Article';
	}
}

add_shortcode( 'edit_article', 'edit_article_text' );

/* Add new Category SHORTCODE */
function category_admin_add_form_func( $atts ) {
	$args = array(
		'post_id'               => 'new_post',
		'field_groups'          => array( 6613, 6272 ), // 'Category Management' & 'Article Meta Info'
		'submit_value'          => 'Create new Category',
		'instruction_placement' => 'field',
		'updated_message'       => __( "Category updated", 'acf' )
	);
	ob_start();
	acf_form( $args );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

add_shortcode( 'category_add_form', 'category_admin_add_form_func' );

add_shortcode( 'category_edit_form', 'edit_category_admin' );
function edit_category_admin() {
	if ( isset( $_GET['cid'] ) ) {
		$cat_id = $_GET['cid'];
		
		$args = array(
			'post_id'               => 'category_' . $cat_id,
			'field_groups'          => array( 6613, 6272 ), // 'Category Management' & 'Article Meta Info'
			'submit_value'          => 'Update Category',
			'instruction_placement' => 'field',
			'updated_message'       => __( "Category updated", 'acf' )
		);
		ob_start();
		acf_form( $args );
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		return 'No category selected. Head back to the <a href="/saw-admin/categories" alt="SAW Categories">Category table</a> and try again!';
	}
}

/* Add extra fields to the category form dynamically */
add_filter( 'acf/pre_save_post', 'save_category', 10, 1 );

/* Create new Category Term when category form is submitted */
function save_category( $post_id ) {
	
	if ( is_page( array( 'add-category' ) ) ) {
		// Initialize a $cat_id variable to be used later
		$cat_id = 0;
		
		$acf_request = $_POST['acf'];
		
		$active           = ! empty( $acf_request['field_5ef7d204148f8'] ) ? $acf_request['field_5ef7d204148f8'] : 'empty1337';
		$category         = ! empty( $acf_request['field_5ef796a4e05bc'] ) ? $acf_request['field_5ef796a4e05bc'] : 'empty1337';
		$description      = ! empty( $acf_request['field_5ef79704e05be'] ) ? $acf_request['field_5ef79704e05be'] : 'empty1337';
		$title            = ! empty( $acf_request['field_5ef79755e05bf'] ) ? $acf_request['field_5ef79755e05bf'] : 'empty1337';
		$slug             = ! empty( $acf_request['field_5ef796e9e05bd'] ) ? $acf_request['field_5ef796e9e05bd'] : 'empty1337';
		$meta_title       = ! empty( $acf_request['field_5eebe30dbc34e'] ) ? $acf_request['field_5eebe30dbc34e'] : 'empty1337';
		$meta_keywords    = ! empty( $acf_request['field_5eebe335bc34f'] ) ? $acf_request['field_5eebe335bc34f'] : 'empty1337';
		$meta_description = ! empty( $acf_request['field_5eebe397bc350'] ) ? $acf_request['field_5eebe397bc350'] : 'empty1337';
		
		$args                = array();
		$args['description'] = ( $description != 'empty1337' ) ? $description : '';
		$args['slug']        = ( $slug != 'empty1337' ) ? $slug : '';
		
		$cat = wp_insert_term(
			$category,
			'category',
			$args
		);
		if ( is_wp_error( $cat ) ) {
			// saving went badly, and the category didn't update!
			print_r( 'wp_insert_term resulted in this error: ' . $cat_id );
			die();
		} else {
			$cat_id = $cat['term_id'];
			if ( $active != 'empty1337' ) {
				update_term_meta( $cat_id, 'is_active', $active );
			}
			if ( $title != 'empty1337' ) {
				update_term_meta( $cat_id, 'category_title', $title );
			}
			if ( $meta_title != 'empty1337' ) {
				update_term_meta( $cat_id, 'meta_title', $meta_title );
			}
			if ( $meta_description != 'empty1337' ) {
				update_term_meta( $cat_id, 'meta_description', $meta_description );
			}
			if ( $meta_keywords != 'empty1337' ) {
				update_term_meta( $cat_id, 'meta_keywords', $meta_keywords );
			}
			
			wp_redirect( '/saw-admin/edit-category?cid=' . $cat_id );
			exit;
		}
	} else if ( is_page( array( 'edit-category' ) ) ) {
		if ( isset( $_GET['cid'] ) ) {
			$cid         = $_GET['cid'];
			$acf_request = $_POST['acf'];
			$description = ! empty( $acf_request['field_5ef79704e05be'] ) ? $acf_request['field_5ef79704e05be'] : '';
			$args        = array( 'description' => $description );
			$slug        = ! empty( $acf_request['field_5ef796e9e05bd'] ) ? $acf_request['field_5ef796e9e05bd'] : '';
			if ( $slug != '' ) {
				$args['slug'] = $slug;
			}
			$name = ! empty( $acf_request['field_5ef796a4e05bc'] ) ? $acf_request['field_5ef796a4e05bc'] : '';
			if ( $name != '' ) {
				$args['name'] = $name;
			}
			wp_update_term( $cid, 'category', $args );
		}
		
		return $post_id;
	} else if ( is_page( array( 'add-home-slider', 'edit-home-slider' ) ) ) {
		// set the 'banner_name' as the post title
		$acf_request = $_POST['acf'];
		if ( isset( $_GET['hs_id'] ) ) {
			$hs_id = $_GET['hs_id'];
		} else {
			$hs_id = $post_id;
		}
		$home_slider = array(
			'ID'         => $hs_id,
			'post_title' => ! empty( $acf_request['field_5efaa2a3191c5'] ) ? $acf_request['field_5efaa2a3191c5'] : get_the_title( $hs_id )
		);
		wp_update_post( $home_slider );
		
		return $post_id; // return $post_id regardless
	} else {
		return $post_id;
	}
}


add_action( 'acf/save_post', 'delete_null_category_post' );
function delete_null_category_post( $post_id ) {
	if ( is_page( 'add-category' ) ) {
		// delete the resulting null post created when a category is created
		wp_delete_post( $post_id, true );
	}
}

add_filter( 'acf/load_value', 'fill_in_category', 10, 3 );
function fill_in_category( $value, $post_id, $field ) {
	if ( isset( $_GET['cid'] ) ) {
		$cid      = $_GET['cid'];
		$category = get_term( $cid, 'category' );
		
		switch ( $field['name'] ) {
			case 'is_active':
				if ( metadata_exists( 'term', $cid, 'is_active' ) ) {
					$is_active = get_term_meta( $cid, 'is_active', true );
				} else {
					$is_active = false;
				}
				
				return $is_active;
			case 'name':
				return $category->name;
			case 'category_title':
				return get_term_meta( $cid, 'category_title', true );
			case 'description':
				return $category->description;
			case 'slug':
				return $category->slug;
			case 'meta_title':
				return get_term_meta( $cid, 'meta_title', true );
			case 'meta_keywords':
				return get_term_meta( $cid, 'meta_keywords', true );
			case 'meta_description':
				return get_term_meta( $cid, 'meta_description', true );
			default:
				return $value;
		}
	} else {
		return $value;
	} // still have to return, even on the categories wp-admin page
}

function article_admin_form_func( $atts ) {
	if ( isset( $_GET['a_id'] ) ) {
		$article_id = $_GET['a_id'];
		$args       = array(
			'post_id'               => $article_id,
			'post_title'            => true,
			'updated_message'       => 'Article successfully updated!',
			'instruction_placement' => 'field'
		);
		$html       = '<h2>' . get_the_title( $article_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'No article selected. Head back to the <a href="/saw-admin/articles" alt="SAW Articles">Articles table</a> and try again!';
	}
	
}

add_shortcode( 'article_edit_form', 'article_admin_form_func' );

function vendor_article_add_form_func( $atts ) {
	if ( isset( $_GET['cpt'] ) ) {
		$article_type = $_GET['cpt'];
		$nice_name    = $article_type;
		switch ( $article_type ) {
			case "spotlight":
				$nice_name = "Featured Spotlight";
				break;
			case "styled_shoot":
				$nice_name = "Styled Shoot";
				break;
			case "wedding_story":
				$nice_name = "Wedding Story";
				break;
			case "post":
				$nice_name = "Blog Post";
				break;
			default:
				$nice_name = "n.a.";
				break;
		}
		$args = array(
			'post_id'               => 'new_post',
			'post_title'            => true,
			'new_post'              => array(
				'post_type'   => $article_type,
				'post_status' => 'publish'
			),
			'submit_value'          => 'Create new ' . $nice_name,
			'instruction_placement' => 'field',
			'return'                => '/saw-admin/edit-article?a_id=%post_id%'
		);
		$html = '<h2>Add a New ' . $nice_name . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		return 'Something went wrong - please try again!';
	}
}

add_shortcode( 'article_add_form', 'vendor_article_add_form_func' );

function vendor_url_func( $atts ) {
	if ( get_post_type() == 'vendor_profile' ) {
		$button_html = '<div class="saw-button"><a target="_blank" href="';
		$button_html .= get_field( 'website', get_the_ID() );
		$button_html .= '">Visit Our Website <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
		
		return $button_html;
	} else {
		return '';
	}
}

add_shortcode( 'vendor_url', 'vendor_url_func' );

// Display Article Content from Shortcode //
function article_content_func( $atts ) {
	$return_string = '';
	
	// We have the field - time to loop through
	if ( have_rows( 'article_content', get_the_ID() ) ):
		
		// Loop through rows.
		while ( have_rows( 'article_content', get_the_ID() ) ) : the_row();
			$return_string .= '<div class="article-content">';
			
			// Case: 1 column
			if ( get_row_layout() == '1_column_wide' ):
				$return_string .= '<div class="article-content-row col-one">';
				$column_one    = get_sub_field_object( 'column_content', get_the_ID() );
				$return_string .= '<div class="article-one-column">';
				$return_string .= process_row( $column_one['key'], get_the_ID() );
				$return_string .= '</div>';
				$return_string .= '</div>';
			// Case: 2 columns
            elseif ( get_row_layout() == '2_columns_equal' ):
				$return_string .= '<div class="article-content-row col-two">';
				$column_one    = get_sub_field_object( 'column_1' );
				$return_string .= '<div class="article-two-columns">';
				$return_string .= process_row( $column_one['key'], get_the_ID() );
				$return_string .= '</div>';
				$column_two    = get_sub_field_object( 'column_2' );
				$return_string .= '<div class="article-two-columns last">';
				$return_string .= process_row( $column_two['key'], get_the_ID() );
				$return_string .= '</div>';
				$return_string .= '</div>';
			
			// Case: 3 columns
            elseif ( get_row_layout() == '3_columns_equal' ):
				$return_string .= '<div class="article-content-row col-three">';
				$column_one    = get_sub_field_object( 'column_1' );
				$return_string .= '<div class="article-three-columns">';
				$return_string .= process_row( $column_one['key'], get_the_ID() );
				$return_string .= '</div>';
				$column_two    = get_sub_field_object( 'column_2' );
				$return_string .= '<div class="article-three-columns last">';
				$return_string .= process_row( $column_two['key'], get_the_ID() );
				$return_string .= '</div>';
				$column_three  = get_sub_field_object( 'column_3' );
				$return_string .= '<div class="article-three-columns last">';
				$return_string .= process_row( $column_three['key'], get_the_ID() );
				$return_string .= '</div>';
				$return_string .= '</div>';
			endif;
			
			// End loop.
			$return_string .= '</div>';
		endwhile;
		
		return $return_string;
	// No value.
	else :
		// No content to display in the story
		return 'No content to display!';
	endif;
}

add_shortcode( 'article_content', 'article_content_func' );

// process the above article-content more easily
function process_row( $field_key, $post_id ) {
	$return_string = '';
	if ( have_rows( $field_key, $post_id ) ) :
		while ( have_rows( $field_key, $post_id ) ) : the_row();
			switch ( get_row_layout() ) {
				case "blank_block":
					$return_string .= '<div class="article-blank-block"></div>';
					break;
				case "image_block":
					$image = get_sub_field( 'image' );
					if ( ! empty( $image ) ):
						$return_string .= '<div class="article-image-block">';
						$return_string .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
						$return_string .= '</div>';
					endif;
					break;
				case 'text_block':
					if ( get_sub_field( 'text' ) ):
						$return_string .= '<div class="article-text-block">';
						$return_string .= get_sub_field( 'text' );
						$return_string .= '</div>';
					endif;
					break;
				case 'video_block':
					if ( get_sub_field( 'video' ) ):
						$return_string .= '<div class="article-video-block embed-container">';
						ob_start();
						the_sub_field( 'video' );
						$return_string .= ob_get_contents();
						ob_end_clean();
						$return_string .= '</div>';
					endif;
					break;
			}
		endwhile;
	endif;
	
	return $return_string;
}

/**
 * Social Media Feed Display
 * display the tabbed fb, ig, pi social media block in the sidebar (and anywhere else!)
 *
 *
 * This function will return the field_key of a certain field.
 *
 * @param $atts array Array of attributes from the shortcode (default: null)
 *
 * @return String
 */
//
function social_media_tab_func( $atts ) {
	$fb_url = get_field( "facebook" );
	$pin_url = get_field( "pinterest" );
	$ig_url = get_field( "instagram" );
	
	$html   = '<div class="all-tabs-container">';
	$html   .= '<div id="social-tabs">';
	$html   .= '<span class="social-tabs-triangle"></span>
                <ul>';
    if( $fb_url ) { $html .= '<li><a href="#facebook">Facebook</a></li>'; }
    if( $pin_url ) { $html .= '<li><a href="#pinterest">Pinterest</a></li>'; }
    if( $ig_url ) { $html .= '<li><a href="#instagram">Instagram</a></li>'; }
                $html .= '</ul>';
	
	if( $fb_url ) {
        $html   .= '<div id="facebook" class="social-share-div"><div class="fb-page" data-href="' . $fb_url . '" data-tabs="timeline" data-width="" data-height="360" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="' . $fb_url . '" class="fb-xfbml-parse-ignore"><a href="' . $fb_url . '">' . get_the_title() . '</a></blockquote></div></div>';
    }
	if( $pin_url ) {
        $html   .= '<div id="pinterest" class="social-share-div"><a data-pin-do="embedUser" data-pin-board-width="100%" data-pin-scale-height="250" data-pin-scale-width="80" href="' . $pin_url . '"></a></div>';
    }
	if( $ig_url ) {
        $html   .= '<div id="instagram" class="social-share-div">Instagram content here.<br>And a new line.<br>Another.</div>';
    }
	$html   .= '</div></div>';
	$html   .= '<script type="text/javascript">
                jQuery( function() {
                    jQuery("#social-tabs").tabs({
                        event: "mouseover"
                    });
                    jQuery(".all-tabs-container").parent().parent().addClass("social-sidebar-tabs");
                });
              </script>';
	
	return $html;
}

add_shortcode( 'social_media_tab', 'social_media_tab_func' );

// Font Awesome Integration
/**
 * Font Awesome CDN Setup SVG
 *
 * This will load Font Awesome from the Font Awesome Free or Pro CDN.
 */
if ( ! function_exists( 'fa_custom_setup_cdn_svg' ) ) {
	function fa_custom_setup_cdn_svg( $cdn_url = '', $integrity = null ) {
		$matches                    = [];
		$match_result               = preg_match( '|/([^/]+?)\.js$|', $cdn_url, $matches );
		$resource_handle_uniqueness = ( $match_result === 1 ) ? $matches[1] : md5( $cdn_url );
		$resource_handle            = "font-awesome-cdn-svg-$resource_handle_uniqueness";
		
		foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
			add_action(
				$action,
				function () use ( $cdn_url, $resource_handle ) {
					wp_enqueue_script( $resource_handle, $cdn_url, [], null );
				}
			);
		}
		
		if ( $integrity ) {
			add_filter(
				'script_loader_tag',
				function ( $html, $handle ) use ( $resource_handle, $integrity ) {
					if ( in_array( $handle, [ $resource_handle ], true ) ) {
						return preg_replace(
							'/^<script /',
							'<script integrity="' . $integrity .
							'" defer crossorigin="anonymous"',
							$html,
							1
						);
					} else {
						return $html;
					}
				},
				10,
				2
			);
		}
	}
}
fa_custom_setup_cdn_svg(
	'https://use.fontawesome.com/releases/v5.13.0/js/all.js',
	'sha384-ujbKXb9V3HdK7jcWL6kHL1c+2Lj4MR4Gkjl7UtwpSHg/ClpViddK9TI7yU53frPN'
);

/**
 * Get field key for field name.
 * Will return first matched acf field key for a give field name.
 *
 * ACF somehow requires a field key, where a sane developer would prefer a human readable field name.
 * http://www.advancedcustomfields.com/resources/update_field/#field_key-vs%20field_name
 *
 * This function will return the field_key of a certain field.
 *
 * @param $field_name String ACF Field name
 * @param $post_id int The post id to check.
 *
 * @return bool
 */
function acf_get_field_key( $field_name, $post_id ) {
	global $wpdb;
	$acf_fields = $wpdb->get_results( $wpdb->prepare( "SELECT ID,post_parent,post_name FROM $wpdb->posts WHERE post_excerpt=%s AND post_type=%s", $field_name, 'acf-field' ) );
	// get all fields with that name.
	switch ( count( $acf_fields ) ) {
		case 0: // no such field
			return false;
		case 1: // just one result.
			return $acf_fields[0]->post_name;
	}
	// result is ambiguous
	// get IDs of all field groups for this post
	$field_groups_ids = array();
	$field_groups     = acf_get_field_groups( array(
		'post_id' => $post_id,
	) );
	foreach ( $field_groups as $field_group ) {
		$field_groups_ids[] = $field_group['ID'];
	}
	
	// Check if field is part of one of the field groups
	// Return the first one.
	foreach ( $acf_fields as $acf_field ) {
		if ( in_array( $acf_field->post_parent, $field_groups_ids ) ) {
			return $acf_fields[0]->post_name;
		}
	}
	
	return false;
}

/************ STYLED SHOOT VENDOR SHORTCODE *****************/
add_shortcode( 'styled_shoot_vendors', 'vendor_list_styled' );
function vendor_list_styled() {
	$html = '';
	if ( get_field( 'vendors' ) ) {
		$vendor_arr = array();
		while ( the_repeater_field( 'vendors' ) ) {
			$vendor_arr[] = array(
				'category_title' => get_sub_field( 'category_title' ),
				'vendor_name'    => ( get_sub_field( 'non-existing' ) ? get_sub_field( 'vendor_manual' ) : get_the_title( get_sub_field( 'vendor' ) ) ),
				'non_existing'   => ( get_sub_field( 'non-existing' ) ? true : false ),
				'link'           => get_field( 'website', get_sub_field( 'vendor' ) ),
				'id'             => get_sub_field( 'vendor' )
			);
		}
		$html .= '<ul>';
		sort( $vendor_arr );
		foreach ( $vendor_arr as $vendor ) {
			$html .= '<li><span style="text-transform: uppercase;">' . $vendor['category_title'] . '</span>';
			if ( $vendor['non_existing'] ) {
				$html .= '<br />' . $vendor['vendor_name'] . '</li>';
			} else {
				if ( $vendor['link'] != '' ) {
					$html .= '<br /><a href="' . get_permalink( $vendor['id'] ) . '" alt="' . $vendor['vendor_name'] . '">' . $vendor['vendor_name'] . '</a></li>';
				} else {
					$html .= '<br />' . $vendor['vendor_name'] . '</li>';
				}
			}
		}
		$html .= '</ul>';
	}
	
	return $html;
}

/************* STYLED SHOOT GALLERY ******************/
add_shortcode( 'article_head_1', 'render_article_head_one' );
add_shortcode( 'article_head_2', 'render_article_head_two' );
add_shortcode( 'article_header_image', 'render_article_header_image' );
function render_article_head_one() {
	if ( isset( $_GET['aid'] ) ) {
		return get_field( 'head_1', $_GET['aid'] );
	} else {
		return get_field( 'head_1', get_the_ID() );
	}
}

function render_article_head_two() {
	if ( isset( $_GET['aid'] ) ) {
		return get_field( 'head_2', $_GET['aid'] );
	} else {
		return get_field( 'head_2', get_the_ID() );
	}
}

function render_article_header_image() {
	if ( isset( $_GET['aid'] ) ) {
		$aid        = $_GET['aid'];
		$header_img = get_field( 'header_image', $aid );
		
		return '<img src="' . esc_url( $header_img['url'] ) . '" alt="' . esc_url( $header_img['alt'] ) . '" style="max-height:200px;float:right;border-right-width:4px;border-right-color:#ffffff;border-right-style:solid;" width="auto" />';
	} else {
	    $header_img = get_field('header_image');
	    if ($header_img) {
		    return '<img src="' . esc_url( $header_img['url'] ) . '" alt="' . esc_url( $header_img['alt'] ) . '" style="max-height:200px;float:right;border-right-width:4px;border-right-color:#ffffff;border-right-style:solid;" width="auto" />';
        }
		return '';
	}
}

add_shortcode( 'article_gallery', 'render_article_gallery' );
function render_article_gallery() {
	if ( isset( $_GET['aid'] ) ) {
		$aid = $_GET['aid'];
		
		$gallery = get_field( 'article_photo_gallery', $aid );
		if ( $gallery ) {
			$images_string = implode( ',', $gallery );
			$return_string = '';
			if ( function_exists( 'envira_dynamic' ) ) {
				ob_start();
				envira_dynamic( array(
					'id'     => 'custom-' . $aid,
					'images' => $images_string
				) );
				$return_string = ob_get_contents();
				ob_end_clean();
			}
			
			return $return_string;
		}
	}
	
	return '';
}

//add_filter( 'envira_gallery_pre_data', 'render_enviragallery', 10, 2 );
//function render_enviragallery( $data, $gallery_id ) {
//	if (is_page(array('styled-shoot-gallery','spotlight-gallery'))) {
//
//        if ( isset( $_GET['aid'] ) ) {
//            $aid    = $_GET['aid'];
//            $newdata = array();
//
//            // Don't lose the original gallery id and configuration
//            $newdata["id"]     = $data["id"];
//            $newdata["config"] = $data["config"];
//
//            // Get list of images from our ACF gallery field
//            $gallery   = get_field( 'article_photo_gallery', $aid );
//
//            // If we have some images loop around and populate a new data array
//            if ( is_array( $gallery ) ) {
//
//                foreach ( $gallery as $image ) {
//
//	                $newdata["gallery"][ $image["id"] ]["status"] = 'active';
//	                $newdata["gallery"][ $image["id"] ]["src"]    = $image["url"];
//	                $newdata["gallery"][ $image["id"] ]["title"]  = $image["title"];
//	                $newdata["gallery"][ $image["id"] ]["link"]   = $image["url"];
//	                $newdata["gallery"][ $image["id"] ]["alt"]    = $image["alt"];
//	                $newdata["gallery"][ $image["id"] ]["caption"] = $image["caption"];
//	                $newdata["gallery"][ $image["id"] ]["thumb"]  = $image["sizes"]["thumbnail"];
//
//                }
//            }
//            return $newdata;
//        }
//    } else {
//	    return $data;
//    }
//}

add_shortcode( 'styled_shoot_url', 'render_ss_url' );
function render_ss_url() {
	if ( get_post_type() == 'styled_shoot' ) {
		$button_html = '<div class="saw-button"><a href="';
		$button_html .= '/styled-shoot-gallery?aid=' . get_the_ID() . '" alt="View Styled Shoot">';
		$button_html .= 'View Styled Shoot Gallery <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
	} else if ( get_post_type() == 'wedding_story' ) {
		$button_html = '<div class="saw-button"><a href="';
		$button_html .= '/our-wedding-story-gallery?aid=' . get_the_ID() . '" alt="View Our Wedding Story Gallery">';
		$button_html .= 'View Our Wedding Story Gallery <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
	}
	
	return $button_html;
}

/************************** SPOTLIGHT PHOTO/GALLERY BUTTONS *************************************/
/******************* ONLY SHOW THESE BUTTONS IF EITHER OF THE TWO ACTUALLY EXIST ****************/
add_shortcode( 'spotlight_photo_gallery_buttons', 'render_photo_gallery_buttons' );
function render_photo_gallery_buttons() {
	// this is run on a Featured Spotlight page
	// ALWAYS going to show the vendor, only sometimes going to show a gallery (if there are any photos in it)
	
	$post_id = get_the_ID();
	
	// profile page button
	$vendor      = get_field( 'vendor', $post_id );
	$vendor_url  = get_permalink( $vendor );
	$return_html = '<div class="saw-button"><a href="' . $vendor_url . '" alt="' . $vendor->post_title . '">View Our Profile Page <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
	
	// gallery button, but check for gallery images first
	$gallery = get_field( 'article_photo_gallery', $post_id );
	if ( is_array( $gallery ) ) {
		$return_html .= '<div class="saw-button"><a href="/spotlight-gallery?aid=' . $post_id . '">View Our Gallery <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i>    </a></div>';
	}
	
	return $return_html;
}

add_shortcode( 'featured_spotlight_module', 'render_featured_spotlights' );
function render_featured_spotlights() {
	// grab 4 random featured spotlights and display:
	//  - image
	//  - title
	//  - read more link
	$args       = array(
		'post_type'      => 'spotlight',
		'orderby'        => 'rand',
		'posts_per_page' => 4,
		'meta_key'       => 'is_active',
		'meta_value'     => true
	);
	$count      = 1;
	$spotlights = get_posts( $args );
	$html       = '<div class="spotlight-widget-container">';
	foreach ( $spotlights as $spotlight ) {
		$extra_class = '';
		if ( $count == 4 ) {
			$extra_class = " last";
		}
		$html .= '<div class="individual-spotlight' . $extra_class . '">';
		$html .= '<div class="left-half">';
		if ( get_field( 'header_image', $spotlight->ID ) ) {
			$image = get_field( 'header_image', $spotlight->ID );
			$html  .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_url( $image['alt'] ) . '" />';
//                style="max-height:200px;float:right;border-right-width:4px;border-right-color:#ffffff;border-right-style:solid;"
		}
		$html .= '</div>';
		$html .= '<div class="right-half">';
		$html .= '<div class="title">' . get_the_title( $spotlight->ID ) . '</div>';
		$html .= '<div class="read-more"><a href="' . get_permalink( $spotlight->ID ) . '">Read More</a></div>';
		$html .= '</div>';
		$html .= '</div>';
		$count ++;
	}
	$html .= '</div>';
	
	return $html;
}

/********** HOMEPAGE HERO SLIDER **********/
add_shortcode( 'home_page_hero_slider', 'render_home_hero_slider' );
function render_home_hero_slider() {
	// grab each set of data for home sliders, depending on type
	$args         = array(
		'post_type'      => 'home_slide',
		'posts_per_page' => 5,
		'order'          => 'ASC',
		'meta_key'       => 'is_active',
		'meta_value'     => true
		// TODO: check for date and make sure it's not expired!
	);
	$home_sliders = get_posts( $args );
	
	$html  = '';
	$count = 1;
	$html  .= '<div class="home-slider-container swiper-container">';
	$html  .= '<div class="swiper-wrapper">';
	foreach ( $home_sliders as $slider ) {
		$view_count = get_field( 'view_count', $slider->ID );
		update_field( 'view_count', $view_count + 1, $slider->ID );
		update_field( 'last_viewed', date( "Y-m-d H:i:s" ), $slider->ID );
		$slide_type       = get_field( 'slide_style', $slider->ID ); // to decide what to include on this page
		$background_image = get_field( 'background_image', $slider->ID );
		$html             .= '<div class="swiper-slide slide hero-slide-' . $count . ' slide-type-' . $slide_type . '">';
		$html             .= '<div class="slide-content">'; // flex-column - THIS can get the background
		$html             .= '<div class="bg-image-layer" style="background-image:url(' . esc_url( $background_image['url'] ) . ');background-size:cover;">';
		$html             .= ( $slide_type == 2 ? '<div class="alpha-overlay">' : '' );
		// if slide type 1, add in the orange left side
		$html .= '<div class="left-side' . ( $slide_type == 1 ? ' orange-bg' : '' ) . '">';
		// parent text container to space things out flexily
		$html .= '<div class="hero-text-content below-hero-' . $slider->ID . '">';
		if ( $slide_type == 1 ) {
			// slide head 2 (if type 1)
			$html .= '<div class="head-2">';
			$html .= '<h3>' . get_field( 'head_2', $slider->ID ) . '</h3>';
			$html .= '</div>'; // end .head-2
		}
		// slide head 1 (w/border left)
		$html .= '<div class="head-1">';
		$html .= get_field( 'head_1', $slider->ID );
		$html .= '</div>'; // end .head-1
		if ( $slide_type == 1 ) {
			// subhead (if type 1)
			$html .= '<div class="subhead">';
			$html .= get_field( 'subhead', $slider->ID );
			$html .= '</div>'; // end .subhead
		}
		// photographer
		$html .= '<div class="photographer-credit">';
		$html .= ( get_field( 'photographer_credit', $slider->ID ) ? 'Photo: ' . get_field( 'photographer_credit', $slider->ID ) : '' );
		$html .= '</div>'; // end .photographer-credit
		// read more link
		$html .= '<div class="read-more saw-button">';
		$html .= '<a href="' . get_field( 'banner_url', $slider->ID ) . '" alt="' . get_field( 'banner_name', $slider->ID ) . '">Read More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a>';
		$html .= '</div>'; // end .read-more
		$html .= '</div>'; // end .hero-text-content
		$html .= '</div>'; // end .orange
		$html .= '</div>'; // end bg-image-layer
		$html .= '<div class="text-below-hero style-' . $slide_type . '" id="below-hero-' . $slider->ID . '"></div>';
		$html .= '</div>'; // end .slide-content.left-side
		$html .= ( $slide_type == 2 ? '</div>' : '' );
		$html .= '</div>'; // end .slide.hero-slide-1[2,3,4]
		// Add another div after the active slide to display text content underneath the image, at 767px and lower
		$count ++;
	}
	$html .= '</div>'; // end .swiper-wrapper
	$html .= '<div class="swiper-pagination"></div>';
	$html .= '</div>'; // end .swiper-container
	
	// add swiper js
	$html .= '<script type="text/javascript">
                    var heroSwiper = new Swiper(".swiper-container", {
                        autoplay: {
                            delay: 7500,
                            disableOnInteraction: false,
                            grabCursor: true,
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true
                        }
                    });
                    jQuery(".swiper-container").on("mouseenter", function()  {
                        heroSwiper.autoplay.stop();
                    }).on("mouseleave", function() {
                        heroSwiper.autoplay.start();
                    });
            </script>';
	
	return $html;
}

/********** HOMEPAGE LOCAL FAVES **********/
add_shortcode( 'homepage_local_faves', 'render_local_fave_grid' );
function render_local_fave_grid() {
	// get all Vendors who should be featured in this section
	$args        = array(
		'post_type'  => 'vendor_profile',
		'meta_key'   => 'local_fave_homepage',
		'meta_value' => 'yes',
        'posts_per_page' => 12,
        'orderby'      => 'rand'
	);
	$local_faves = get_posts( $args );
	$html = '<div class="swiper-container swiper-faves-container">';
	$html .= '<div class="local-faves-container swiper-wrapper">';
	foreach ( $local_faves as $local_fave ) {
		$html .= '<div class="individual-fave swiper-slide">';
		$html .= '<div class="local-fave-image">';
		$html .= get_the_post_thumbnail( $local_fave->ID, array( 500, 500 ) );
		$html .= '<a href="' . get_permalink( $local_fave ) . '"><div class="fave-image-overlay"></div></a>';
		$html .= '</div>'; // END .local-fave-image
		
		$html .= '<div class="fave-title-container">';
		$html .= '<a href="' . get_permalink( $local_fave ) . '"><h3>' . $local_fave->post_title . '</h3></a>';
		$html .= '</div>'; // END .fave-title-container
		$html .= '</div>'; // END .individual-fave
	}
	$html .= '</div>'; // END .local-faves-container
    $html .= '<div class="swiper-pagination swiper-pagination-faves"></div>';
    $html .= '<div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>';
    $html .= '</div>';
    
    /* Swiper JS Script */
    $html .= '<script type="text/javascript">
                var swiper = new Swiper(".swiper-faves-container", {
                    slidesPerView:4,
                    spaceBetween: "2.7%",
                    pagination: {
                        el: ".swiper-pagination-faves",
                        clickable: true
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev"
                    }
                });
              </script>';
	
	return $html;
}

/********** HOMEPAGE BLOG POSTS (BUZZ) **********/
add_shortcode( 'homepage_daily_buzz', 'render_blog_buzz' );
function render_blog_buzz() {
	// get all Vendors who should be featured in this section
	$args       = array(
		'post_type'      => 'post',
		'posts_per_page' => 4,
        'order_by'       => 'date',
        'order'          => 'DESC'
	);
	$blog_posts = get_posts( $args );
	
	$html = '<div class="local-faves-container home-buzz">';
	foreach ( $blog_posts as $post ) {
		$html  .= '<div class="individual-fave blog-buzz">';
		$html  .= '<div class="local-fave-image">';
		$image = get_field( 'header_image', $post->ID );
		$html  .= '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" />';
		$html  .= '<a href="' . get_permalink( $post ) . '"><div class="fave-image-overlay"></div></a>';
		$html  .= '</div>'; // END .local-fave-image
		
		$html .= '<div class="fave-title-container">';
		$html .= '<a href="' . get_permalink( $post ) . '"><h3>' . $post->post_title . '</h3></a>';
		$html .= '</div>'; // END .fave-title-container
		$html .= '</div>'; // END .individual-fave
	}
	$html .= '</div>'; // END .local-faves-container
	
	return $html;
}

/********** HOMEPAGE SPOTLIGHTS **********/
add_shortcode( 'homepage_featured_spotlights', 'render_homepage_spotlights' );
function render_homepage_spotlights() {
	// get all Vendors who should be featured in this section
	$args       = array(
		'post_type'      => 'spotlight',
		'posts_per_page' => 8,
		'orderby'        => 'rand'
	);
	$spotlights = get_posts( $args );
	$count      = 0;
	$html       = '<div class="local-faves-container spotlight">';
	foreach ( $spotlights as $spotlight ) {
		if ( $count % 4 == 0 ) {
			$html .= '</div><div class="local-faves-container spotlight">';
		}
		$html .= '<div class="individual-fave spotlight">';
		$html .= '<div class="local-fave-image">';
		$html .= get_the_post_thumbnail( $spotlight->ID, array( 500, 500 ) );
		$html .= '<a href="' . get_permalink( $spotlight ) . '"><div class="fave-image-overlay"></div></a>';
		$html .= '</div>'; // END .local-fave-image
		
		$html .= '<div class="fave-title-container">';
		$html .= '<a href="' . get_permalink( $spotlight ) . '"><h3>' . $spotlight->post_title . '</h3></a>';
		$html .= '</div>'; // END .fave-title-container
		$html .= '</div>'; // END .individual-fave
		$count ++;
	}
	$html .= '</div>'; // END .local-faves-container
	
	return $html;
}

/********************************* HOME SLIDER TABLE IN SAW ADMIN ************************************/
add_shortcode( 'home_slider_table', 'render_home_slider_table' );
function render_home_slider_table() {
	$hstable = '<table id="home_slider_table" class="dataTable compact display" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Banner</th>
				<th>Banner Name</th>
				<th>Post Date</th>
				<th>Is Featured?</th>
				<th>End Featured Date</th>
				<th>View Count &<br />Last Viewed</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
	
	return $hstable;
}

/********************************* AJAX FOR HOME SLIDER TABLE ************************************/
add_action( 'wp_ajax_homeslide_datatables', 'render_home_sliders' );
add_action( 'wp_ajax_nopriv_homeslide_datatables', 'render_home_sliders' );

function render_home_sliders() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0 => 'banner',
		1 => 'bannerName',
		2 => 'postDate',
		3 => 'isFeatured',
		4 => 'endFeaturedDate', // featured_release_date - when the banner is no longer featured
		5 => 'viewCountLastViewed',
		6 => 'isActive',
		7 => 'action'
	);
	
	$args = array(
		'post_type'      => 'home_slide',
		'posts_per_page' => $request['length'],
		'offset'         => $request['start'],
		'order'          => $request['order'][0]['dir']
	);
	
	if ( $request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 5 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} elseif ( $request['order'][0]['column'] == 2 || $request['order'][0]['column'] == 3 ) {
		$args['orderby'] = 'date';
	} else {
		$args['orderby'] = 'title';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['s'] = $request['search']['value'];
	}
	
	$home_slide_query = new WP_Query( $args );
	$totalData        = $home_slide_query->found_posts;
	
	if ( $home_slide_query->have_posts() ) {
		$data = array();
		while ( $home_slide_query->have_posts() ) {
			
			$home_slide_query->the_post();
			$active_class = 'deactivate-post';
			$active_text  = 'Deactivate';
			if ( ! get_field( 'is_active' ) ) {
				$active_class = 'activate-post';
				$active_text  = 'Activate';
			}
			
			$nestedData   = array();
			$bg_image     = get_field( 'background_image' );
			$nestedData[] = '<img src="' . $bg_image['url'] . '" />'; // background image
			$nestedData[] = get_field( 'banner_name' ); // banner name
			$nestedData[] = get_field( 'banner_start_date' ); // post date
			$nestedData[] = ( get_field( 'is_slide_featured' ) == true ? 'Yes' : 'No' );
			$nestedData[] = ( get_field( 'banner_end_date' ) ? get_field( 'banner_end_date' ) : 'N.A.' ); // featured release date
			$nestedData[] = '<strong>' . get_field( 'view_count' ) . '</strong><br />' . ( get_field( 'last_viewed' ) ? get_field( 'last_viewed' ) : 'N.A.' ); // view count
			$nestedData[] = ( get_field( 'is_active' ) ? "Yes" : "No" );
			$nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-home-slider?hs_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#" class="' . $active_class . '" id="' . get_the_ID() . '">' . $active_text . '</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Slide">Delete</a></li>
					    </ul>
					</div>';
			
			$data[] = $nestedData;
		}
		
		wp_reset_query();
		
		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalData ),
			"data"            => $data
		);
		
		echo json_encode( $json_data );
		
	} else {
		$json_data = array(
			"data" => array()
		);
		echo json_encode( $json_data );
	}
	wp_die();
}

/********************************* ADD HOME SLIDERS IN SAW ADMIN ************************************/
add_shortcode( 'home_slider_add_form', 'render_add_home_slider' );
function render_add_home_slider() {
	$args = array(
		'post_id'               => 'new_post',
		'new_post'              => array(
			'post_type'   => 'home_slide',
			'post_status' => 'publish'
		),
		'submit_value'          => 'Create new Home Slider',
		'instruction_placement' => 'field',
		'return'                => '/saw-admin/edit-home-slider?$hs_id=%post_id%'
	);
	ob_start();
	acf_form( $args );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

/********************************* HOME SLIDER TABLE IN SAW ADMIN ************************************/
add_shortcode( 'home_slider_edit_form', 'render_edit_home_slider' );
function render_edit_home_slider() {
	if ( isset( $_GET['hs_id'] ) ) {
		$hs_id = $_GET['hs_id'];
		$args  = array(
			'post_id'               => $hs_id,
			'updated_message'       => 'Home Slider successfully updated!',
			'instruction_placement' => 'field'
		);
		$html  = '<h2>' . get_the_title( $hs_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'No home slider selected. Head back to the <a href="/saw-admin/home-sliders" alt="SAW Home Sliders">Home Sliders table</a> and try again!';
	}
}

/********************************* SPECIAL OFFER TABLE IN SAW ADMIN ************************************/
add_shortcode( 'special_offers_table', 'render_special_offer_table' );
function render_special_offer_table() {
	$sotable = '<table id="special_offer_table" class="dataTable compact display" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Vendor Name</th>
				<th>Special Offer Name</th>
				<th>Start Date & Time</th>
				<th>End Date</th>
				<th>View Count &<br />Last Viewed</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
	
	return $sotable;
}

/********************************* AJAX FOR HOME SLIDER TABLE ************************************/
add_action( 'wp_ajax_special_offer_datatables', 'render_special_offers' );
add_action( 'wp_ajax_nopriv_special_offer_datatables', 'render_special_offers' );

function render_special_offers() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0 => 'vendorName',
		1 => 'specialOfferName',
		2 => 'startDate',
		3 => 'endDate',
		4 => 'viewCountLastViewed',
		5 => 'isActive',
		6 => 'action'
	);
	
	$args = array(
		'post_type'      => 'special_offers',
		'posts_per_page' => $request['length'],
		'offset'         => $request['start'],
		'order'          => $request['order'][0]['dir']
	);
	
	if ( $request['order'][0]['column'] == 0 || $request['order'][0]['column'] == 1 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} elseif ( $request['order'][0]['column'] == 2 || $request['order'][0]['column'] == 3 ) {
		$args['orderby'] = 'date';
	} else {
		$args['orderby'] = 'title';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['s'] = $request['search']['value'];
	}
	
	$special_offer_query = new WP_Query( $args );
	$totalData           = $special_offer_query->found_posts;
	
	if ( $special_offer_query->have_posts() ) {
		$data = array();
		while ( $special_offer_query->have_posts() ) {
			
			$special_offer_query->the_post();
			$active_class = 'deactivate-post';
			$active_text  = 'Deactivate';
			if ( ! get_field( 'is_active' ) ) {
				$active_class = 'activate-post';
				$active_text  = 'Activate';
			}
			
			$nestedData   = array();
			$vendor       = get_field( 'vendor' );
			$nestedData[] = $vendor->post_title; // Vendor Name
			$nestedData[] = get_the_title(); // Special Offer Name
			$nestedData[] = get_field( 'offer_start_date' ); // start date
			$nestedData[] = get_field( 'offer_end_date' ); // end date
			$nestedData[] = '<strong>' . get_field( 'view_count' ) . '</strong><br />' . ( get_field( 'last_viewed' ) ? get_field( 'last_viewed' ) : 'N.A.' ); // view count
			$nestedData[] = ( get_field( 'is_active' ) ? "Yes" : "No" );
			$nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-special-offer?so_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#" class="' . $active_class . '" id="' . get_the_ID() . '">' . $active_text . '</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Special Offer">Delete</a></li>
					    </ul>
					</div>';
			
			$data[] = $nestedData;
		}
		
		wp_reset_query();
		
		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalData ),
			"data"            => $data
		);
		
		echo json_encode( $json_data );
		
	} else {
		$json_data = array(
			"data" => array()
		);
		echo json_encode( $json_data );
	}
	wp_die();
}

/********************************* EDIT SPECIAL OFFER IN SAW ADMIN ************************************/
add_shortcode( 'special_offer_edit_form', 'render_edit_special_offer' );
function render_edit_special_offer() {
	if ( isset( $_GET['so_id'] ) ) {
		$so_id = $_GET['so_id'];
		$args  = array(
			'post_id'               => $so_id,
			'updated_message'       => 'Special Offer successfully updated!',
			'instruction_placement' => 'field',
			'post_title'            => true
		);
		$html  = '<h2>' . get_the_title( $so_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'No special offer selected. Head back to the <a href="/saw-admin/special-offers" alt="SAW Special Offers">Special Offers table</a> and try again!';
	}
}

/********************************* ADD SPECIAL OFFERS IN SAW ADMIN ************************************/
add_shortcode( 'special_offer_add_form', 'render_add_special_offer' );
function render_add_special_offer() {
	$args = array(
		'post_id'               => 'new_post',
		'new_post'              => array(
			'post_type'   => 'special_offers',
			'post_status' => 'publish'
		),
		'submit_value'          => 'Create new Special Offer',
		'instruction_placement' => 'field',
		'return'                => '/saw-admin/edit-special-offer?$so_id=%post_id%',
		'post_title'            => true,
	
	);
	ob_start();
	acf_form( $args );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

/********************************* SAVE POST TITLE IN HOME SLIDERS ************************************/
/******** This is taken care of in the 'save_category' method above, where it will check for the 'add-home-slider' page **/


/********************************* TODO: START OF BANNER AD ADMIN SECTION!!!!!! ************************************/
/********************************* BANNERS TABLE IN SAW ADMIN ************************************/
add_shortcode( 'banner_ad_table', 'render_banner_table' );
function render_banner_table() {
	$batable = '<table id="banner_ad_table" class="dataTable compact display" data-page-length="30">
	    <thead>
	        <tr>
	            <th>Banner</th>
				<th>Banner Name</th>
				<th>Banner Size</th>
				<th>Advertiser Name</th>
				<th>Categories</th>
				<th>Start Date</th>
				<th>Stop Date</th>
				<th>View Count &<br />Last Viewed</th>
				<th>Exposure Level</th>
				<th>Is Active?</th>
				<th>Action</th>
	        </tr>
	    </thead>
	</table>';
	
	return $batable;
}

/********************************* AJAX FOR HOME SLIDER TABLE ************************************/
add_action( 'wp_ajax_banner_datatables', 'render_banner_ads' );
add_action( 'wp_ajax_nopriv_banner_datatables', 'render_banner_ads' );

function render_banner_ads() {
	
	header( "Content-Type: application/json" );
	
	$request = $_GET;
	
	$columns = array(
		0  => 'banner',
		1  => 'bannerName',
		2  => 'bannerSize',
		3  => 'advertiserName',
		4  => 'categories',
		5  => 'startDate',
		6  => 'stopDate',
		7  => 'viewCountLastViewed',
		8  => 'exposureLevel',
		9  => 'isActive',
		10 => 'action'
	);
	
	$args = array(
		'post_type'      => 'banner',
		'posts_per_page' => $request['length'],
		'offset'         => $request['start'],
		'order'          => $request['order'][0]['dir']
	);
	/* TODO: CHANGE THESE TO HEADERS FOR THE BANNER AD CPT */
	if ( $request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 2 || $request['order'][0]['column'] == 3 || $request['order'][0]['column'] == 5 || $request['order'][0]['column'] == 6 || $request['order'][0]['column'] == 8 || $request['order'][0]['column'] == 9 ) {
		$args['orderby'] = $columns[ $request['order'][0]['column'] ];
	} else {
		$args['orderby'] = 'title';
	}
	
	//$request['search']['value'] <= Value from search
	if ( ! empty( $request['search']['value'] ) ) { // When datatables search is used
		$args['s'] = $request['search']['value'];
	}
	
	$banner_ad_query = new WP_Query( $args );
	$totalData       = $banner_ad_query->found_posts;
	
	if ( $banner_ad_query->have_posts() ) {
		$data = array();
		while ( $banner_ad_query->have_posts() ) {
			
			$banner_ad_query->the_post();
			$active_class = 'deactivate-post';
			$active_text  = 'Deactivate';
			if ( ! get_field( 'is_active' ) ) {
				$active_class = 'activate-post';
				$active_text  = 'Activate';
			}
			
			$nestedData   = array();
			$banner_image = get_field( 'ad_banner', get_the_ID() );
			$nestedData[] = '<img src="' . $banner_image['url'] . '" />'; // banner ad image
			$nestedData[] = get_field( 'banner_name', get_the_ID() ); // banner name
			$nestedData[] = get_field( 'banner_size', get_the_ID() ); // banner size
			$advertiser   = get_field( 'advertiser' ); // grabbing the post object of the vendor
			$nestedData[] = $advertiser->post_title; // advertiser name
			
			// Grab categories from "Premium Listing" section from vendor CPT
			$categories = get_field( 'premium_listings', $advertiser->ID );
			if ( is_array( $categories ) ) {
				$category_names = '';
				$count          = 1;
				foreach ( $categories as $category ) {
					$this_cat = get_term( $category['category'], 'category' );
					if ( $count != sizeof( $categories ) ) {
						$category_names = $this_cat->name . ', ';
						
					} else {
						$category_names = $this_cat->name;
					}
					$count ++;
				}
				$nestedData[] = $category_names;
			} else {
				$nestedData[] = '';
			}
			
			$nestedData[] = get_field( 'banner_start_date' ); // startDate
			$nestedData[] = get_field( 'banner_stop_date' ); // stopDate
			$nestedData[] = get_field( 'view_count', get_the_ID() ) . '<br />(' . ( get_field( 'last_viewed' ) ? get_field( 'last_viewed' ) : 'N.A.' ) . ')'; // view count
			$nestedData[] = get_field( 'exposure_level' ) . 'X';
			$nestedData[] = ( get_field( 'is_active' ) ? "Yes" : "No" );
			$nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-banner-ad?ba_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#" class="' . $active_class . '" id="' . get_the_ID() . '">' . $active_text . '</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Banner Ad">Delete</a></li>
					    </ul>
					</div>';
			
			$data[] = $nestedData;
		}
		
		wp_reset_query();
		/* TODO: CHANGE THESE TO HEADERS FOR THE BANNER AD CPT */
		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalData ),
			"data"            => $data
		);
		
		echo json_encode( $json_data );
		
	} else {
		$json_data = array(
			"data" => array()
		);
		echo json_encode( $json_data );
	}
	wp_die();
}

/********************************* ADD BANNER ADS IN SAW ADMIN ************************************/
add_shortcode( 'banner_ad_add_form', 'render_add_banner_ad' );
function render_add_banner_ad() {
	
	$args = array(
		'post_id'               => 'new_post',
		'new_post'              => array(
			'post_type'   => 'banner',
			'post_status' => 'publish'
		),
		'submit_value'          => 'Create new Banner Ad',
		'instruction_placement' => 'field',
		'return'                => '/saw-admin/edit-banner-ad?$ba_id=%post_id%'
	);
	ob_start();
	acf_form( $args );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

/********************************* SAVE POST TITLE IN BANNER ADS ************************************/
/******** This is taken care of in the 'save_category' method above, where it will check for the 'add-banner-ad' page **/


/********************************* BANNER AD TABLE IN SAW ADMIN ************************************/
add_shortcode( 'banner_ad_edit_form', 'render_edit_banner_ad' );
function render_edit_banner_ad() {
	
	if ( isset( $_GET['ba_id'] ) ) {
		$hs_id = $_GET['ba_id'];
		$args  = array(
			'post_id'               => $hs_id,
			'updated_message'       => 'Banner Ad successfully updated!',
			'instruction_placement' => 'field'
		);
		$html  = '<h2>' . get_the_title( $hs_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'No banner ad selected. Head back to the <a href="/saw-admin/banner-ads" alt="SAW Banner Ads">Banner Ads table</a> and try again!';
	}
}

/************************ SPOTLIGHT VENDOR INFORMATION **********************/
add_shortcode( 'spotlight_vendor_information', 'render_spotlight_vendor' );
function render_spotlight_vendor() {
	
	// Get the linked vendor and print:
	// 1. 'View Vendor Profile' SAW link
	// 2. Phone number
	// 3. Address
	// 4. Website Link
	$vendor = get_field( 'vendor' );
	
	$html    = '<div class="spotlight-vendor-info-container">';
	$html    .= '<div class="vendor-profile-link">';
	$html    .= '<i class="fas fa-info-circle"></i><span><a href="' . get_the_permalink( $vendor ) . '" alt="' . $vendor->post_title . '">View Vendor Profile</a></span>';
	$html    .= '</div>';
	$html    .= '<div class="vendor-phone-number">';
	$html    .= '<i class="fas fa-phone-alt"></i><span><a href="tel:' . get_field( 'business_phone_number', $vendor->ID ) . '">' . get_field( 'business_phone_number', $vendor->ID ) . '</a></span>';
	$html    .= '</div>';
	$address = get_field( 'address', $vendor->ID );
	if ( $address ) {
		$html .= '<div class="vendor-address">';
		$html .= '<i class="fas fa-map-marker-alt"></i>';
		if ( ! empty( $address['address_line_1'] ) ) {
			$html .= $address['address_line_1'];
		}
		if ( ! empty( $address['address_line_2'] ) ) {
			$html .= ', ' . $address['address_line_2'];
		}
		if ( ! empty( $address['city'] ) ) {
			$html .= ', ' . $address['city'];
		}
		if ( ! empty( $address['state'] ) ) {
			$html .= ', ' . $address['state'];
		}
		if ( ! empty( $address['zip'] ) ) {
			$html .= ' ' . $address['zip'];
		}
		$html .= '</div>';
	}
	$website = get_field( 'website', $vendor->ID );
	if ( ! empty( $website ) ) {
		$html .= '<div class="vendor-website">';
		$html .= '<i class="fas fa-globe"></i>';
		$html .= '<a href="' . $website . '" alt="' . $vendor->post_title . '" target="_blank">Website</a>';
		$html .= '</div>';
	}
	$html .= '</div>';
	
	return $html;
}

/******************** VENDORS FOOTER MENU SHORTCODE ********************/
add_shortcode( 'vendors_footer_menu', 'render_vendors_footer' );
function render_vendors_footer() {
	// Only get vendor categories that currently have something in them - don't want pages showing up with no results!
	global $wpdb;
	
	$query             = $wpdb->prepare(
		"SELECT t.*, COUNT(*) from $wpdb->terms AS t
        INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
        INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
        WHERE p.post_type = 'vendor_profile' AND tt.taxonomy = 'category'
        GROUP BY t.term_id"
	);
	$vendor_categories = $wpdb->get_results( $query );
//	print_r($vendor_categories);die();
	
	$html =
		'<div id="vendor-footer-menu" class="hamburger-button">
            <div class="icon-container">
                <a class="hamburger-click" href="#"><img class="hamburger-icon" src="' . plugins_url( 'public/img/vendors-hamburger-menu.svg', __FILE__ ) . '" alt="Vendor Menu" width=45 height=auto /></a>
                <div class="icon-link-cover"></div>
            </div> <!-- END .icon-container -->
            <div class="vendor-list-container">
                <ul class="vendor-mega-menu">
                <p>Choose a Vendor Category</p>';
	// render each individual vendor
	foreach ( $vendor_categories as $vendor_category ) {
		$category_name = $vendor_category->name;
		$html          .= '<li>';
		$html          .= '<a href="/category/' . $vendor_category->slug . '" alt="' . $category_name . '">' . $category_name . '</a>';
		$html          .= '</li>';
	}
	$html .= '</ul>
            </div> <!-- END .vendor-list-container -->
        </div>'; // END #vendor-footer-menu
	
	return $html;
}

/******************** STAY CONNECTED FOOTER MENU SHORTCODE ********************/
add_shortcode( 'stay_connected', 'render_stay_connected_footer' );
function render_stay_connected_footer() {
	$html =
		'<div id="footer-stay-connected">
            <div class="red-container">
                <img class="arrows-up" src="' . plugins_url( 'public/img/arrows-up.svg', __FILE__ ) . '" alt="Stay Connected" />
                <span class="stay-connected-text">
                    Stay<br />Connected
                </span><!-- END .stay-connected-text -->
            </div> <!-- END .red-container -->
            <div class="pop-up-social">
                <div class="social-share-footer-content">
                    <div class="social-share-footer-title">Stay Connected</div>
                    <div class="all-tabs-container">
                        <div id="footer-social-tabs">
                            <span class="social-tabs-triangle"></span>
                            <ul>
                                <li><a href="#facebook">Facebook</a></li>
                                <li><a href="#pinterest">Pinterest</a></li>
                                <li><a href="#instagram">Instagram</a></li>
                            </ul>
        
                            <div id="facebook" class="social-share-div">
                                <div class="fb-page" data-href="https://www.facebook.com/SanAntonioWeddings/" data-tabs="timeline" data-width="259" data-height="359" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                    <blockquote cite="https://www.facebook.com/SanAntonioWeddings/" class="fb-xfbml-parse-ignore">
                                        <a href="https://www.facebook.com/SanAntonioWeddings/"></a>
                                    </blockquote>
                                </div>
                            </div>
                            <div id="pinterest" class="social-share-div">
                                <a data-pin-do="embedUser" data-pin-board-width="100%" data-pin-scale-height="242" data-pin-scale-width="80" href="https://www.pinterest.com/sanantonioweddings/"></a>
                            </div>
                            <div id="instagram" class="social-share-div">Instagram content here.<br>And a new line.<br>Another.</div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            jQuery( function() {
                                jQuery("#footer-social-tabs").tabs({
                                    event: "mouseover"
                                });
                                jQuery(".all-tabs-container").parent().addClass("social-sidebar-tabs");
                            });
                        </script>
                    </div>
                </div> <!-- END .vendor-social-sidebar-content -->
            </div>
            <script type="text/javascript">
                jQuery(".press-social-slider .share-tab").on("click", function () {
                        jQuery(this).parent().toggleClass("visible");
                    }
                );
            </script>'; // END #footer-stay-connected
	
	return $html;
}

add_shortcode('share_slide_out', 'render_share_slide_out');
function render_share_slide_out() {
	$html = '<div class="press-social-slider">
        <div class="share-tab">Share</div>
        <div class="icon-container">
            <img class="facebook-share" src="' . esc_url( plugins_url( 'public/img/Social-Media-Icons-SAW-FB.png', __FILE__ ) ) . '" alt="facebook-share">
            <img class="instagram-share" src="' . esc_url( plugins_url( 'public/img/Social-Media-Icons-SAW-Instagram.png', __FILE__ ) ) . '" alt="instagram-share">
            <img class="pinterest-share" src="' . esc_url( plugins_url( 'public/img/Social-Media-Icons-SAW-Pinterest.png', __FILE__ ) ) . '" alt="pinterest-share">
        </div>
    </div>';
	return $html;
}

add_shortcode("prev_next_navigation", "render_prev_next_navigation");
function render_prev_next_navigation() {
    $html = '<a href="' . get_previous_post_link() . '">\<Previous</a>';
	$html .= ' <a href="' . get_next_post_link() . '">Next\></a>';
    return $html;
}

add_shortcode('logout_button', 'render_logout_button');
function render_logout_button() {
    return '<a class="logout-button" href="' . wp_logout_url('/') . '" alt="Logout">Logout</a>';
}
