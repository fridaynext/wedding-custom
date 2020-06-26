<?php
/**
 * @package FN_Extras
 * @version 1.1.8
 */

define('FRIDAY_NEXT_EXTRAS_VERSION', '1.1.9');

/********************* ACF JSON *********************/
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {

    // update path
    $path = plugins_url('private/acf/', __FILE__);

    // return
    return $path;

}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = plugins_url('private/acf/', __FILE__);

    // return
    return $paths;
}

add_action('wp_print_styles', 'fn_enqueue_styles');
add_action('wp_enqueue_scripts', 'fn_enqueue_scripts');

// read in csv, and import into WP database
function import_vendors_func() {
//    $row = 1;
//    // 9 total fields
//    $html = '';
//    if (($handle = fopen(plugins_url("public/sawimport.csv",__FILE__), "r")) !== FALSE) {
//        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//            $num = count($data);
//            $row++;
//            $new_vendor_id = wp_insert_post( array(
//                    'post_title' => $data[0],
//                    'post_type' => 'vendor_profile',
//                    'post_status' => 'publish'
//            ));
//
//            if($new_vendor_id != 0) {
//                $address = array(
//                    'address_line_1' => $data[8],
//                    'city' => $data[7],
//                    'state' => $data[6],
//                    'zip' => $data[5]
//                );
//                update_field('address', $address, $new_vendor_id);
//                for ($c=0; $c < $num; $c++) {
//                    if( $data[$c] != '' ) {
//                        switch ($c) {
//                            case 1: // Last Name
//                                update_field('contact_last', $data[$c], $new_vendor_id);
//                                break;
//                            case 2: // First Name
//                                update_field('contact_first', $data[$c], $new_vendor_id);
//                                break;
//                            case 3: // Cell Phone
//                                update_field('text_phone_number', $data[$c], $new_vendor_id);
//                                break;
//                            case 4: // Phone
//                                update_field('business_phone_number', $data[$c], $new_vendor_id);
//                                break;
//                            case 9: // Website
//                                update_field('website', $data[$c], $new_vendor_id);
//                                break;
//                            case 10: // Email
//                                update_field('email', $data[$c], $new_vendor_id);
//                                break;
//                        }
//                    }
//                }
//                $html .= "Success adding: " . $data[0] . "<br>";
//            } else {
//                $html .= "Error adding: " . $data[0] . "<br>";
//            }
//        }
//        fclose($handle);
//    }
//    return $html;
//    $vendors = get_posts(array('post_type' =>'vendor_profile', 'posts_per_page' => -1));
//    foreach ($vendors as $vendor) {
//        $website = 'https://' . get_field('website', $vendor->ID);
//        update_field('website', $website, $vendor->ID);
//    }
}
add_shortcode('import_vendors', 'import_vendors_func');

/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function() {
    while ( @ob_end_flush() );
} );

/* Adding Google Maps API Key for ACF Form Fields */
function my_acf_init()
{
    acf_update_setting('google_api_key', 'AIzaSyA1SQ_pAK657gUt1SrStTNFIuIiwgf5I3w');
}

add_action('acf/init', 'my_acf_init');

