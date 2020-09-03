<?php
/**
 * @package FN_Extras
 * @version 1.2.5
 */

define( 'FRIDAY_NEXT_EXTRAS_VERSION', '1.2.5' );

/*** Ensuring AJAX Requests use SSL ****/
add_filter( 'https_local_ssl_verify', '__return_true' );

/********************* ACF JSON *********************/
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
function my_acf_json_save_point( $path ) {
	// update path
	$path = dirname( __FILE__ ) . '/private/acf-json';
	
	// return
	return $path;
}

add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
function my_acf_json_load_point( $paths ) {
	// remove original path (optional)
	unset( $paths[0] );
	
	// append path
	$paths[] = dirname( __FILE__ ) . '/private/acf-json';
	
	// return
	return $paths;
}

/* Remove admin bar for editors (Actually, EVERYONE - need to do a check later for only editors) */
if ( isset( wp_get_current_user()->ID ) && is_array( wp_get_current_user()->roles ) ) {
	//check for admins
	if ( in_array( 'vendor', wp_get_current_user()->roles ) || in_array( 'editor', wp_get_current_user()->roles ) ) {
		// redirect them to the default place
		show_admin_bar( false );
	}
}

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
	wp_register_style( 'fn_default_styles', plugins_url( 'public/css/default-min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'fn_default_styles' );
	wp_register_style( 'swiper_style', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'swiper_style' );
	wp_register_style( 'header_style', plugins_url( 'public/css/header-min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'header_style' );
	wp_register_style( 'footer_style', plugins_url( 'public/css/footer.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'footer_style' );
	wp_register_style( 'archive_style', plugins_url( 'public/css/archive-min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'archive_style' );
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
	
	wp_register_style( 'client-admin-styles', plugins_url( 'public/css/client-admin-min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'client-admin-styles' );
	// TODO: Only render these styles for the article pages!
	wp_register_style( 'article_styles', plugins_url( 'public/css/article-min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
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
		wp_register_style( 'vendor_profile_style', plugins_url( 'public/css/vendor-profile.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
		wp_enqueue_style( 'vendor_profile_style' );
	}
	// Homepage
	if ( is_page( 'home' ) ) {
		wp_register_style( 'homepage_style', plugins_url( 'public/css/homepage.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
		wp_enqueue_style( 'homepage_style' );
	}
	wp_register_style( 'jpopup', plugins_url( 'public/css/jpopup.min.css', __FILE__ ), array(), FRIDAY_NEXT_EXTRAS_VERSION );
	wp_enqueue_style( 'jpopup' );
}

//*********************************  WP_ENQUEUE_SCRIPTS *******************************//
function fn_enqueue_scripts() {
	// Scripts
	wp_register_script( 'facebook_share', 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0', array(), null, true );
//    wp_enqueue_script( 'facebook_share' );
	wp_register_script( 'pinterest_share', '//assets.pinterest.com/js/pinit.js', array(), null, true );
//    wp_enqueue_script( 'pinterest_share' );
	
	// For jQuery Tables on Admin pages
	//   TODO: Do a check for what page we're on, and only enqueue these if we're in the admin section!!!
	wp_register_script( 'datatables_script', '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array(), null, true );
	wp_register_script( 'datatables_buttons_script', '//cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js', array(), null, true );
	wp_localize_script( 'datatables_script', 'datatablesajax', array( 'url' => admin_url( 'admin-ajax.php?action=article_datatables' ) ) );
	wp_enqueue_script( 'datatables_script' );
	wp_enqueue_script( 'datatables_buttons_script' );
	wp_register_script( 'jpopup_modal', plugins_url( 'public/js/jpopup.min.js', __FILE__ ) );
	
	// Just for the Vendor Profile Page (save bandwidth elsewhere)
	if ( get_post_type() == 'vendor_profile' || is_page( 'client-admin' ) ) {
		wp_register_script( 'swiper_slider', '//unpkg.com/swiper/swiper-bundle.min.js', array(), null, false );
		wp_register_script( 'popper', '//unpkg.com/@popperjs/core@2', array(), null, true );
		wp_register_script( 'micromodal', plugins_url( 'public/js/micromodal.min.js', __FILE__ ), array(), null, true );
		wp_register_script( 'sticky_bits', plugins_url( 'public/js/jquery.stickybits.min.js', __FILE__ ), array(
			'swiper_slider',
			'micromodal',
			'jquery-ui-tabs',
			'popper'
		), FRIDAY_NEXT_EXTRAS_VERSION, true );
		wp_enqueue_script( 'sticky_bits' );
	}
	
	// For all archive pages
	if ( is_archive() || is_home() || is_front_page() ) {
		wp_register_script( 'swiper_slider', '//unpkg.com/swiper/swiper-bundle.min.js' );
		wp_enqueue_script( 'swiper_slider' );
	}
	
	wp_register_script( 'fn_scripts', plugins_url( 'public/js/scripts.js', __FILE__ ), array(
		'jquery',
		'jpopup_modal',
		'facebook_share',
		'pinterest_share',
		'jquery-ui-core',
		'jquery-ui-tabs',
		'datatables_script',
		'datatables_buttons_script'
	), FRIDAY_NEXT_EXTRAS_VERSION, true );
	$fn_nonce = wp_create_nonce( 'fn_noncy' );
	wp_localize_script( 'fn_scripts', 'fnajax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => $fn_nonce,
	) );
	wp_enqueue_script( 'fn_scripts' );
}

add_action( 'get_header', 'acf_reqs' );
function acf_reqs() {
	// TODO: Check to see if admin page, then add this!
	acf_form_head();
}

/**
 * Enable unfiltered_html capability for Editors.
 */
function allow_editors_to_html( $allow_unfiltered_html ) {
	return true;
}

add_filter( 'acf/allow_unfiltered_html', 'allow_editors_to_html' );

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
			$profile_args     = array(
				'post_type'      => 'vendor_profile',
				'meta_key'       => 'linked_user_account_user',
				'meta_value'     => $user->ID,
				'posts_per_page' => 1    // stop at the first match
			);
			$matching_profile = get_posts( $profile_args );
			if ( sizeof( $matching_profile ) > 0 ) {
				// Set the session variable so we don't have to do ridiculous URL shenanigans
				$_SESSION['vendor'] = $matching_profile[0]->ID;
				
				// we found a match, so let's send them to their profile page
				return home_url( '/client-admin?ven_id=' . $matching_profile[0]->ID );
			}
			
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
	if ( ( 'facebook_share' == $handle ) || ( 'pinterest_share' == $handle ) ) {
		return str_replace( ' src', ' async="async" defer="defer" crossorigin="anonymous" src', $tag );
	}
	
	return $tag;
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
		4 => 'clickCountLastClicked',
		5 => 'viewCountLastViewed',
		6 => 'postDate',
		7 => 'isActive',
		8 => 'action'
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
			$nestedData[] = '<strong>' . get_field( 'banner_click_count' ) . '</strong><br />' . ( get_field( 'last_clicked' ) ? get_field( 'last_clicked' ) : 'N.A.' );
			$nestedData[] = '<strong>' . get_field( 'view_count' ) . '</strong><br />' . ( get_field( 'last_viewed' ) ? get_field( 'last_viewed' ) : 'N.A.' );
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
		4 => 'localFavesClickCountLastClicked',
		5 => 'profilePageViewCountLastViewed',
		6 => 'premium',
		7 => 'isActive',
		8 => 'action'
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
			$group_text   = '';
			if ( get_field( 'group' ) ) {
				$group      = get_field( 'group' );
				$group_text = esc_html( $group->name );
			}
			$nestedData[]     = $group_text; // TODO: filter out individual taxonomy
			$nestedData[]     = get_field( 'local_faves_click_count' ) . '<br \>' . get_field( 'local_faves_last_viewed' ); // Local Faves Last Clicked
			$nestedData[]     = get_field( 'profile_page_view_count' ) . '<br \>' . get_field( 'profile_page_last_viewed' ); // Profile Page Views and Last Viewed
			$premium_listings = get_field( 'premium_listings' );
			if ( $premium_listings ) {
				$nestedData[] = $premium_listings[0]['level'];
			} else {
				$nestedData[] = '';
			}
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
				<th>Local Faves<br>Click Count &<br>Last Clicked</th>
		        <th>Profile Page<br>View Count &<br>Last Viewed</th>
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
				<th>Banners & Links<br />Click Count &<br />Last Clicked</th>
				<th>Article Page<br />View Count &<br />Last Viewed</th>
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
		'return'                => '/saw-admin/edit-advertiser?ven_id=%post_id%'
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

/* Dynamically populate vendor email in sidebar contact form */
add_filter( 'gform_field_value_vendor_email', 'gravity_form_vendor_email' );
function gravity_form_vendor_email( $value ) {
	if ( get_post_type() == 'vendor_profile' ) {
		return get_field( "email" );
	}
	
	return $value;
}

add_filter( 'gform_field_value_vendor_email_cc', 'gravity_form_vendor_email_cc' );
function gravity_form_vendor_email_cc( $value ) {
	if ( get_post_type() == 'vendor_profile' ) {
		return get_field( "email_cc" );
	}
	
	return $value;
}

add_filter( 'gform_field_value_vendor_email_cc', 'gravity_form_vendor_email_bcc' );
function gravity_form_vendor_email_bcc( $value ) {
	if ( get_post_type() == 'vendor_profile' ) {
		return get_field( "email_bcc" );
	}
	
	return $value;
}

add_filter( 'gform_field_value_vendor_name', 'gravity_form_vendor_name' );
function gravity_form_vendor_name( $value ) {
	if ( get_post_type() == 'vendor_profile' ) {
		return get_the_title();
	}
	
	return $value;
}

add_filter( 'gform_field_value_email_subject_line', 'gravity_form_vendor_email_subject_line' );
function gravity_form_vendor_email_subject_line( $value ) {
	if ( get_post_type() == 'vendor_profile' ) {
		return get_field( "subject_line" );
	}
	
	return $value;
}

/* Enable CC Field for Vendor Pricing Info Form */
add_filter( 'gform_notification_enable_cc_1', 'gf_enable_cc', 10, 3 );
function gf_enable_cc( $enable, $notification, $form ) {
	return true;
}

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
//			die();
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
	// Update the View Count and Last Viewed
	$view_count = get_field( 'view_count' );
	update_field( 'view_count', ++ $view_count );
	update_field( 'last_viewed', date( 'Y-m-d H:m:s' ) );
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
//	$fb_url  = get_field( "facebook" );
//	$pin_url = get_field( "pinterest" );
//	$ig_url  = get_field( "instagram" );
//
//	$html = '<div class="all-tabs-container">';
//	$html .= '<div id="social-tabs">';
//	$html .= '<span class="social-tabs-triangle"></span>
//                <ul>';
//	if ( $fb_url ) {
//		$html .= '<li><a href="#facebook">Facebook</a></li>';
//	}
//	if ( $pin_url ) {
//		$html .= '<li><a href="#pinterest">Pinterest</a></li>';
//	}
//	if ( $ig_url ) {
//		$html .= '<li><a href="#instagram">Instagram</a></li>';
//	}
//	$html .= '</ul>';
//
//	if ( $fb_url ) {
//		$html .= '<div id="facebook" class="social-share-div"><div class="fb-page" data-href="' . $fb_url . '" data-tabs="timeline" data-width="" data-height="360" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="' . $fb_url . '" class="fb-xfbml-parse-ignore"><a href="' . $fb_url . '">' . get_the_title() . '</a></blockquote></div></div>';
//	}
//	if ( $pin_url ) {
//		$html .= '<div id="pinterest" class="social-share-div"><a data-pin-do="embedUser" data-pin-board-width="280" data-pin-scale-height="250" data-pin-scale-width="80" href="' . $pin_url . '"></a></div>';
//	}
//	if ( $ig_url ) {
//		$config = new includes\Config\SawConfig();
//		$regex  = '/(?:(?:http|https):\/\/)?(?:www\.)?(?:instagram\.com|instagr\.am)\/([A-Za-z0-9-_\.]+)/im';
	// Verify valid Instagram URL
//		if ( preg_match( $regex, $ig_url, $matches ) ) {
//			$ig_username = $matches[1];
//
//			$ig_feed = new includes\InstagramUserFeed\InstagramUserFeed($config->getIgUsername(), $config->getIgPassword(), $ig_username);
//
////            print_r($this_feed);
//    		$html .= '<div id="instagram" class="social-share-div">
//                        <div class="ig-header">
//                            <div class="ig-profile-photo">
//                                <img src="' . $ig_feed->profile_photo . '" alt="Profile Photo" />
//                            </div>
//                            <div class="ig-title">' . $ig_feed->title . '</div>
//                        </div>
//                        <div class="ig-photos">';
//                            $flex_count = 0;
//                            $html .= '<div class="ig-photo-row">';
//                            foreach ($ig_feed->images as $image) {
//                                $flex_count++;
//                                $html .= $image;
//                                if ($flex_count % 3 == 0) {
//                                    if ($flex_count == sizeof($ig_feed->images)) {
//	                                    break;
//                                    } else {
//                                        $html .= '</div><div class="ig-photo-row">';
//                                    }
//                                }
//                            }
//                            $html .= '</div>';
//                        $html .= '</div>
//                        <a class="ig-follow" href="' . $ig_url . '" target="_blank">Follow On <img class="instagram-share" src="' . esc_url( plugins_url( 'public/img/Social-Media-Icons-SAW-Instagram.png', __FILE__ ) ) . '" alt="instagram-share"></a>
//                      </div>';
//        }
//	}
//	$html .= '</div></div>';
//	$html .= '<script type="text/javascript">
//                jQuery( function() {
//                    jQuery("#social-tabs").tabs({
//                        event: "mouseover"
//                    });
//                    jQuery(".all-tabs-container").parent().parent().addClass("social-sidebar-tabs");
//                });
//              </script>';
//
	$html = '<div class="social-icons">';
	$html .= '<span class="social-tabs-triangle"></span>';
	$html .= get_field( 'facebook' ) ? '<a target="_blank" href="' . get_field( "facebook" ) . '"><img src="' . plugins_url( "/public/img/Social-Media-Icons-SAW-FB.png", __FILE__ ) . '" /></a>' : '';
	$html .= get_field( 'instagram' ) ? '<a target="_blank" href="' . get_field( "instagram" ) . '"><img src="' . plugins_url( "/public/img/Social-Media-Icons-SAW-Instagram.png", __FILE__ ) . '" /></a>' : '';
	$html .= get_field( 'pinterest' ) ? '<a target="_blank" href="' . get_field( "pinterest" ) . '"><img src="' . plugins_url( "/public/img/Social-Media-Icons-SAW-Pinterest.png", __FILE__ ) . '" /></a>' : '';
	$html .= get_field( 'youtube' ) ? '<a target="_blank" href="' . get_field( "youtube" ) . '"><img src="' . plugins_url( "/public/img/YouTube-saw-Icon-Small-Teal.svg", __FILE__ ) . '" /></a>' : '';
	$html .= get_field( 'twitter' ) ? '<a target="_blank" href="' . get_field( "twitter" ) . '"><img src="' . plugins_url( "/public/img/Twitter-saw-Icon-Small-Teal.svg", __FILE__ ) . '" /></a>' : '';
	$html .= '</div>';
	
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
		$html .= '<ul class="styled-shoot-vendors">';
		sort( $vendor_arr );
		foreach ( $vendor_arr as $vendor ) {
			$html .= '<li><span style="text-transform: uppercase;"><strong>' . $vendor['category_title'] . '</strong></span>';
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
		$header_img = get_field( 'header_image' );
		if ( $header_img ) {
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
			$html  .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
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
	$today = date( 'Y-m-d H:i:s' );
	$args  = array(
		'post_type'      => 'home_slide',
		'posts_per_page' => 5,
		'order'          => 'DESC',
		'meta_query'     => array(
			array(
				'key'     => 'is_active',
				'compare' => '=',
				'value'   => true
			),
			array(
				'key'     => 'is_slide_featured',
				'compare' => '=',
				'value'   => true
			),
			'start_date ' => array(
				'key'     => 'banner_start_date', // stored like '2020-07-09 15:00:00'
				'compare' => '<',
				'value'   => $today,
			),
			'end_date'    => array(
				'relation' => 'OR',
				array(
					'key'     => 'banner_end_date',
					'compare' => 'NOT EXISTS'
				),
				array(
					'key'     => 'banner_end_date',
					'compare' => '=',
					'value'   => '',
				),
				array(
					'key'     => 'banner_end_date',
					'compare' => '>',
					'value'   => $today,
				)
			)
		),
		'orderby'        => 'start_date'
	);
	
	$home_sliders = get_posts( $args );
	// If there were less than 5 posts, find the remaining posts to make a total of 5
	if ( sizeof( $home_sliders ) < 5 ) {
		// get the remainder up to 5 of more random sliders
		$args              = array(
			'post_type'      => 'home_slide',
			'posts_per_page' => ( 5 - sizeof( $home_sliders ) ),
			'orderby'        => 'rand',
			'meta_query'     => array(
				array(
					'key'     => 'is_active',
					'compare' => '=',
					'value'   => true
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => 'is_slide_featured',
						'compare' => '=',
						'value'   => false
					),
					array(
						'key'     => 'banner_end_date',
						'compare' => '<',
						'value'   => $today,
					)
				)
			)
		);
		$more_home_sliders = get_posts( $args );
//        print_r($more_home_sliders);die();
		foreach ( $more_home_sliders as $another_slider ) {
			$home_sliders[] = $another_slider;
		}
	}
	
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
		$html             .= '<div class="bg-image-layer" style="background-image:url(' . esc_url( $background_image['url'] ) . ');background-size:contain;background-size: cover;background-repeat: no-repeat;background-position: right center;">';
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
		$html .= '<a id="' . $slider->ID . '" href="' . get_field( 'banner_url', $slider->ID ) . '" alt="' . get_field( 'banner_name', $slider->ID ) . '">Read More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a>';
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
		'post_type'      => 'vendor_profile',
		'meta_key'       => 'local_fave_homepage',
		'meta_value'     => 'yes',
		'posts_per_page' => 12,
		'orderby'        => 'rand'
	);
	$local_faves = get_posts( $args );
	$html        = '<div class="swiper-container swiper-faves-container">';
	$html        .= '<div class="local-faves-container swiper-wrapper">';
	foreach ( $local_faves as $local_fave ) {
		$html .= '<div class="individual-fave swiper-slide">';
		$html .= '<div class="local-fave-image">';
		$html .= get_the_post_thumbnail( $local_fave->ID, array( 500, 500 ) );
		$html .= '<a href="' . get_permalink( $local_fave ) . '" class="local-fave-link" id="' . $local_fave->ID . '"><div class="fave-image-overlay"></div></a>';
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
                    slidesPerView:2,
                    breakpoints: {
                        768: {
                            slidesPerView:3,
                        },
                        980: {
                            slidesPerView:4,
                        }
                    },
                    spaceBetween: "2.7%",
                    pagination: {
                        el: ".swiper-pagination-faves",
                        clickable: true
                    },
                    loop: true,
                    loopedSlides: ';
	$html .= sizeof( $local_faves );
	$html .= ',
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
		'orderby'        => 'date',
		'order'          => 'DESC'
	);
	$blog_posts = get_posts( $args );
	$count      = 1;
	$html       = '<div class="local-faves-container home-buzz">';
	foreach ( $blog_posts as $post ) {
		
		$html  .= '<div class="individual-fave blog-buzz' . ( $count == 4 ? ' last' : '' ) . '">';
		$html  .= '<div class="local-fave-image">';
		$image = get_field( 'header_image', $post->ID );
		$html  .= '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" />';
		$html  .= '<a href="' . get_permalink( $post ) . '"><div class="fave-image-overlay"></div></a>';
		$html  .= '</div>'; // END .local-fave-image
		
		$html .= '<div class="fave-title-container">';
		$html .= '<a href="' . get_permalink( $post ) . '"><h3>' . $post->post_title . '</h3></a>';
		$html .= '</div>'; // END .fave-title-container
		$html .= '</div>'; // END .individual-fave
		$count ++;
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
	$count      = 1;
	$html       = '<div class="local-faves-container spotlight">';
	foreach ( $spotlights as $spotlight ) {
		/*if ( $count % 4 == 0 ) {
			$html .= '</div><div class="local-faves-container spotlight">';
		}*/
		$last = ( $count == 4 || $count == 8 ) ? ' last' : '';
		$html .= '<div class="individual-fave spotlight' . $last . '">';
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
				<th>Start Featured</th>
				<th>Is Featured?</th>
				<th>End Featured Date</th>
				<th>View Count &<br />Last Viewed</th>
				<th>Click Count &<br />Last Clicked</th>
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
		6 => 'clickCountLastClicked',
		7 => 'isActive',
		8 => 'action'
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
			$nestedData[] = '<strong>' . get_field( 'click_count' ) . '</strong><br />' . ( get_field( 'last_clicked' ) ? get_field( 'last_clicked' ) : 'N.A.' );
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
        WHERE p.post_type = %s AND tt.taxonomy = %s
        GROUP BY t.term_id ORDER BY t.name",
		'vendor_profile',
		'category'
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
	wp_reset_query();
	
	return $html;
}

/******************** STAY CONNECTED FOOTER MENU SHORTCODE ********************/
add_shortcode( 'stay_connected', 'render_stay_connected_footer' );
function render_stay_connected_footer() {
	$html   =
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
                            <div id="instagram" class="social-share-div">';
	$config = new includes\Config\SawConfig();
	$regex  = '/(?:(?:http|https):\/\/)?(?:www\.)?(?:instagram\.com|instagr\.am)\/([A-Za-z0-9-_\.]+)/im';
	// Verify valid Instagram URL

//                            $ig_username = 'sanantonio.weddings';
//                            $ig_feed = new includes\InstagramUserFeed\InstagramUserFeed($config->getIgUsername(), $config->getIgPassword(), $ig_username);
//
//                            $html .= '<div id="instagram" class="social-share-div">
//                                <div class="ig-header">
//                                    <div class="ig-profile-photo">
//                                        <img src="' . $ig_feed->profile_photo . '" alt="Profile Photo" />
//                                    </div>
//                                    <div class="ig-title">' . $ig_feed->title . '</div>
//                                </div>
//                                <div class="ig-photos">';
//                                    $flex_count = 0;
//                                    $html .= '<div class="ig-photo-row">';
//                                    foreach ($ig_feed->images as $image) {
//                                        $flex_count++;
//                                        $html .= $image;
//                                        if ($flex_count % 3 == 0) {
//                                            if ($flex_count == sizeof($ig_feed->images)) {
//                                                break;
//                                            } else {
//                                                $html .= '</div><div class="ig-photo-row">';
//                                            }
//                                        }
//                                    }
//                                    $html .= '</div>';
//                                $html .= '</div>
//                                <a class="ig-follow" href="https://www.instagram.com/sanantonio.weddings/" target="_blank">Follow On <img class="instagram-share" src="' . esc_url( plugins_url( 'public/img/Social-Media-Icons-SAW-Instagram.png', __FILE__ ) ) . '" alt="instagram-share"></a>
//                              </div>';
//
	$html .= '</div>';
	$html .= '</div>
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

add_shortcode( 'share_slide_out', 'render_share_slide_out' );
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

add_shortcode( "prev_next_navigation", "render_prev_next_navigation" );
function render_prev_next_navigation() {
	$html = '<a href="' . get_previous_post_link() . '">\<Previous</a>';
	$html .= ' <a href="' . get_next_post_link() . '">Next\></a>';
	
	return $html;
}

add_shortcode( 'logout_button', 'render_logout_button' );
function render_logout_button() {
	return '<a class="logout-button" href="' . wp_logout_url( '/' ) . '" alt="Logout">Logout</a>';
}

/***************************** HOMEPAGE MID-NAVBAR VENDOR DROPDOWN MENU *********************************/
add_shortcode( 'home_midnav_vendor_menu', 'mid_nav_vendors' );
function mid_nav_vendors() {
	// Only get vendor categories that currently have something in them - don't want pages showing up with no results!
	global $wpdb;
	
	$query             = $wpdb->prepare(
		"SELECT t.*, COUNT(*) from $wpdb->terms AS t
        INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
        INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
        WHERE p.post_type = %s AND tt.taxonomy = %s
        GROUP BY t.term_id ORDER BY t.name",
		'vendor_profile',
		'category'
	);
	$vendor_categories = $wpdb->get_results( $query );
//	print_r($vendor_categories);die();
	
	$html = '<div class="midnav-vendor-list">
                <ul class="vendor-mega-menu">
                <p>Choose a Vendor Category</p>';
	// render each individual vendor
	foreach ( $vendor_categories as $vendor_category ) {
		$category_name = $vendor_category->name;
		$html          .= '<li>';
		$html          .= '<a href="/category/' . $vendor_category->slug . '" alt="' . $category_name . '">' . $category_name . '</a>';
		$html          .= '</li>';
	}
	$html .= '</ul></div>'; // END .vendor-list-container
	wp_reset_query();
	
	return $html;
}

add_shortcode( 'home_midnav_vendor_menu_tablet', 'render_tablet_vendors' );
function render_tablet_vendors() {
	// Only get vendor categories that currently have something in them - don't want pages showing up with no results!
	global $wpdb;
	
	$query             = $wpdb->prepare(
		"SELECT t.*, COUNT(*) from $wpdb->terms AS t
        INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
        INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
        WHERE p.post_type = %s AND tt.taxonomy = %s
        GROUP BY t.term_id ORDER BY t.name",
		'vendor_profile',
		'category'
	);
	$vendor_categories = $wpdb->get_results( $query );
//	print_r($vendor_categories);die();
	
	$html = '<div class="midnav-vendor-list-tablet">
                <ul class="vendor-mega-menu">
                <p>Choose a Vendor Category</p>';
	// render each individual vendor
	$html_ven_list = '';
	foreach ( $vendor_categories as $vendor_category ) {
		$category_name = $vendor_category->name;
		$html_ven_list .= '<li>';
		$html_ven_list .= '<a href="/category/' . $vendor_category->slug . '" alt="' . $category_name . '">' . $category_name . '</a>';
		$html_ven_list .= '</li>';
	}
	$html .= $html_ven_list;
	$html .= '</ul></div>'; // END .vendor-list-container
	
	$html .= '<script>/*** DEMO js ***/
            var demoContent = "<div>\
            <strong>Vendor List</strong>\
            <p>The list of vendors will go here.</p>\
            </div>";

            var jPopupDemo = new jPopup({
                content: demoContent,
                transition: \'fade\',
                onOpen: function ($popupEl) {
                    console.log($popupEl, \'open\');
                },
                onClose: function ($popupEl) {
                    console.log($popupEl, \'close\');
                }
            });
            </script>';
	
	wp_reset_query();
	
	return $html;
}

/********************************** HEADER LOGIN DROPDOWN WHEN LOGGED IN ALREADY ****************************************/
add_shortcode( 'show_logged_in_options', 'render_login_options' );
function render_login_options() {
	$html = '';
	
	return $html;
}

/********************************** ARCHIVE PAGE SLIDER ****************************************/
add_shortcode( 'archive_slider', 'render_archive_slider' );
function render_archive_slider( $atts ) {
	$post_type = $atts['type'];
	$html      = '';
	// If this is a Spotlight or (the other one that is similar) - render it one way. Otherwise, render another way
	if ( in_array( $post_type, [ 'spotlight', 'post', 'wedding_story', 'styled_shoot' ] ) ) {
		// Grab the 5 newest Spotlights to be displayed in the slider
		$args         = array(
			'post_type'      => $post_type,
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'meta_key'       => 'is_active',
			'meta_value'     => true,
			'orderby'        => 'rand'
		);
		$slider_posts = get_posts( $args );
		$html         .= '<div id="archive-slider">
            <div class="swiper-container">
                <div class="swiper-wrapper">';
		// Get each of the slides that need to be displayed, and add them to the Slider
		foreach ( $slider_posts as $slider_post ) {
			$text_title = '';
			// Make sure there is a linked vendor, and use their name as the "title"
			$text_title = get_field( 'head_1', $slider_post->ID );
//			if ( get_field( 'vendor', $slider_post ) ) {
//				$text_title = get_the_title( get_field( 'vendor', $slider_post ) );
//			} else {
//				// otherwise, just use the article title as a last resort (or for Blog posts)
//				$text_title = get_the_title( $slider_post );
//			}
			
			$bg_text = '';
			// Check to see if the Archive Page slider image is present in the spotlight
			if ( get_field( 'landing_page_image', $slider_post->ID ) ) {
				$bg_image = get_field( 'landing_page_image', $slider_post->ID );
				$bg_text  = 'style="background: url(' . esc_url( $bg_image['url'] ) . ');"';
			} else {
				// if it isn't, just display a white background
				$bg_text = '#FFF';
			}
			$archive_title = '';
			switch ( $post_type ) {
				case 'spotlight':
					$archive_title = 'Spotlight';
					break;
				case 'wedding_story':
					$archive_title = 'Our Wedding Story';
					break;
				case 'styled_shoot':
					$archive_title = 'Styled Shoot';
					break;
				case 'post':
					$archive_title = 'Blog';
					break;
			}
			$html .= '<div class="swiper-slide">
                            <div class="bg-overlay ' . $post_type . '"></div>
                            <div class="bg-image" ' . $bg_text . '></div>
                            <div class="archive-text">
                                <h2 class="archive-title">' . $archive_title . '</h2><br />
                                <p><a href="' . get_the_permalink( $slider_post->ID ) . '" alt="' . get_the_title( $slider_post->ID ) . '" title="' . get_the_title( $slider_post->ID ) . '">' . $text_title . '</a></p>
                            </div>
                        </div>';
			
		}
		$html .= '</div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
              </div>
          </div>';
	}
	
	// Add in the <script> tag to initialize
	$html .= '<script>
        jQuery(document).on("ready", function() {
            var swiper = new Swiper(".swiper-container", {
              autoplay: {
                delay: 7500,
                disableOnInteraction: false,
                grabCursor: true,
              },
              navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
              },
              pagination: {
                el: ".swiper-pagination",
                clickable: true
              },
              keyboard: true,
              on: {
                  slideChangeTransitionEnd: function() {
                      setTimeout( function() {
                          jQuery(".swiper-slide-active .archive-text").addClass("visible");
                      }, 400);
                      jQuery("#archive-slider .swiper-wrapper").children().eq(swiper.previousIndex).children().eq(2).removeClass("visible");
                  },
                  init: function() {
                      setTimeout( function() {
                          jQuery(".swiper-slide-active .archive-text").addClass("visible");
                      }, 200);
                  }
              }
            });
        });
      </script>';
	
	// All is added - let's return it
	return $html;
}

/****************************** ARCHIVE PAGE AJAX POSTS ************************************/

// 2 actions to be used for doing AJAX calls
add_action( 'wp_ajax_archive_moreposts', 'render_archive_ajax' );
add_action( 'wp_ajax_nopriv_archive_moreposts', 'render_archive_ajax' );

add_action( 'wp_ajax_archive_sortposts', 'render_archive_ajax' );
add_action( 'wp_ajax_nopriv_archive_sortposts', 'render_archive_ajax' );

add_shortcode( 'archive_ajax', 'render_archive_ajax' );
function render_archive_ajax( $atts ) {
	// TODO: could possibly pass in 'offset' when calling this function from AJAX, so that I don't have to write it again
	$request     = $_POST;
	$post_type   = '';
	$html        = '';
	$offset      = 0;
	$append      = false; // If we have an offset, let's append these results
	$alpha       = false;
	$alpha_click = false; // If 'Sort Alphabetically' was clicked
	$search_term = '';
	
	
	$offset = isset( $request['offset'] ) && $request['offset'] !== 0 ? $request['offset'] : $offset;
	$append = isset( $request['offset'] ) && $request['offset'] !== 0 ? true : $append;
	
	$alpha       = isset( $request['alphabetize'] ) ? true : $alpha;
	$alpha_click = isset( $request['alpha_click'] ) ? $request['alpha_click'] : $alpha_click;
	
	$search_term = isset( $request['search_term'] ) ? $request['search_term'] : $search_term;
	
	$post_type = isset( $request['post_type'] ) ? $request['post_type'] : ( isset( $atts['type'] ) ? $atts['type'] : $post_type );
	
	if ( $post_type == 'spotlight' || $post_type == 'post' ) {
		$posts_per_page = 5;
		// here's where we get all our Spotlights to display in beautiful flex boxes
		$args          = array(
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'is_active',
			'meta_value'     => true,
			'offset'         => $offset,
			'orderby'        => ( $post_type == 'spotlight' ? 'rand(' . get_random_post() . ')' : 'date' )
		);
		$archive_posts = get_posts( $args );
		if ( sizeof( $archive_posts ) > 0 ) {
			$html .= $append == false ? '<div id="post-archive-list" class="rows">' : '';
			foreach ( $archive_posts as $archive_post ) {
				// 1. Get the Featured Image (square) to be displayed on the left
				// 2. Get the Vendor Name to be used as the link title
				// 3. Get the excerpt (or a specific number of words, followed by ellipsis) under Title
				
				// Featured Image
				$head_img = get_field( 'header_image', $archive_post->ID );
				$feat_img = get_the_post_thumbnail( $archive_post->ID, 'post-thumbnail', array( 'loading' => false ) );
				$html     .= '<div class="archive-row" onclick="window.location = \'' . get_the_permalink( $archive_post->ID ) . '\'">';
				$html     .= '<div class="thumbnail"><img src="' . $head_img['url'] . '" /></div>'; // END .thumbnail
				
				// Vendor Name
				$post_title = $post_type == 'spotlight' ? get_the_title( get_field( 'vendor', $archive_post->ID ) ) : get_the_title( $archive_post->ID );
				$html       .= '<div class="vendor-name  ' . $post_type . '">
                        <h4><a href="' . get_the_permalink( $archive_post->ID ) . '" alt="' . $post_title . '" title="' . $post_title . '">' . $post_title . '</a></h4>';
				$html       .= '<p>' . get_field( 'meta_description', $archive_post->ID ) . '</p>
            </div>'; // END .vendor-name
				$html       .= '</div>'; // END .archive-row++
			}
			$html .= $append == false ? '</div>' : ''; // END #post-archive-list
		} else {
			$html .= '<script type="text/javascript">
                jQuery("#archive-more-button").hide();
            </script>';
			$resp = array(
				'newhtml' => $html
			);
			wp_send_json( $resp );
			wp_die();
		}
		// The Load More Ajax Button
		if ( $append == false ) {
			$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-post_type="' . $post_type . '" data-offset="' . $posts_per_page . '">Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
		} else {
			// we're appending, so we don't need the button printed again
			// send back the resulting HTML to the AJAX call, and add it in via JS
			$resp = array(
				'newhtml' => $html
			);
			wp_send_json( $resp );
			wp_die();

//	        wp_send_json( $resp );
//	        echo "This is painfully not working";
		}
	} elseif ( in_array( $post_type, [ 'wedding_story', 'styled_shoot' ] ) ) {
		$posts_per_page = 9;
		// here's where we get all our Spotlights to display in beautiful flex boxes
		$args          = array(
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'is_active',
			'meta_value'     => true,
			'offset'         => $offset,
			'orderby'        => 'date'
		);
		$archive_posts = get_posts( $args );
		$html          .= $append == false ? '<div id="post-archive-list" class="cols">' : '';
		$col_count     = 0;
		if ( sizeof( $archive_posts ) > 0 ) {
//			$html .= '<div class="archive-row cols">';
			foreach ( $archive_posts as $archive_post ) {
				
				
				// Featured Image
				$feat_img = get_the_post_thumbnail( $archive_post->ID, 'post-thumbnail', array( 'loading' => false ) );
				$html     .= '<div class="archive-col" onclick="window.location = \'' . get_the_permalink( $archive_post->ID ) . '\'">';
				$html     .= '<div class="thumbnail">' . $feat_img . '</div>'; // END .thumbnail
				
				// Vendor Name
				$post_title = get_the_title( $archive_post->ID );
				$html       .= '<div class="post-name ' . ( $post_type == "wedding_story" ? "wedding-story" : "" ) . '">
                        <h4><a href="' . get_the_permalink( $archive_post->ID ) . '" alt="' . $post_title . '" title="' . $post_title . '">' . $post_title . '</a></h4>
            </div>'; // END .vendor-name
				$html       .= '</div>'; // END .archive-col++
				$col_count ++;
				if ( $col_count >= sizeof( $archive_posts ) ) {
//					$html .= '</div>'; // End of last .archive-row div
				} elseif ( $col_count % 3 == 0 ) {
//					$html .= '</div><div class="archive-row cols">'; // start a new .archive-row
				}
			}
			$html .= $append == false ? '</div>' : ''; // END #post-archive-list
		} else {
			$html .= '<script type="text/javascript">
                jQuery("#archive-more-button").hide();
            </script>';
			$resp = array(
				'newhtml' => $html
			);
			wp_send_json( $resp );
			wp_die();
		}
		
		// The Load More Ajax Button
		if ( $append == false ) {
			$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-post_type="' . $post_type . '" data-offset="' . $posts_per_page . '">Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
		} else {
			// we're appending, so we don't need the button printed again
			// send back the resulting HTML to the AJAX call, and add it in via JS
			$resp = array(
				'newhtml' => $html
			);
			wp_send_json( $resp );
			wp_die();
		}
	} elseif ( in_array( $post_type, [ 'virtual-tour', 'category' ] ) ) {
		$posts_per_page = - 1;
		// here's where we get all our posts to display in beautiful grid boxes
		$args = array();
		
		switch ( $post_type ) {
			case "virtual-tour":
				$meta_query_args = array(
					'relation' => 'AND',
					array(
						'key'     => 'is_active',
						'value'   => true,
						'compare' => '='
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => '360-virtual-tour',
							'value'   => '',
							'compare' => '!='
						),
						array(
							'key'     => '360-virtual-tour',
							'compare' => 'EXISTS'
						)
					)
				);
				$args            = array(
					'post_type'      => 'vendor_profile',
					'posts_per_page' => $posts_per_page,
					'meta_query'     => $meta_query_args,
					'offset'         => $offset,
//					'orderby'        => 'rand(' . get_random_post() . ')'
					'orderby'        => 'rand'
				);
				break;
			case "category":
				if ( isset( $request['category'] ) ) {
					$cat_id = $request['category'];
				} else {
					$category = get_queried_object();
					$cat_id   = $category->term_id;
				}
				// grab the premium level for each category
//                $meta_query_args = array(
//                    'relation' => 'OR',
//                    array(
//                        'relation' => 'AND',
//                        'level' => array(
//                            'key' => 'premium_listings_0_level',
//                            'compare' => 'EXISTS'
//                        ),
//	                    array(
//		                    'key' => 'premium_listings_0_categry',
//		                    'value' => $cat_id
//	                    )
//                    ),
//                    array(
//                        'relation' => 'AND',
//                        'level' => array(
//                            'key' => 'premium_listings_1_level',
//                            'compare' => 'EXISTS'
//                        ),
//	                    array(
//		                    'key' => 'premium_listings_1_category',
//		                    'value' => $cat_id
//	                    )
//                    ),
//                    array(
//                        'relation' => 'AND',
//		                'level' => array(
//                            'key' => 'premium_listings_2_level',
//                            'compare' => 'EXISTS'
//                        ),
//		                array(
//			                'key' => 'premium_listings_2_category',
//			                'value' => $cat_id
//		                )
//	                )
//
//                );
				
				$args = array(
//                    'ep_integrate'   => true,
					'post_type'      => 'vendor_profile',
//					'posts_per_page' => $alpha_click ? $offset : $posts_per_page,
					'posts_per_page' => $posts_per_page,
					'cat'            => $cat_id,
					'meta_key'       => 'is_active',
					'meta_value'     => true,
//					'offset'         => $alpha_click ? 0 : $offset,
//					'orderby'        => $alpha ? 'title' : 'rand(' . get_random_post() . ')',
					'orderby'        => $alpha ? 'title' : 'rand',
					'order'          => 'ASC'
				);
				break;
		}

//		global $post;
//        $cat = get_term_by('slug', $post->post_name, 'category');
		$category      = get_queried_object();
		$archive_posts = get_posts( $args );
		if ( ! $alpha_click ) {
			$cat  = $post_type == 'category' ? 'data-category-id="' . $args['cat'] . '"' : '';
			$html .= $post_type == 'category' ? '<div class="cat-title"><h2>' . $category->name . '</h2></div>' : '';
			$html .= $alpha_click ? '' : '<div class="alphabetize"><a class="sort-alphabetically" href="#" ' . $cat . ' data-post_type="' . $post_type . '">Sort Alphabetically</a></div>';
		}
		$html      .= $alpha_click ? '' : '<div id="post-archive-list" class="cols">';
		$col_count = 0;
		if ( sizeof( $archive_posts ) > 0 ) {
//			$html .= '<div class="archive-row cols">';
			foreach ( $archive_posts as $archive_post ) {
				
				// Featured Image
				$feat_img = get_the_post_thumbnail( $archive_post->ID, 'post-thumbnail', array( 'loading' => false ) );
				$html     .= '<div class="archive-col" onclick="window.location = \'' . ( $post_type !== 'virtual_tour' ? get_the_permalink( $archive_post->ID ) : get_field( '360tour', $archive_post->ID ) ) . '\', \'_blank\'">';
				$html     .= '<div class="thumbnail">' . $feat_img . '</div>'; // END .thumbnail
				
				// Vendor Name
				$post_title = get_the_title( $archive_post->ID );
				$html       .= '<div class="post-name ' . $post_type . '">
                        <h4 class="cat-archive"><a href="' . get_permalink( $archive_post->ID ) . '">' . $post_title . '</a></h4>
            </div>'; // END .vendor-name
				$html       .= '</div>'; // END .archive-col++
				$col_count ++;
				if ( $col_count >= sizeof( $archive_posts ) ) {
//					$html .= '</div>'; // End of last .archive-row div
				} elseif ( $col_count % 9 == 0 ) {
//					$html .= '</div><div class="archive-row cols">'; // start a new .archive-row
					$banner_ad = sizeof( $archive_posts ) > 8 ? do_shortcode( '[banner_ad type="category"]' ) : "";
					$html      .= $banner_ad;
				}
			}
			
			
			$html .= $append == false ? '</div>' : ''; // END #post-archive-list
			if ( $alpha_click ) {
				$resp = array(
					'newhtml' => $html
				);
				wp_send_json( $resp );
				wp_die();
				
			}
		} else {
			$html .= '<script type="text/javascript">
                jQuery("#archive-more-button").hide();
            </script>';
		}
		
		// The Load More Ajax Button
//		if ( $append == false ) {
//			// Store the category, since it won't be the queried object once we click the 'more' button
//			$cat    = $post_type == 'category' ? 'data-category-id="' . $args['cat'] . '"' : '';
//			$offset = $offset == 0 ? sizeof( $archive_posts ) : $offset;
//			if ( isset( $args['cat'] ) ) {
//				$this_category = get_term( $args['cat'], 'category' );
//				$count         = $this_category->count;
//				if ( $offset < $count ) {
//					$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-post_type="' . $post_type . '" data-offset="' . $offset . '" ' . $cat . '>Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
//				}
//			} else {
//				$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-post_type="' . $post_type . '" data-offset="' . $offset . '">Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
//			}
//		} else {
//			// we're appending, so we don't need the button printed again
//			// send back the resulting HTML to the AJAX call, and add it in via JS
//			$resp = array(
//				'newhtml' => $html
//			);
//			wp_send_json( $resp );
//			wp_die();
//		}
	} elseif ( in_array( $post_type, [ 'search_results' ] ) ) {
		// get the queried object and display the search results
		global $query_string;
		wp_parse_str( $query_string, $search_query );
		$search_term = strlen( $search_term ) > 0 ? $search_term : $search_query['s'];
		
		// rebuild the query args to only search for post types I want to see
//        $query_args = array(
//            'posts_per_page' => 10,
//            's'              => get_search_query(),
//            'meta_query'     => array(
//                array(
//                    'key' => 'is_active',
//                    'value' => true
//                )
//            )
//        );
		
		
		$html .= $append == false ? '<div id="post-archive-list" class="search-results cols">' : '';

//		add_filter( 'posts_where', 'title_filter', 10, 2 );
		$search_query = new WP_Query(
			array(
//				's'              => $search_term,
                'ep_integrate'          => true,
				'post_type'             => array(
					'vendor_profile',
					'spotlight',
					'wedding_story',
					'styled_shoot',
					'post'
				),
				'posts_per_page' => 10,
				'offset'         => $offset,
                'meta_query'     => array(
                    'relation'  => 'OR',
                    array(
                        'key' => 'about_this_vendor',
                        'compare' => 'LIKE',
                        'value' => $search_term
                    ),
                    array(
                        'key' => 'article_content_%_text',
                        'compare' => 'LIKE',
                        'value' => $search_term
                    )
                ),
				'search_fields'  => array(
					'post_title',
					'taxonomies' => array(
						'photographer',
						'location',
						'category',
						'post_tag'
					),
					'meta'       => array(
						'text',
						'image',
						'about_this_vendor',
                        'article_content_%_text'
					),
				),
//                'meta_key' => 'is_active',
//                'meta_value' => true,
                
			)
		);
		
//		print_r($search_term);
//		print_r($search_query->query);
//		remove_filter( 'posts_where'jj, 'title_filter', 10, 2 );

//        $search_results = get_posts($query_args);
//        if (sizeof($search_results) > 0) {
//            foreach ($search_results as $search_result) {
//                // Featured Image
//                $feat_img = get_the_post_thumbnail($search_result->ID);
//                $html     .= '<div class="archive-col" onclick="window.location=\'' . get_the_permalink($search_result->ID) . '\'">';
//                $html     .= '<div class="thumbnail">' . $feat_img . '</div>'; // END .thumbnail
//
//                // Vendor Name
//                $post_title = get_the_title($search_result->ID);
//                $html       .= '<div class="post-name">
//                        <h4><a href="' . get_the_permalink($search_result->ID) . '" alt="' . $post_title . '" title="' . $post_title . '">' . $post_title . '</a></h4>
//            </div>'; // END .vendor-name
//                $html       .= '</div>'; // END .archive-col++
//            }
//        }
		if ( $search_query->have_posts() ) :
			while ( $search_query->have_posts() ) : $search_query->the_post();
				// Featured Image
//				$feat_img = get_field('header_image');
				$feat_img = get_the_post_thumbnail();
				$html     .= '<div class="archive-col" onclick="window.location=\'' . get_the_permalink() . '\'">';
				$cpt_name = get_post_type_object( get_post_type() )->labels->singular_name;
				$cpt_name = $cpt_name == 'Post' ? 'Blog' : $cpt_name;
				$html     .= '<div class="search-type ' . get_post_type() . '">' . $cpt_name . '</div>';
				$html     .= '<div class="thumbnail">' . $feat_img . '</div>'; // END .thumbnail
//			    $html     .= '<div class="thumbnail"><img src="' . $feat_img['url'] . '" /></div>';
				
				// Vendor Name
				$post_title = get_the_title();
				$html       .= '<div class="post-name">
                        <h4><a href="' . get_the_permalink() . '" alt="' . $post_title . '" title="' . $post_title . '">' . $post_title . '</a></h4>
            </div>'; // END .vendor-name
				$html       .= '</div>'; // END .archive-col++
			endwhile;
		else :
			if ( $offset > 0 ) {
				$html .= '<script type="text/javascript">
                        jQuery("#archive-more-button").hide();
                        </script>';
			} else {
				$html .= '<div class="no-results">No Results Found...</div>';
			}
		endif;
		$count  = $search_query->found_posts;
		$offset = $offset == 0 ? $search_query->post_count : $offset;
		wp_reset_postdata();
		$html .= $append == false ? '</div>' : ''; // END #post-archive-list
		
		// The Load More Ajax Button
		if ( $append == false ) {
			// Store the category, since it won't be the queried object once we click the 'more' button
			$cat = $post_type == 'category' ? 'data-category-id="' . $args['cat'] . '"' : '';
			if ( isset( $search_term ) ) {
				
				if ( $offset < $count ) {
					$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-search-query="' . $search_term . '" data-post_type="' . $post_type . '" data-offset="' . $offset . '" ' . $cat . '>Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
				}
			} else {
				$html .= '<div id="archive-more-button" class="saw-button"><a href="#" data-search-query="' . $search_term . '" data-post_type="' . $post_type . '" data-offset="' . $offset . '" ' . $cat . '>Load More <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
				
			}
		} else {
			// we're appending, so we don't need the button printed again
			// send back the resulting HTML to the AJAX call, and add it in via JS
			$resp = array(
				'newhtml' => $html
			);
			wp_send_json( $resp );
			wp_die();
		}
	}
	
	return $html;
}

/********** Allowing orderby: rand  in ElasticPress Searches *******/
//add_filter('ep_formatted_args', function ($ep_formatted_args, $args) {
//	if ($args['orderby'] == 'rand') {
//		$ep_formatted_args['query']['function_score']['random_score'] = (object) ['seed' => $args['seed']];
//	}
//
//	return $ep_formatted_args;
//}, 10, 2 );

add_action( 'pre_get_posts', 'change_search_types', 1 );
/**
 * This function modifies the main WordPress query to include an array of
 * post types instead of the default 'post' post type.
 *
 * @param object $query The original query.
 *
 * @return object $query The amended query.
 */
function change_search_types( $query ) {
	// This is for special offers in the WP admin
	if ( ! empty( $query->get( 'orderby' ) ) ) {
		$orderby = $query->get( 'orderby' );
		
		if ( 'vendor' == $orderby ) {
			$query->set( 'meta_key', 'vendor' );
			$query->set( 'orderby', 'meta_value' );
		}
	}
	if ( ! is_admin() && $query->is_search() ) {
//		$query->set( 'post_type', array(
//			'page',
//			'spotlight',
//			'wedding_story',
//			'styled_shoot',
//			'post',
//			'vendor_profile'
//		) );
//		$query->set( 'ep_integrate', true );
		// TODO: Make sure that this search is searching name, category name, About Us, etc
	}
}

add_shortcode( 'search_term', 'render_search_term' );
function render_search_term() {
	if ( is_search() ) {
		global $query_string;
		wp_parse_str( $query_string, $search_query );
		
		return '<span style="text-transform:none;">' . $search_query['s'] . '</span>';
	} else {
		return '';
	}
}

// Search by Title
function title_filter( $where, $wp_query ) {
	global $wpdb;
	if ( $search_term = $wp_query->get( 'title_filter' ) ) :
		$search_term           = $wpdb->esc_like( $search_term );
		$search_term           = ' \'%' . $search_term . '%\'';
		$title_filter_relation = ( strtoupper( $wp_query->get( 'title_filter_relation' ) ) == 'OR' ? 'OR' : 'AND' );
		$where                 .= ' ' . $title_filter_relation . ' ' . $wpdb->posts . '.post_title LIKE ' . $search_term;
		$where                 .= ' AND ' . $wpdb->posts . ".post_type IN ('post','spotlight','wedding_story','styled_shoot','vendor_profile')";
	endif;
	
	return $where;
}

// Create a session so we can store the already retrieved posts, so there are no dupes
function prefix_start_session() {
	if ( ! session_id() ) {
		session_start();
	}
}

add_action( 'init', 'prefix_start_session' );

function get_random_post() {
	if ( ! isset( $_SESSION['random'] ) ) {
		$_SESSION['random'] = rand();
	}
	
	return $_SESSION['random'];
}

// Store how many ads we have displayed, to ensure we don't get repeats
function get_ad_offset( $ad_type ) {
	prefix_start_session();
	switch ( $ad_type ) {
		case 'category':
			if ( ! isset( $_SESSION['ad_cat_offset'] ) ) {
				$_SESSION['ad_cat_offset'] = 0;
				
				return $_SESSION['ad_cat_offset'];
			}
			$_SESSION['ad_cat_offset'] += 1;
			
			return $_SESSION['ad_cat_offset'];
			break;
		case 'square':
			if ( ! isset( $_SESSION['ad_square_offset'] ) ) {
				$_SESSION['ad_square_offset'] = 0;
				
				return $_SESSION['ad_square_offset'];
			}
			$_SESSION['ad_square_offset'] += 1;
			
			return $_SESSION['ad_square_offset'];
			break;
	}
}

// Reset 'adoffset' every pageload
add_action( 'wp_loaded', 'reset_ad_offset' );
function reset_ad_offset() {
	if ( isset( $_SESSION['ad_cat_offset'] ) ) {
		$_SESSION['ad_cat_offset'] = 0;
	}
	if ( isset( $_SESSION['ad_square_offset'] ) ) {
		$_SESSION['ad_square_offset'] = 0;
	}
}

/******************************** [square-ad] SHORTCODE *************************************/
add_shortcode( 'banner_ad', 'render_banner_ad' );
function render_banner_ad( $atts ) {
	// be sure not to show the same ad twice, so here we can use the session ID to ensure it's not repeated
	$request         = $_POST;
	$ad_type         = 'square';
	$html            = '';
	$offset          = 0;
	$append          = false; // If we have an offset, let's append these results
	$meta_query_args = array();
	
	if ( isset( $atts['type'] ) ) {
		$ad_type = $atts['type']; // 'category' | 'block' (meaning 2 square and 4 category)
	}
	
	// banner_size = $ad_type
	// start_date < today
	// end_date > today
	
	
	// banner_start_date | banner_end_date | high_exposure_end_date
	// TODO: also update view count
//	$query             = $wpdb->prepare(
//		"SELECT p.* from $wpdb->posts AS p
//        INNER JOIN $wpdb->post_meta AS pm ON p.ID = pm.post_id
//        WHERE p.ID IN (
//            SELECT p.* FROM p
//            WHERE pm.meta_key = %s AND pm.meta_value = %s
//        )
//        AND p.post_type = %s AND pm.
//        GROUP BY t.term_id ORDER BY t.name",
//		'banner_size',
//        $ad_type,
//        'banner',
//		'category'
//	);
//	$vendor_categories = $wpdb->get_results( $query );
	$meta_query_args = array();
	$today           = date( 'Ymd' );
	if ( $ad_type !== 'block' ) {
		$meta_query_args = array(
			'relation' => 'AND',
			array(
				'key'     => 'banner_start_date',
				'compare' => '<=',
				'value'   => $today
			),
			array(
				'key'     => 'banner_stop_date',
				'compare' => '>',
				'value'   => $today
			),
			array(
				'key'     => 'banner_size',
				'compare' => '=',
				'value'   => $ad_type
			),
			array(
				'key'     => 'is_active',
				'compare' => '=',
				'value'   => true
			)
		);
	}
//	$meta_query = new WP_Meta_Query( $meta_query_args );
	
	$banner_args = array(
		'post_type'      => 'banner',
		'meta_query'     => $meta_query_args,
		'posts_per_page' => 999,
//		'offset'         => get_ad_offset( $ad_type ),
//		'meta_key'       => 'exposure_level', // highest exposure ads first
//		'orderby'        => 'meta_value_num',
		'orderby'        => 'rand(' . get_random_post() . ')',
		'order'          => 'DESC'
	);
	if ( is_category() && $ad_type == 'category' ) {
		// Find all Vendors in this Category
		$vendor_args = array(
			'post_type'      => 'vendor_profile',
			'category__in'   => get_queried_object_id(),
			'meta_key'       => 'is_active',
			'meta_value'     => true,
			'posts_per_page' => - 1
		);
		$vendors     = get_posts( $vendor_args );
		$vendor_ids  = array();
		foreach ( $vendors as $vendor ) {
			array_push( $vendor_ids, $vendor->ID );
		}
		
		
		$banner_w_category = $banner_args;
		// for checking that this ad is in the vendor ids array that has vendors in this page's category
		array_push( $banner_w_category['meta_query'], array(
			'key'     => 'advertiser',
			'compare' => 'IN',
			'value'   => $vendor_ids
		) );
		// opposite of the above comment
		$banner_args['meta_query'][] = array(
			'key'     => 'advertiser',
			'compare' => 'NOT IN',
			'value'   => $vendor_ids
		);
		$category_specific           = get_posts( $banner_w_category );
		$banner_ads                  = get_posts( $banner_args );
//		$combined_ads                      = array_merge( $category_specific, $banner_ads );
		$combined_ads = $category_specific + $banner_ads;
		if ( ! empty( $combined_ads ) ) {
			$offset = get_ad_offset( 'category' );
			if ( $offset < sizeof( $combined_ads ) ) {
				$this_ad_id = $combined_ads[ $offset ]->ID;
				$view_count = get_field( 'view_count', $this_ad_id );
				update_field( 'view_count', $view_count + 1, $this_ad_id );
				update_field( 'last_viewed', date( "Y-m-d H:i:s" ), $this_ad_id );
				$image   = get_field( 'ad_banner', $this_ad_id );
				$post_id = '';
				$html    .= '<div class="ad ' . $ad_type . '"><a href="' . get_field( 'banner_link_url', $this_ad_id ) . '" title="' . get_field( 'banner_name', $this_ad_id ) . '" alt="' . get_field( 'banner_name', $this_ad_id ) . '" target="_blank" ><img data-target-id="' . ( is_single() ? $this_post_id : '' ) . '" class="banner-ad-tracking" src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" /></a></div>';
			}
		}
		wp_reset_query();
		
		return $html;
	} else {
		$banner_args['offset']         = get_ad_offset( $ad_type );
		$banner_args['posts_per_page'] = 1;
		$banner_ads                    = get_posts( $banner_args );
	}
//    print_r($banner_ads); die();
	$this_post_id = get_the_ID();
	if ( sizeof( $banner_ads ) >= 1 ) {
		$this_ad_id = $banner_ads[0]->ID;
		if ( is_category() && $ad_type == 'category' ) {
			$this_ad_id = $banner_ads[ get_ad_offset( $ad_type ) ]->ID;
		}
		$view_count = get_field( 'view_count', $this_ad_id );
		update_field( 'view_count', $view_count + 1, $this_ad_id );
		update_field( 'last_viewed', date( "Y-m-d H:i:s" ), $this_ad_id );
		$image   = get_field( 'ad_banner', $this_ad_id );
		$post_id = '';
		$html    .= '<div class="ad ' . $ad_type . '"><a href="' . get_field( 'banner_link_url', $this_ad_id ) . '" title="' . get_field( 'banner_name', $this_ad_id ) . '" alt="' . get_field( 'banner_name', $this_ad_id ) . '" target="_blank" ><img data-target-id="' . ( is_single() ? $this_post_id : '' ) . '" class="banner-ad-tracking" src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" /></a></div>';
	}
	wp_reset_query();
	
	return $html;
}

add_shortcode( 'category_description', 'render_category_description' );
function render_category_description() {
	// get the current category
	$category = get_queried_object();
	$category = get_term( $category->term_id, 'category' );
	
	return $category->description;
}

add_shortcode( 'breadcrumbs', 'render_breadcrumbs' );
function render_breadcrumbs() {
	// find current lcoation and display breadcrumbs
	$html = '<div class="breadcrumbs">';
	$html .= '<a href="' . home_url() . '" rel="nofollow">San Antonio Weddings</a>';
	if ( is_category() || is_single() || is_archive() || is_home() ) {
		if ( is_category() ) {
			$html     .= "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
			$category = get_queried_object();
			$html     .= '<a href="' . $category->url . '">' . $category->name . '</a>';
		} elseif ( is_single() ) {
			$post_type     = get_post_type();
			$post_type_obj = get_post_type_object( $post_type );
			$html          .= " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
			$html          .= '<a href="' . get_post_type_archive_link( $post_type ) . '">' . $post_type_obj->label . '</a>';
			$html          .= " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
			$html          .= get_the_title();
		} elseif ( is_archive() ) {
			$html .= "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
			// get the archive slug to make a title
			
			$html .= substr( get_the_archive_title(), 10 );
		} elseif ( is_home() ) {
			$html .= " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
			$html .= 'Blog';
		}
	} elseif ( is_page() ) {
		$html .= "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
		$html .= get_the_title();
	} elseif ( is_search() ) {
		$html .= "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
		$html .= '"<em>';
		ob_start();
		the_search_query();
		$html .= ob_get_contents();
		ob_end_clean();
		$html .= '</em>"';
	}
	$html .= '</div>';
	
	return $html;
}

add_shortcode( 'more_like_this', 'render_more_like_this' );
function render_more_like_this( $atts ) {
	// $atts['type'] will contain the type of post we're getting more of
	$post_type = $atts['type'] == 'blog' ? 'post' : $atts['type'];
	
	$args     = array(
		'post_type'      => $post_type,
		'posts_per_page' => 3,
		'meta_key'       => 'is_active',
		'meta_value'     => true,
		'orderby'        => 'rand'
	);
	$articles = get_posts( $args );
	$html     = '<div class="more-like-this-container">';
	foreach ( $articles as $article ) {
		// get the 'head' image
		$html  .= '<div class="individual-fave blog-buzz">';
		$html  .= '<div class="local-fave-image">';
		$image = get_field( 'header_image', $article->ID );
		$html  .= '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" />';
		$html  .= '<a href="' . get_permalink( $article ) . '"><div class="fave-image-overlay"></div></a>';
		$html  .= '</div>'; // END .local-fave-image
		
		$html .= '<div class="fave-title-container">';
		$html .= '<a href="' . get_permalink( $article ) . '"><h3>' . $article->post_title . '</h3></a>';
		$html .= '</div>'; // END .fave-title-container
		$html .= '</div>'; // END .individual-fave
		
	}
	$html .= '</div>';
	
	return $html;
	
}

add_shortcode( 'special_offers', 'render_special_offer_list' );
function render_special_offer_list() {
	$today           = date( 'Y-m-d H:i:s' ); //print_r($today);die();
	$meta_query_args = array(
		'relation' => 'OR',
		array(
			'relation' => 'AND',
			array(
				'key'     => 'offer_start_date',
				'compare' => '<=',
				'value'   => $today,
				'type'    => 'DATETIME'
			),
			array(
				'key'     => 'offer_end_date',
				'compare' => '>',
				'value'   => $today,
				'type'    => 'DATETIME'
			)
		),
		array(
			'relation' => 'AND',
			array(
				'key'   => 'permanent_promotion',
				'value' => true
			)
		)
	);
	$args            = array(
		'post_type'      => 'special_offers',
		'posts_per_page' => - 1,
		'meta_query'     => $meta_query_args,
		array(
			'key'     => 'is_active',
			'compare' => '=',
			'value'   => true
		)
	);
	$special_offers  = get_posts( $args );
	
	$html = '<div class="special-offers-list">';
	foreach ( $special_offers as $special_offer ) {
		$this_vendor = get_field( 'vendor', $special_offer->ID );
		
		$html .= '<div class="individual-offer">';
		$html .= '<h5><span class="offer-header-triangle"></span>' . get_the_title( $this_vendor ) . '</h5>';
		$html .= '<h4><a href="' . get_the_permalink( $this_vendor ) . '#special-offers">' . get_the_title( $special_offer->ID ) . '</a></h4>';
		$html .= '</div>'; // END .individual-offer
	}
	$html .= '</div>';
	
	return $html;
}

add_action( 'wp_ajax_update_click_count', 'update_click_count' );
add_action( 'wp_ajax_nopriv_update_click_count', 'update_click_count' );
function update_click_count() {
	$target_id      = intval( $_POST['targetId'] );
	$type_to_update = $_POST['typeToUpdate'];
	$link_type      = $_POST['linkType'];
	
	// If 'Local Fave' was clicked, update the `local_faves_click_count` for the
	//  vendor_profile at $target_id
	if ( $link_type == 'local_fave' ) {
		$click_count = get_field( 'local_faves_click_count', $target_id );
		update_field( 'local_faves_click_count', ++ $click_count, $target_id );
		update_field( 'local_faves_last_clicked', date( "Y-m-d H:i:s" ), $target_id );
	} elseif ( $link_type == 'home_slider' ) {
		$click_count = get_field( 'click_count', $target_id );
		update_field( 'click_count', ++ $click_count, $target_id );
		update_field( 'last_clicked', date( "Y-m-d H:i:s" ), $target_id );
	} elseif ( $link_type == 'banner_ad' ) {
		$click_count = get_field( 'banner_click_count', $target_id );
		update_field( 'banner_click_count', ++ $click_count, $target_id );
		update_field( 'last_clicked', date( 'Y-m-d H:m:s' ), $target_id );
	}
	$resp = array(
		'title'     => 'Click Update Status',
		'content'   => 'Click Count / Last Viewed was updated!',
		'post_type' => $link_type,
		'target_id' => $target_id
	);
	wp_send_json( $resp );
	wp_die();
	
}

/* Catch the Vendor Profile Form when it's saved, to see if a user is being created / update */
add_filter( 'acf/pre_save_post', 'create_update_user', 10, 1 );
function create_update_user( $post_id ) {
	// Grab the `email_username` and `password` variables, if set
	$acf_request     = $_POST['acf'];
	$create_new_user = ! empty( $acf_request['field_5f42cc7f1db03']['field_5f42cfe7c54e9'] ) ? $acf_request['field_5f42cc7f1db03']['field_5f42cfe7c54e9'] : false;
	$reset_password  = ! empty( $acf_request['field_5f42d0bcd749d']['field_5f42d117d749f'] ) ? $acf_request['field_5f42d0bcd749d']['field_5f42d117d749f'] : false;
	if ( $create_new_user ) {
		// Link new vendor was clicked. Make sure a username AND password were passed in, and then create the user
		$email_username = ! empty( $acf_request['field_5f42cc7f1db03']['field_5f29b6ee05253'] ) ? $acf_request['field_5f42cc7f1db03']['field_5f29b6ee05253'] : false;
		$password       = ! empty( $acf_request['field_5f42cc7f1db03']['field_5f29b82f05254'] ) ? $acf_request['field_5f42cc7f1db03']['field_5f29b82f05254'] : false;
		
		if ( $email_username !== false && $password !== false ) {
			// we have email and password, create a new user with 'vendor' role
			$first_name = ! empty( $acf_request['field_5f42cc7f1db03']['field_5f45af9a01611'] ) ? $acf_request['field_5f42cc7f1db03']['field_5f45af9a01611'] : '';
			$last_name  = ! empty( $acf_request['field_5f42cc7f1db03']['field_5f45afd801612'] ) ? $acf_request['field_5f42cc7f1db03']['field_5f45afd801612'] : '';
			
			$user_args   = array(
				'user_login'           => $email_username,
				'user_pass'            => $password,
				'user_email'           => $email_username,
				'first_name'           => $first_name,
				'last_name'            => $last_name,
				'display_name'         => $first_name . ' ' . $last_name,
				'show_admin_bar_front' => 'false',
				'role'                 => 'vendor'
			);
			$new_user_id = wp_insert_user( $user_args );
			if ( ! is_wp_error( $new_user_id ) ) {
				// user was successfully created - add this user's ID to the Vendor Profile as the 'Linked User Account'
				$linked_user                         = array(
					'user'            => $new_user_id,
					'change_password' => false,
					'new_password'    => ''
				);
				$_POST['acf']['field_5f42d0bcd749d'] = $linked_user;
				
				return $post_id;
			} else {
				$error_code          = $new_user_id->get_error_code();
				$linked_user_message = array(
					'field_5f42cfe7c54e9' => true,
					'field_5f29b82f05254' => '',
					'field_5f29b6ee05253' => $email_username,
					'field_5f42e54f6df3d' => 'Adding user failed with error: ' . $error_code
				);
				update_field( 'field_5f42cc7f1db03', $linked_user_message, $post_id );
				$_POST['acf']['field_5f42cc7f1db03'] = $linked_user_message;
				
				return $post_id; // break here, so these fields don't get overwritten incorrectly
			}
		}
	} elseif ( $reset_password ) {
		$user         = ! empty( $acf_request['field_5f42d0bcd749d']['field_5f42d0e3d749e'] ) ? $acf_request['field_5f42d0bcd749d']['field_5f42d0e3d749e'] : null;
		$new_password = ! empty( $acf_request['field_5f42d0bcd749d']['field_5f42d13bd74a0'] ) ? $acf_request['field_5f42d0bcd749d']['field_5f42d13bd74a0'] : null;
		// make sure they are both not null before continuing
		if ( $user !== null && $new_password !== null ) {
			wp_set_password( $new_password, $user ); // this will reset the user's password
		}
	}
	// regardless of what happens, ALWAYS clear out any plaintext password values from the database
	$_POST['acf']['field_5f42cc7f1db03'] = array(
		'field_5f42cfe7c54e9' => false,
		'field_5f29b6ee05253' => '',
		'field_5f29b82f05254' => '',
		'field_5f42e54f6df3d' => ''
	);
	
	$_POST['acf']['field_5f42d0bcd749d'] = array(
		'field_5f42d117d749f' => false, // change_password set to false
		'field_5f42d13bd74a0' => '' // update the new password field to ''
	);
	
	return $post_id;
	
}

/* [company_name] */
add_shortcode( 'client_add_name', 'render_company_name' );
function render_company_name() {
	if ( is_page( array(
		'client-admin',
		'client-admin/edit-my-profile',
		'client-admin/reviews',
		'client-admin/post-special-offers',
		'client-admin/manage-my-photos',
		'client-admin/manage-my-videos',
		'client-admin/manage-my-audio',
		'client-admin/submit-event'
	) ) ) {
		// return the title from the Vendor PProfile
		if ( isset( $_SESSION['vendor'] ) ) {
			$vendor_id = $_SESSION['vendor'];
			
			return get_the_title( $vendor_id );
		} elseif ( isset( $_GET['ven_id'] ) ) {
			$vendor_id          = $_GET['ven_id'];
			$_SESSION['vendor'] = $vendor_id;
			
			return get_the_title( $vendor_id );
		}
	}
	
	return 'company_name';
}

add_shortcode( 'client_last_login', 'render_last_login' );
function render_last_login() {
	if ( is_page( array(
		'client-admin',
		'client-admin/edit-my-profile',
		'client-admin/reviews',
		'client-admin/post-special-offers',
		'client-admin/manage-my-photos',
		'client-admin/manage-my-videos',
		'client-admin/manage-my-audio',
		'client-admin/submit-event'
	) ) ) {
		// return the current user's last log in
		if ( ! empty( get_user_meta( get_current_user_id(), 'last_login' ) ) ) {
			$last_login = new DateTime( get_user_meta( get_current_user_id(), 'last_login', true ) );
			
			return $last_login->format( "M d, Y" );
		}
	}
	
	return 'n.a.';
}

add_action( 'wp_login', 'set_last_login' );
//function for setting the last login
function set_last_login( $login ) {
	$user              = get_userdatabylogin( $login );
	$curent_login_time = get_user_meta( $user->ID, 'current_login', true );
	//add or update the last login value for logged in user
	if ( ! empty( $curent_login_time ) ) {
		update_usermeta( $user->ID, 'last_login', $curent_login_time );
		update_usermeta( $user->ID, 'current_login', current_time( 'mysql' ) );
	} else {
		update_usermeta( $user->ID, 'current_login', current_time( 'mysql' ) );
		update_usermeta( $user->ID, 'last_login', current_time( 'mysql' ) );
	}
}

add_shortcode( 'grouped_businesses', 'render_grouped_businesses' );
function render_grouped_businesses() {
	if ( isset( $_GET['ven_id'] ) ) {
		$vendor_id = $_GET['ven_id'];
		// Get the URL variable, and set it as the SESSION variable to be used elsewhere in the client admin
		$_SESSION['vendor'] = $vendor_id;
		$group              = get_field( 'field_5ef38ad886d53', $vendor_id ) ? get_field( 'field_5ef38ad886d53', $vendor_id ) : false;
		if ( $group !== false ) {
			$meta_query_args = array(
				'relation' => 'AND',
				array(
					'relation' => 'AND',
					array(
						'key'     => 'group',
						'value'   => $group->term_id,
						'compare' => '='
					),
					array(
						'key'     => 'group',
						'compare' => 'EXISTS'
					)
				),
				array(
					'key'   => 'is_active',
					'value' => true
				)
			);
			$args            = array(
				'post_type'      => 'vendor_profile',
				'meta_query'     => $meta_query_args,
				'posts_per_page' => - 1
			);
			$managed_bizs    = get_posts( $args );
			$html            = '';
			$html            .= '<div class="managed-group-bizs">';
			foreach ( $managed_bizs as $managed_biz ) {
				if ( $managed_biz->ID !== (int) $vendor_id ) {
					$html .= '<div class="saw-button"><a href="/client-admin?ven_id=' . $managed_biz->ID . '">' . get_the_title( $managed_biz->ID ) . '</a></div>';
				}
			}
			$html .= '</div>';
		}
		
		return $html;
	}
	
	return 'n.a.';
}

// oembed shortcode return
add_shortcode( "client_admin_oembed_container", "render_oembed_container" );
function render_oembed_container() {
	$html = '<div id="tutorial-video-modal" class="modal micromodal-slide" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-custom-close="tutorial-video-modal">
            <div role="dialog" class="modal__container" aria-modal="true"
                 aria-labelledby="tutorial-video-modal">
                <header class="modal__header">
                    <div id="tutorial-video-modal-title" class="modal__title">
                        <div id="client-oembed-container"></div>
                    </div>
                    <button aria-label="Close modal" class="modal__close"
                            data-custom-close="tutorial-video-modal" onclick="MicroModal.close(\'tutorial-video-modal\', {awaitCloseAnimation:true})"></button>
                </header>
                <div id="tutorial-video-modal-content" class="modal__content">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).on(\'load\', function() {
            MicroModal.init({
                awaitCloseAnimation: true
            });
        })
    </script>';
	
	return $html;
}

add_action( 'wp_ajax_get_oembed', 'my_ajax_getoembed' );
add_action( 'wp_ajax_nopriv_article_datatables', 'my_ajax_getoembed ' );
function my_ajax_getoembed() {
	// grab embed and send it back
	if ( isset( $_GET['videoUrl'] ) ) {
		$url         = $_GET['videoUrl'];
		$json_return = array(
			'oembedhtml' => wp_oembed_get( $url )
		);
		echo json_encode( $json_data );
	}
}

/***** Client Profile Edit Form ******/
add_shortcode( 'client_edit_profile', 'render_client_profile' );
function render_client_profile() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'post_title'            => true,
			'updated_message'       => 'Profile successfully updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5ea5e1660e57b' ),
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5ef38a0f3e966', // subject line
				'field_5ef2ead7c9a36', // email address
				'field_5f178ce570d27', // Email Bcc
				'field_5f178d0870d28', // Email Cc
				'field_5ef2bfc8549e8', // Business Ph Number
				'field_5ef2c14d549e9', // Text Ph Number
				'field_5ea5e3634209a', // Website
				'field_5ea5e1a242098', // Address
				'field_5ededd58345cf', // Google Map
				'field_5f178dea0a9ca', // Extra Addresses
				'field_5ea5e38b4209b', // About Us
				'field_5ea5edb7abab3', // Facebook
				'field_5ea5edd3abab4', // Pinterest
				'field_5ea5ede7abab5', // Instagram
				'field_5f48226f478c0', // Twitter,
				'field_5f482286478c1' // YouTube
			)
		);
		$html      = '<h2>' . get_the_title( $vendor_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

/***** Client Special Offer Form ******/
add_shortcode( 'client_special_offers', 'render_special_offer_one' );
function render_special_offer_one() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		// check if this vendor has special offers already, and display them, if they do
		$so_args       = array(
			'post_type'   => 'special_offers',
			'meta_query'  => array(
				'relation' => 'AND',
				array(
					'key'   => 'is_active',
					'value' => true
				),
				array(
					'key'     => 'vendor',
					'value'   => $vendor_id,
					'compare' => '='
				)
			),
			'post_status' => 'publish'
		);
		$num_offers    = 0;
		$client_offers = get_posts( $so_args );
		$num_offers    = sizeof( $client_offers );
		
		$html = '<h1 class="offer-one">Add Special Offer #1</h1>';
		$html .= '<p>Add your offers here, only 2 Special Offers can be active at one time.</p>';
		$html .= '<hr>';
		if ( $num_offers <= 1 ) {
			// check for existing special offer
			$new_offer_args = array(
				'post_id'               => 'new_post',
				'post_title'            => true,
				'new_post'              => array(
					'post_type'   => 'special_offers',
					'post_status' => 'publish'
				),
				'submit_value'          => 'Submit Special Offer',
				'instruction_placement' => 'field',
				'return'                => '/client-admin/post-special-offers?ven_id=' . $vendor_id,
				'field_groups'          => array( 'group_5ea5df8402ad5' ),
				'fields'                => array(
					'field_5f0c7b5a63866', // is_active
					'field_5f0c775c87ccb', // permanent_promotion
					'field_5f0c76de4e3b8', // offer start date
					'field_5ea5df9130037', // offer end date
					'field_5f0c75664e3b7', // description
					'field_5ea5dfd030038'  // reply email
				)
			);
			if ( $num_offers == 1 ) {
				$offer_one_args = array(
					'post_id'               => $client_offers[0]->ID,
					'post_title'            => true,
					'submit_value'          => 'Submit Special Offer',
					'instruction_placement' => 'field',
					'return'                => '/client-admin/post-special-offers?ven_id=' . $vendor_id,
					'field_groups'          => array( 'group_5ea5df8402ad5' ),
					'fields'                => array(
						'field_5f0c7b5a63866', // is_active
						'field_5f0c775c87ccb', // permanent_promotion
						'field_5f0c76de4e3b8', // offer start date
						'field_5ea5df9130037', // offer end date
						'field_5f0c75664e3b7', // description
						'field_5ea5dfd030038'  // reply email
					)
				);
				
			} else {
				$offer_one_args = $new_offer_args;
			}
			
			ob_start();
			acf_form( $offer_one_args );
			$html .= ob_get_contents();
			ob_end_clean();
			
			$html .= '<h1 class="offer-two">Add Special Offer #2</h1>';
			$html .= '<hr>';
			
			ob_start();
			acf_form( $new_offer_args );
			$html .= ob_get_contents();
			ob_end_clean();
			
			return $html;
		} elseif ( $num_offers == 2 ) {
			$offer_one_args = array(
				'post_id'               => $client_offers[0]->ID,
				'post_title'            => true,
				'submit_value'          => 'Submit Special Offer',
				'updated_message'       => 'Special Offer Updated!',
				'instruction_placement' => 'field',
				'return'                => '/client-admin/post-special-offers?ven_id=' . $vendor_id,
				'field_groups'          => array( 'group_5ea5df8402ad5' ),
				'fields'                => array(
					'field_5f0c7b5a63866', // is_active
					'field_5f0c775c87ccb', // permanent_promotion
					'field_5f0c76de4e3b8', // offer start date
					'field_5ea5df9130037', // offer end date
					'field_5f0c75664e3b7', // description
					'field_5ea5dfd030038'  // reply email
				)
			);
			$html           .= '<h1 class="offer-two">Add Special Offer #2</h1>';
			$html           .= '<hr>';
			$offer_two_args = array(
				'post_id'               => $client_offers[1]->ID,
				'post_title'            => true,
				'submit_value'          => 'Submit Special Offer',
				'updated_message'       => 'Special Offer Updated!',
				'instruction_placement' => 'field',
				'return'                => '/client-admin/post-special-offers?ven_id=' . $vendor_id,
				'field_groups'          => array( 'group_5ea5df8402ad5' ),
				'fields'                => array(
					'field_5f0c7b5a63866', // is_active
					'field_5f0c775c87ccb', // permanent_promotion
					'field_5f0c76de4e3b8', // offer start date
					'field_5ea5df9130037', // offer end date
					'field_5f0c75664e3b7', // description
					'field_5ea5dfd030038'  // reply email
				)
			);
			ob_start();
			acf_form( $offer_one_args );
			acf_form( $offer_two_args );
			$html .= ob_get_contents();
			ob_end_clean();
			
			return $html;
		}
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

add_shortcode( 'client_reviews', 'render_wedding_wire' );
function render_wedding_wire() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'updated_message'       => 'WeddingWire Review successfully updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5ea5e1660e57b' ),
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5ea5e3b74209c', // WeddingWire Reviews
			)
		);
		$html      = '<h2>' . get_the_title( $vendor_id ) . '</h1>';
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

/*** MANAGE PHOTOS ****/
add_shortcode( 'client_featured_image', 'render_client_thumbnail' );
function render_client_thumbnail() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'updated_message'       => 'Featured Image Updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5eebe4fe60795' ),
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5eebe5163383a', // WeddingWire Reviews
			)
		);
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

add_shortcode( 'client_photo_gallery_images', 'render_client_gallery' );
function render_client_gallery() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'updated_message'       => 'Photo Gallery Updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5e9d079710a9c' ),
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5e9d07b835e2e', // WeddingWire Reviews
			)
		);
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

add_shortcode( 'client_video_gallery', 'render_video_gallery' );
function render_video_gallery() {
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'updated_message'       => 'Video Gallery Updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5e9d079710a9c' ),
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5e9d089c35e30', // WeddingWire Reviews
				'field_5f29b35c9df4d'  // videos or photos first?
			)
		);
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
		
		return $html;
	} else {
		//Handle the case where there is no parameter
		return 'Something went wrong...';
	}
}