function fn_enqueue_styles()
{
    wp_register_style('fn_default_styles', plugins_url('public/css/default.css', __FILE__), array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('fn_default_styles');
    wp_register_style('swiper_style', 'https://unpkg.com/swiper/css/swiper.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('swiper_style');
    wp_register_style('header_style', plugins_url('public/css/header.css', __FILE__), array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('header_style');
    wp_register_style('jquery-ui-style', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('jquery-ui-style');

    // For jQuery Tables on Admin pages
    //   TODO: Do a check for what page we're on, and only enqueue these if we're in the admin section!!!
    wp_register_style('datatables_style', '//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_register_style('datatables_buttons_style', '//cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css', array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_register_style('datatables_custom', plugins_url('public/css/table.css', __FILE__), array('datatables_style', 'datatables_buttons_style'), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('datatables_custom');

    // TODO: Only render these styles for the article pages!
    wp_register_style('article_styles', plugins_url('public/css/article.css', __FILE__), array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('article_styles');

    wp_register_style('open_sans_light', '//fonts.googleapis.com/css2?family=Encode+Sans:wght@300&display=swap', array(), FRIDAY_NEXT_EXTRAS_VERSION);
    wp_enqueue_style('open_sans_light');

    // 'Vendor List' Page Style
    if (get_post_field('post_name', get_post()) == 'vendor-list') {
        wp_register_style('vendor_list_style', plugins_url('public/css/vendor-style.css', __FILE__), array(), FRIDAY_NEXT_EXTRAS_VERSION);
        wp_enqueue_style('vendor_list_style');
    }
    // 'Vendor Profile' Styles
    if (get_post_type() == 'vendor_profile') {
        wp_register_style('vendor_profile_style', plugins_url('public/css/vendor-profile.css', __FILE__), array(), FRIDAY_NEXT_EXTRAS_VERSION);
        wp_enqueue_style('vendor_profile_style');
    }
}

function fn_enqueue_scripts()
{
    // Scripts
    wp_register_script('facebook_share', 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0');
//    wp_enqueue_script( 'facebook_share' );
    wp_register_script('pinterest_share', 'https://assets.pinterest.com/js/pinit.js');
//    wp_enqueue_script( 'pinterest_share' );

    // For jQuery Tables on Admin pages
    //   TODO: Do a check for what page we're on, and only enqueue these if we're in the admin section!!!
    wp_register_script('datatables_script', '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array(), null,true);
    wp_register_script('datatables_buttons_script', '//cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js', array(), null, true);
    wp_localize_script( 'datatables_script', 'datatablesajax', array('url' => admin_url('admin-ajax.php?action=article_datatables')) );
    wp_enqueue_script('datatables_script');
    wp_enqueue_script('datatables_buttons_script');

    // Just for the Vendor Profile Page (save bandwidth elsewhere)
    if (get_post_type() == 'vendor_profile') {
        wp_register_script('swiper_slider', 'https://unpkg.com/swiper/js/swiper.min.js');
        wp_register_script('sticky_bits', plugins_url('public/js/jquery.stickybits.min.js', __FILE__), array('swiper_slider', 'jquery-ui-tabs'), FRIDAY_NEXT_EXTRAS_VERSION);
        wp_enqueue_script('sticky_bits');
    }

    wp_register_script('fn_scripts', plugins_url('public/js/scripts.js', __FILE__), array('jquery', 'facebook_share', 'pinterest_share', 'jquery-ui-core', 'datatables_script', 'datatables_buttons_script'), FRIDAY_NEXT_EXTRAS_VERSION, true);
    wp_enqueue_script('fn_scripts');
}

add_action('wp_head', 'acf_reqs');
function acf_reqs()
{
    // TODO: Check to see if admin page, then add this!
    acf_form_head();
}

// Login Redirect
function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect them to the default place
            return $redirect_to;
        } elseif ( in_array('editor', $user->roles ) ) {
            // Redirect editors to the saw-admin section!
            return get_page_link(6433);
        } elseif ( in_array('vendor', $user->roles ) ) {
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
function saw_login_logo()
{ ?>
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

add_action('login_enqueue_scripts', 'saw_login_logo');

// add async / defer to facebook script
function add_async_attribute($tag, $handle)
{
    if (('facebook_share' !== $handle) || ('pinterest_share' !== $handle))
        return $tag;
    return str_replace(' src', ' async defer crossorigin="anonymous" nonce="Szqdsx5f" src', $tag);
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

// Vendor Profile Sidebar
function vendor_profile_sidebar()
{
    register_sidebar(
        array(
            'name' => __('Vendor Profile', 'fn_extras'),
            'id' => 'vendor-profile-sidebar',
            'description' => __('Vendor Profile Sidebar', 'fn_extras'),
            'before_widget' => '<div class="vendor-profile-sidebar-content">',
            'after_widget' => "</div>",
            'before_title' => '<div class="vendor-profile-sidebar-title">',
            'after_title' => '</div>',
        )
    );
}

add_action('widgets_init', 'vendor_profile_sidebar');

/* Create Vendor User Role */
add_role(
    'vendor', //  System name of the role.
    __('Vendor'), // Display name of the role.
    array(
        'read' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'upload_files' => true,
        'edit_pages' => true,
        'edit_published_pages' => true,
        'publish_pages' => true,
        'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
    )
);

add_filter('et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1);
function mytheme_et_project_posttype_args($args)
{
    return array_merge($args, array(
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
        'show_ui' => false
    ));
}

// ***** Add Vendor Column to Special Offers CPT Page ******
add_filter('manage_special_offers_posts_columns', 'set_custom_edit_special_offers_columns');
function set_custom_edit_special_offers_columns($columns)
{
    // Add expiration date, Vendor to columns
    $columns['vendor'] = __('Vendor', 'fn_extras');
    $columns['expiration'] = __('Expires', 'fn_extras');

    return $columns;
}

// ***** Get text for Vendor and Expires date columns *****
add_action('manage_special_offers_posts_custom_column', 'special_offers_columns', 10, 2);
function special_offers_columns($column, $post_id)
{
    switch ($column) {
        case 'vendor':
            $vendor_profile_obj = get_field('vendor', $post_id);
            $vendor_name = get_the_title($vendor_profile_obj);
            if (is_string($vendor_name)) {
                echo '<a href="' . get_edit_post_link($vendor_profile_obj) . '">' . $vendor_name . '</a>';
            } else {
                echo "No Vendor Selected";
            }
            break;
        case 'expiration':
            $offer_exp = get_field("offer_end_date");
            if ($offer_exp == null) {
                echo "Permanent";
            } else {
                echo $offer_exp;
            }
            break;
    }
}

// ****** Make the columns sortable ****** //
add_filter('manage_edit-special_offers_sortable_columns', 'saw_sortable_offers');
function saw_sortable_offers($columns)
{
    $columns['vendor'] = 'vendor';
    return $columns;
}

add_action('pre_get_posts', 'special_offers_orderby');
function special_offers_orderby($query)
{
    if (!is_admin()) {
        return;
    }
    $orderby = $query->get('orderby');
    if ('vendor' == $orderby) {
        $query->set('meta_key', 'vendor');
        $query->set('orderby', 'meta_value');
    }
}

// Add custom meta box with Special Offer items in Vendor profile
add_action('add_meta_boxes_vendor_profile', 'add_special_offers_box');
function add_special_offers_box($post)
{
    add_meta_box('special-offer-box', 'Special Offers', 'special_offer_format', 'vendor_profile', 'side', 'default');
}

function special_offer_format($post, $args)
{
    $vendor_id = $post->ID;

    // store matching vendor
    $matching_offers = array();

    // go find all special offers with this vendor as their matching vendor
    $args = array(
        'post_type' => 'special_offers',
        'posts_per_page' => -1
    );
    $all_offers = get_posts($args);
    foreach ($all_offers as $offer) {
        $this_offer_id = $offer->ID;
        // get custom field with Vendor from Special Offers CPT
        $this_vendor = get_field("vendor", $offer->ID);
        if ($this_vendor->ID == $vendor_id) {
            $matching_offers[] = $this_offer_id;
        }
    }
    echo '<p class="special-offers" style="line-height:2.3em;">';

    if (!empty($matching_offers)) {

        // Loop through the Special Offers, and print out links to them
        foreach ($matching_offers as $offer_id) {
            echo '<a href="' . get_edit_post_link($offer_id) . '" target="_blank">' . get_the_title($offer_id) . '</a><br>';
        }
    }
}

// TODO: Change this to be for the profile page
add_filter('single_template', 'vendor_profile_template');
function vendor_profile_template($single_template)
{
    global $post;
    if ($post->post_type == 'vendor_profile') {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/single-vendor_profile.php')) {
            return plugin_dir_path(__FILE__) . 'templates/single-vendor_profile.php';
        }
    }
    return $single_template;
}

// Could use this to populate archive pages - will see!
// [vendors]
function vendors_func($atts)
{
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

function photographer_func($atts)
{
    if (true == get_field('non-existing', get_the_ID())) {
        if (get_field('photographer-manual', get_the_ID())) {
            // non-existing vendor, with a manual name
            $return_string = 'Photography by: ' . get_field('photographer-manual', get_the_ID());
            if (get_field('author', get_the_ID())) {
                $auth_pres = true;
                $return_string .= ' | Written by: ' . get_field('author');
            }
            return $return_string;
        } else if (get_field('author', get_the_ID())) {
            // no photographer, maybe an author, though!
            return 'Written by: ' . get_field('author');
        } else return '';
    } else {
        if (get_field('photographer', get_the_ID())) {
            // Got a Vendor - now check for URL
            $photographer = get_field('photographer', get_the_ID());
            if (get_field('website', $photographer->ID)) {
                $return_string = 'Photography by: <a href="' . get_permalink($photographer->ID) . '" alt="' . get_the_title($photographer->ID) . '" style="color:inherit;" target="_blank">' . get_the_title($photographer->ID) . '</a>';
            } else {
                // Vendor doesn't have a website URL in their profile yet
                $return_string = 'Photography by: ' . get_field('photographer', get_the_ID())->title;
            }
            if (get_field('author', get_the_ID())) {
                $return_string .= ' | Written by: ' . get_field('author');
            }
            return $return_string;
        } else {
            // nothing selected (catch-all)
            return '';
        }
    }
}

add_shortcode('photographer', 'photographer_func');

/************************* AJAX FOR DATATABLES *********************************/
// Add Post title to custom meta
add_action( 'transition_post_status', 'duplicate_title', 10, 3 );
function duplicate_title( $new, $old, $post ) {
    if ( $post->post_type == 'post' || $post->post_type == 'spotlight' || $post->post_type == 'styled_shoot' || $post->post_type == 'wedding_story') {
        update_post_meta( $post->ID, 'd_title', $post->post_title );
    }
}

add_action( 'wp_ajax_article_datatables', 'my_ajax_getpostsfordatatables' );
add_action( 'wp_ajax_nopriv_article_datatables', 'my_ajax_getpostsfordatatables' );

function my_ajax_getpostsfordatatables() {

    header("Content-Type: application/json");

    $request= $_GET;

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
        'post_type' => array('spotlight', 'styled_shoot', 'wedding_story'),
        'posts_per_page' => $request['length'],
        'offset' => $request['start'],
        'order' => $request['order'][0]['dir']
    );

    if ($request['order'][0]['column'] == 1 || $request['order'][0]['column'] == 2 || $request['order'][0]['column'] == 3 || $request['order'][0]['column'] == 5) {
        $args['orderby'] = $columns[$request['order'][0]['column']];
    } elseif ($request['order'][0]['column'] == 4) {
        $args['orderby'] = 'date';
    } else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }

    //$request['search']['value'] <= Value from search
    if( !empty($request['search']['value']) ) { // When datatables search is used
        $args['s'] = $request['search']['value'];
    }

    $article_query = new WP_Query($args);
    $totalData = $article_query->found_posts;

    if ( $article_query->have_posts() ) {
        $data = array();
        while ( $article_query->have_posts() ) {

            $article_query->the_post();

            $thumbnail = get_field('featured_image_thumbnail');
            $image = '<img src="' . esc_url($thumbnail['url']) . '" alt="' . esc_url($thumbnail['alt']) . '" width=90 height=90 />';
            $nestedData = array();
            $nestedData[] = $image;
            $nestedData[] = get_post_type();
            $nestedData[] = '<a href="' . get_the_permalink() . '" alt="' . get_the_title() . '" target="_blank">' . get_the_title() . '</a>';
            $nestedData[] = get_field('author');
            $nestedData[] = get_the_date("m/d/Y") . '<br>' . get_the_date("g:i A");
            $nestedData[] = (get_field('is_active') ? "Yes" : "No" );
            $nestedData[] = '<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-article?a_id=' . get_the_ID() . '">Edit</a></li>
							<li><a href="#">Deactivate</a></li>
							<li><a href="' . get_delete_post_link() . '" alt="Delete this Article">Delete</a></li>
					    </ul>
					</div>';

            $data[] = $nestedData;
        }

        wp_reset_query();

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data
        );

        echo json_encode($json_data);

    } else {
        $json_data = array(
            "data" => array()
        );
        echo json_encode($json_data);
    }
    wp_die();

    // OLD
//    global $wpdb;
//    $posts_per_page = 30;
//    $page = 1;
//
//    $args = array(
//        'post_type' => array('spotlight', 'styled_shoot', 'wedding_story'),
//        'post_per_page' => $posts_per_page,
//        'paged' => $page
//    );
//
//    // query the data
//    $articles = new WP_Query($args);
//
//    // create an empty array and fill it with articles
//    $article_json = array();
//    while($articles->have_posts()) : the_post();
//        $row = array(
//            'featuredImage' => get_field('featured_image_thumbnail'),
//            'type' => get_post_type(),
//            'title' => get_the_title(),
//            'author' => get_field('author'),
//            'postDate' => get_the_date("m/d/Y") . '<br>' . get_the_date("g:i A"),
//            'isActive' => (get_field('is_active') ? "Yes" : "No" ),
//            'action' => '<div class="vmenu-container">
//						<button class="vmenu-button" type="button">
//					            <i class="fas fa-chevron-down"></i>
//						</button>
//					    <ul class="vmenu-dropdown">
//					    	<li><a href="/saw-admin/edit-article?a_id=' . get_the_ID() . '">Edit</a></li>
//							<li><a href="#">Deactivate</a></li>
//							<li><a href="' . get_delete_post_link() . '" alt="Delete this Article">Delete</a></li>
//					    </ul>
//					</div>'
//        );
//        print_r($row);
//        $article_json[] = $row;
//    endwhile;
//
//    //return the result to the ajax request and die
//    echo json_encode(array('data' => $article_json));
//    wp_reset_postdata();
//    die($article_json);
}


/* Vendors Table Shortcode */
function vendor_table_func($atts)
{

    // grab all vendors to display on the table
    $args = array(
        'post_type' => 'vendor_profile',
        'posts_per_page' => -1
    );
    $vendors = get_posts($args);


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
	    <tbody>';

    foreach ($vendors as $vendor) {
        $vid = $vendor->ID;
        $vtable .= '<tr>';
        $vtable .= '<td><a href="' . get_permalink($vid) . '" target="_blank">' . get_the_title($vid) . '</a></td>';
        $categories = get_the_category($vid);
        $carray = [];
        foreach ($categories as $category) {
            $carray[] = $category->name;
        }
        $cstring = join(", ", $carray);
        $vtable .= '<td>' . $cstring . '</td>';
        $vtable .= '<td>' . $vendor->post_name . '</td>';
        $vtable .= '<td>Group 1, Group 2</td>';
        $vtable .= '<td>5</td>';
        $vtable .= '<td>Yes</td>';
        $vtable .= '<td>
					<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-advertiser?ven_id=' . $vendor->ID . '">Edit</a></li>
					        <li><a href="#">Auto-login</a></li>
							<li><a href="#">Deactivate</a></li>
							<li><a href="' . get_delete_post_link($vendor->ID) . '" alt="Delete this Advertiser">Delete</a></li>
					    </ul>
					</div>
				</td>';
        $vtable .= '</tr>';
    }

    $vtable .= '</tbody>
	</table>';

    return $vtable;
}

add_shortcode('vendors_table', 'vendor_table_func');

function article_table_func($atts)
{
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

add_shortcode('articles_table', 'article_table_func');

function category_table_func($atts)
{

    // grab all categories to display on the table
    $categories = get_categories();


    $table = '<table id="category_table" class="dataTable compact display" data-page-length="30">
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
	    <tbody>';

    foreach ($categories as $category) {
        $cid = $category->ID;
        $table .= '<tr>';
        $table .= '<td>' . $category->name . '</td>';
        $table .= '<td>' . $category->slug . '</td>';
        $table .= '<td>Keywords</td>'; // TODO: need taxonomy for keywords
        $table .= '<td>' . $category->description . '</td>';
        $table .= '<td>Yes</td>'; // TODO: is Active (create boolean field)
        $table .= '<td>
					<div class="vmenu-container">
						<button class="vmenu-button" type="button">
					            <i class="fas fa-chevron-down"></i>
						</button>
					    <ul class="vmenu-dropdown">
					    	<li><a href="/saw-admin/edit-article?a_id=' . $category->term_id . '">Edit</a></li>
							<li><a href="#">Deactivate</a></li>
							<li><a href="#">Delete</a></li>
					    </ul>
					</div>
				</td>';
        $table .= '</tr>';
    }

    $table .= '</tbody>
	</table>';

    return $table;
}

add_shortcode('categories_table', 'category_table_func');

function vendor_admin_form_func($atts)
{
    if (isset($_GET['ven_id'])) {
        $vendor_id = $_GET['ven_id'];
        $args = array(
            'post_id' => $vendor_id,
            'post_title' => true,
            'updated_message' => 'Advertiser successfully updated!',
            'instruction_placement' => 'field'
        );
        $html = '<h2>' . get_the_title($vendor_id) . '</h1>';
        ob_start();
        acf_form($args);
        $html .= ob_get_contents();
        ob_end_clean();
        return $html;
    } else {
        //Handle the case where there is no parameter
        return 'No advertiser selected. Head back to the <a href="/saw-admin/advertisers" alt="SAW Advertisers">Advertisers table</a> and try again!';
    }

}

add_shortcode('vendor_edit_form', 'vendor_admin_form_func');

/* Change Advertiser Title label to 'Company Name' */
function change_post_title_name( $field ) {
    if( is_page( array('add-advertiser','advertisers', 'edit-advertiser' ) ) ) { // if on the vendor page
        $field['label'] = 'Company Name';
    } elseif (is_page( array('add-article','articles', 'edit-article' ))) {
        $field['label'] = 'URL Title';
    }
    return $field;
}
add_filter('acf/load_field/name=_post_title', 'change_post_title_name');

function vendor_admin_add_form_func($atts)
{
    $args = array(
        'post_id' => 'new_post',
        'post_title' => true,
        'new_post' => array(
            'post_type' => 'vendor_profile',
            'post_status' => 'publish'
        ),
        'submit_value' => 'Create new Advertiser',
        'instruction_placement' => 'field',
        'return' => '/saw-admin/edit-advertiser?ven_id=%post_id%'
    );
    ob_start();
    acf_form($args);
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

add_shortcode('vendor_add_form', 'vendor_admin_add_form_func');

/* Auto-fill existing URL slug */
function acf_vendor_permalinks( $value, $post_id, $field ) {

    $possible_post_types = array(
            'vendor_profile'
    );
    if ( in_array(get_post_type( $post_id ),$possible_post_types) && !acf_is_empty($value)) {

        $new_slug = sanitize_title( $value );

        wp_update_post( array(
                'ID'         => $post_id,
                'post_name'  => $new_slug,
            )
        );
    }

    return $new_slug;
}
add_filter( 'acf/update_value/name=permalink_title', 'acf_vendor_permalinks', 10, 3 );

function edit_article_text() {
    if (isset($_GET['a_id'])) {
        $article_id = $_GET['a_id'];
        $post_type_obj = get_post_type_object(get_post_type($article_id));
        return 'Edit ' . esc_html($post_type_obj->labels->singular_name);
    } else return 'Edit Article';
}
add_shortcode('edit_article', 'edit_article_text');

/* Add new Category SHORTCODE */
/* TODO: This is wrong - not creating a cat TERM yet! */
function category_admin_add_form_func($atts)
{
    $args = array(
        'post_id' => 'new_post',
        'post_title' => true,
        'new_post' => array(
            'post_type' => 'vendor_profile',
            'post_status' => 'publish'
        ),
        'submit_value' => 'Create new Category',
        'instruction_placement' => 'field',
        'return' => '/saw-admin/edit-category?cid=%post_id%'
    );
    ob_start();
    acf_form($args);
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

add_shortcode('category_add_form', 'category_admin_add_form_func');

/* Add extra fields to the category form dynamically */
add_action('acf/input/form_data', 'category_form_extras');
function category_form_extras( $data ) {
    echo '
        <div class="acf-field acf-field-text is-required" data-name="_cat_title">
            <div class="acf-input">
                <div class="acf-label">
                    <label for="acf-_cat_title">
                        Title
                        <span class="acf-required">*</span>
                    </label>
                </div>
                <div class="acf-input-wrap">
                    <input id="acf-_cat_title" type="text" name="acf[_cat_title]" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                </div>
            </div>
        </div>
        <input type="hidden" name="_my_hidden_input" value="123" />
    ';
}

/* Create new Category Term when category form is submitted */
function save_category($post_id) {
    // if new post, skip this
    if($post_id != 'new') {
        return $post_id;
    }
    // Create the new category term
    $category_key = acf_get_field_key( 'category', $post_id ); // this gets the field key for this exact field
    $category = $_POST['acf'][$category_key];

    $new_cat = wp_insert_term(
        $category,
        'category',
        array(
            'description' => '', // get description from form
            'slug' => ''         // get slug from form as well
        )
    );
}
add_filter('acf/pre_save_post' , 'save_category' );

function article_admin_form_func($atts)
{
    if (isset($_GET['a_id'])) {
        $article_id = $_GET['a_id'];
        $args = array(
            'post_id' => $article_id,
            'post_title' => true,
            'updated_message' => 'Article successfully updated!',
            'instruction_placement' => 'field'
        );
        $html = '<h2>' . get_the_title($article_id) . '</h1>';
        ob_start();
        acf_form($args);
        $html .= ob_get_contents();
        ob_end_clean();
        return $html;
    } else {
        //Handle the case where there is no parameter
        return 'No article selected. Head back to the <a href="/saw-admin/articles" alt="SAW Articles">Articles table</a> and try again!';
    }

}

add_shortcode('article_edit_form', 'article_admin_form_func');

function vendor_article_add_form_func($atts)
{
    if (isset($_GET['cpt'])) {
        $article_type = $_GET['cpt'];
        $nice_name = $article_type;
        switch ($article_type) {
            case "spotlight":
                $nice_name = "Featured Spotlight";
                break;
            case "styled_shoot":
                $nice_name = "Styled Shoot";
                break;
            case "wedding_story":
                $nice_name = "Wedding Story";
                break;
            case "blog":
                $nice_name = "Blog Post";
                break;
            default:
                $nice_name = "n.a.";
                break;
        }
        $args = array(
            'post_id' => 'new_post',
            'post_title' => true,
            'new_post' => array(
                'post_type' => $article_type,
                'post_status' => 'publish'
            ),
            'submit_value' => 'Create new ' . $nice_name,
            'instruction_placement' => 'field',
            'return' => '/saw-admin/edit-article?a_id=%post_id%'
        );
        $html = '<h2>Add a New ' . $nice_name . '</h1>';
        ob_start();
        acf_form($args);
        $html .= ob_get_contents();
        ob_end_clean();
        return $html;
    } else {
        return 'Something went wrong - please try again!';
    }
}

add_shortcode('article_add_form', 'vendor_article_add_form_func');

function vendor_url_func($atts)
{
    if (get_post_type() == 'vendor_profile') {
        $button_html = '<div class="saw-button"><a target="_blank" href="';
        $button_html .= get_field('website', get_the_ID());
        $button_html .= '">Visit Our Website <i class="fa fa-angle-double-right pl-lg-2 pl-1" aria-hidden="true"></i></a></div>';
        return $button_html;
    } else {
        return '';
    }
}

add_shortcode('vendor_url', 'vendor_url_func');

// Display Article Content from Shortcode //
function article_content_func($atts)
{
    $return_string = '';

    // We have the field - time to loop through
    if (have_rows('article_content', get_the_ID())):

        // Loop through rows.
        while (have_rows('article_content', get_the_ID())) : the_row();
            $return_string .= '<div class="article-content">';

            // Case: 1 column
            if (get_row_layout() == '1_column_wide'):
                $return_string .= '<div class="article-content-row col-one">';
                $column_one = get_sub_field_object('column_content', get_the_ID());
                $return_string .= '<div class="article-one-column">';
                $return_string .= process_row($column_one['key'], get_the_ID());
                $return_string .= '</div>';
                $return_string .= '</div>';
            // Case: 2 columns
            elseif (get_row_layout() == '2_columns_equal'):
                $return_string .= '<div class="article-content-row col-two">';
                $column_one = get_sub_field_object('column_1');
                $return_string .= '<div class="article-two-columns">';
                $return_string .= process_row($column_one['key'], get_the_ID());
                $return_string .= '</div>';
                $column_two = get_sub_field_object('column_2');
                $return_string .= '<div class="article-two-columns last">';
                $return_string .= process_row($column_two['key'], get_the_ID());
                $return_string .= '</div>';
                $return_string .= '</div>';

            // Case: 3 columns
            elseif (get_row_layout() == '3_columns_equal'):
                $return_string .= '<div class="article-content-row col-three">';
                $column_one = get_sub_field_object('column_1');
                $return_string .= '<div class="article-three-columns">';
                $return_string .= process_row($column_one['key'], get_the_ID());
                $return_string .= '</div>';
                $column_two = get_sub_field_object('column_2');
                $return_string .= '<div class="article-three-columns last">';
                $return_string .= process_row($column_two['key'], get_the_ID());
                $return_string .= '</div>';
                $column_three = get_sub_field_object('column_3');
                $return_string .= '<div class="article-three-columns last">';
                $return_string .= process_row($column_three['key'], get_the_ID());
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
        return 'No content to display 2';
    endif;
}

add_shortcode('article_content', 'article_content_func');

// process the above article-content more easily
function process_row($field_key, $post_id)
{
    $return_string = '';
    if (have_rows($field_key, $post_id)) :
        while (have_rows($field_key, $post_id)) : the_row();
            switch (get_row_layout()) {
                case "blank_block":
                    $return_string .= '<div class="article-blank-block"></div>';
                    break;
                case "image_block":
                    $image = get_sub_field('image');
                    if (!empty($image)):
                        $return_string .= '<div class="article-image-block">';
                        $return_string .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
                        $return_string .= '</div>';
                    endif;
                    break;
                case 'text_block':
                    if (get_sub_field('text')):
                        $return_string .= '<div class="article-text-block">';
                        $return_string .= get_sub_field('text');
                        $return_string .= '</div>';
                    endif;
                    break;
                case 'video_block':
                    if (get_sub_field('video')):
                        $return_string .= '<div class="article-video-block embed-container">';
                        ob_start();
                        the_sub_field('video');
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


// display the tabbed fb, ig, pi social media block in the sidebar (and anywhere else!)
function social_media_tab_func($atts)
{
    $html = '<div class="all-tabs-container">';
    $html .= '<div id="social-tabs">';
    $html .= '<span class="social-tabs-triangle"></span>
                <ul>
                    <li><a href="#facebook">Facebook</a></li>
                    <li><a href="#pinterest">Pinterest</a></li>
                    <li><a href="#instagram">Instagram</a></li>        
                </ul>';
    $fb_url = get_field("facebook", get_the_ID());
    $html .= '<div id="facebook" class="social-share-div"><div class="fb-page" data-href="' . $fb_url . '" data-tabs="timeline" data-width="" data-height="360" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="' . $fb_url . '" class="fb-xfbml-parse-ignore"><a href="' . $fb_url . '">' . get_the_title() . '</a></blockquote></div></div>';
    $html .= '<div id="pinterest" class="social-share-div"><a data-pin-do="embedUser" data-pin-board-width="100%" data-pin-scale-height="250" data-pin-scale-width="80" href="' . get_field('pinterest', get_the_ID()) . '"></a></div>';
    $html .= '<div id="instagram" class="social-share-div">Instagram content here.<br>And a new line.<br>Another.</div>';
    $html .= '</div></div>';
    $html .= '<script type="text/javascript">
                jQuery( function() {
                    jQuery("#social-tabs").tabs({
                        event: "mouseover"
                    });
                    jQuery(".all-tabs-container").parent().parent().addClass("social-sidebar-tabs");
                });
              </script>';
    return $html;
}

add_shortcode('social_media_tab', 'social_media_tab_func');

// Font Awesome Integration
/**
 * Font Awesome CDN Setup SVG
 *
 * This will load Font Awesome from the Font Awesome Free or Pro CDN.
 */
if (!function_exists('fa_custom_setup_cdn_svg')) {
    function fa_custom_setup_cdn_svg($cdn_url = '', $integrity = null)
    {
        $matches = [];
        $match_result = preg_match('|/([^/]+?)\.js$|', $cdn_url, $matches);
        $resource_handle_uniqueness = ($match_result === 1) ? $matches[1] : md5($cdn_url);
        $resource_handle = "font-awesome-cdn-svg-$resource_handle_uniqueness";

        foreach (['wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts'] as $action) {
            add_action(
                $action,
                function () use ($cdn_url, $resource_handle) {
                    wp_enqueue_script($resource_handle, $cdn_url, [], null);
                }
            );
        }

        if ($integrity) {
            add_filter(
                'script_loader_tag',
                function ($html, $handle) use ($resource_handle, $integrity) {
                    if (in_array($handle, [$resource_handle], true)) {
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
 * @return bool
 */
function acf_get_field_key( $field_name, $post_id ) {
    global $wpdb;
    $acf_fields = $wpdb->get_results( $wpdb->prepare( "SELECT ID,post_parent,post_name FROM $wpdb->posts WHERE post_excerpt=%s AND post_type=%s" , $field_name , 'acf-field' ) );
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
    $field_groups = acf_get_field_groups( array(
        'post_id' => $post_id,
    ) );
    foreach ( $field_groups as $field_group )
        $field_groups_ids[] = $field_group['ID'];

    // Check if field is part of one of the field groups
    // Return the first one.
    foreach ( $acf_fields as $acf_field ) {
        if ( in_array($acf_field->post_parent,$field_groups_ids) )
            return $acf_fields[0]->post_name;
    }
    return false;
}