/******** Client Admin Left Navigation Buttons *********/
add_shortcode( 'client_admin_nav_buttons', 'render_client_nav' );
function render_client_nav() {
	// Display each of the client admin buttons as a Nav item
	$client_pages = array(
		'My Dashboard'             => 'client-admin',
		'Edit My Profile'          => 'client-admin/edit-my-profile',
		'Post Your Special Offers' => 'client-admin/post-special-offers',
		'Manage My Photos'         => 'client-admin/manage-my-photos',
		'Manage My Audio'          => 'client-admin/manage-my-audio',
		'WeddingWire Reviews'      => 'client-admin/reviews',
		'Submit an Event'          => 'client-admin/submit-event',
		//'My Comparison Guides' => 'client-admin/my-comparison-guides',
		'Wedding Story Submission' => 'submissions',
		'Marketing Icons'          => 'marketing-badge-icons'
	);
	
	$html = '<div id="client-admin-nav">';
	// Loop through each of these Pages, and make a button for each
	foreach ( $client_pages as $title => $url ) {
		// add the 'ven_id' to the URL for each link so that it will work properly around the admin
		$vendor_id  = isset( $_GET['ven_id'] ) ? '?ven_id=' . $_GET['ven_id'] : '';
		$active     = get_post_field( 'post_name' ) == $url ? 'active' : '';
		$new_window = in_array( $url, [ 'submissions', 'marketing-badge-icons' ] ) ? ' target="_blank"' : '';
		$html       .= '<div class="client-nav-button"><a class="' . $active . '" href="/' . $url . ( $new_window == '' ? $vendor_id : '' ) . '" data-icon="9"' . $new_window . '>' . $title . '</a></div>';
	}
	$html .= '</div>';
	
	return $html;
}

/*********** Client Audio Files ***********/
add_shortcode( 'client_audio_files', 'render_audio_form' );
function render_audio_form() {
	$html = '';
	// display the form to upload audio files here
	if ( isset( $_SESSION['vendor'] ) ) {
		$vendor_id = $_SESSION['vendor'];
		$args      = array(
			'post_id'               => $vendor_id,
			'updated_message'       => 'Audio Files Updated!',
			'instruction_placement' => 'field',
			'kses'                  => false,
			'field_groups'          => array( 'group_5ea5e1660e57b' ), // Vendor Information Form
			// notate the field groups we want to show up on this page
			'fields'                => array(  // specify which fields we want showing up on this page
				'field_5f0256ed4c967', // Audio Files
			)
		);
		ob_start();
		acf_form( $args );
		$html .= ob_get_contents();
		ob_end_clean();
	} else {
		$html .= 'Something went wrong...';
	}
	
	return $html;
}

add_filter( 'posts_where', 'my_posts_where', 10, 2 );
function my_posts_where( $where, &$wp_query ) {
	if ( get_post_type() == 'vendor_profile' ) {
	    if ($vendor_acf = $wp_query->get('key')) {
		$where = str_replace( "meta_key = 'vendors_$", "meta_key LIKE 'vendors_%_vendor", $where );
	    $where = str_replace( "meta_key = 'article_content_%_text", "meta_key LIKE 'article_content_%_text", $where );
        }
//		echo $where;
	}
	
	return $where;
}