$ = jQuery;

$(document).ready(function () {

    $(".vendor-login a").on('click', function () {
        $("div.vendor-login-form").toggleClass("visible");
    });
    $(".header-search a").on('click', function () {
        $("div.header-search-dropdown").toggleClass("visible");
        $("form.et_pb_searchform input.et_pb_s").trigger("focus");
    });

    // Track Homepage Local Fave Clicks
    $(".local-fave-link").on('click', function () {
        let data = {
            'action': 'update_click_count',
            'typeToUpdate': 'vendor_profile',
            'linkType': 'local_fave',
            'targetId': $(this).attr('id')
        }

        $.post(fnajax.ajax_url, data, function (response) {
            if (response.post_type == 'local_fave') {
                console.log("Local Fave: " + response.content);
            }
        });
    });
    // Track Home Slider Clicks
    $(".home-slider-container .read-more a").on('click', function () {
        let data = {
            'action': 'update_click_count',
            'typeToUpdate': 'home_slider',
            'linkType': 'home_slider',
            'targetId': $(this).attr('id')
        }

        $.post(fnajax.ajax_url, data, function (response) {
            if (response.post_type == 'home_slider') {
                console.log("Home Slider: " + response.content);
            }
        });
    })
    // Track Ad Clicks on Articles
    $("body.single img.banner-ad-tracking").on('click', function () {
        let data = {
            'action': 'update_click_count',
            'typeToUpdate': 'single',
            'linkType': 'banner_ad',
            'targetId': $(this).attr('data-target-id')
        }

        $.post(fnajax.ajax_url, data, function (response) {
            console.log("Article: " + response.content + ' ' + response.post_type + ' ' + response.target_id);
        });
    })

    // Home hero slider hidden text display on mobile
    // get html from ".hero-text-content" and put it in ".text-below-hero"
    $(".text-below-hero").html(function () {
        let thisID = $(this).attr("id");
        let textContent = '.hero-text-content.' + thisID; // go grab the text above and fill it here!
        let returnHtml = '';

        // Check what type of slide this comes from, so we can only put in the necessary fields
        if ($(this).hasClass('style-1')) {
            let heading = $(textContent + ' .head-2').wrap('<span/>').parent().html();
            returnHtml += heading;
            $(textContent + ' .head-2').unwrap();
            let quote = $(textContent + ' .head-1').wrap('<span/>').parent().html();
            returnHtml += quote;
            $(textContent + ' .head-1').unwrap();

            let readMore = $(textContent + ' .read-more.saw-button').wrap('<span/>').parent().html();
            returnHtml += readMore;
            $(textContent + ' .read-more.saw-button').unwrap();
        } else if ($(this).hasClass('style-2')) {
            let quote = $(textContent + ' .head-1').wrap('<span/>').parent().html();
            returnHtml += quote;
            $(textContent + ' .head-1').unwrap();
            let readMore = $(textContent + ' .read-more.saw-button').wrap('<span/>').parent().html();
            returnHtml += readMore;
            $(textContent + ' .read-more.saw-button').unwrap();
        }
        return returnHtml;
    });

    // Change the nav bar to fixed position after a certain amount of scroll
    let navBar = $(".vendor-sticky-nav");
    $("body").on('scroll', function () {
        let fromTop = window.scrollY;
        // 54px - once the nav bar is 54px from the top, make it fixed
        if (navBar.offsetTop <= 54) {
            navBar.css("position", "fixed");
            navBar.css("top", "54px");
            navBar.css("left", "0");
            navBar.css("z-index", "99");
        }
    });
    let vendorTable = $("#vendor_table").DataTable({
        dom: 'Bfrtip',
        ajax: {
            url: '/wp-admin/admin-ajax.php?action=vendor_datatables',
        },
        processing: true,
        serverSide: true,
        buttons: [
            {
                text: 'New Advertiser',
                action: function (e, dt, node, config) {
                    window.location = "/saw-admin/add-advertiser";
                }
            }
        ]
    });
    vendorTable.on('draw', function () {
        dropdownButtons();
    });
    vendorTable.on('search.dt', function () {
        dropdownButtons();
    });
    let categoryTable = $("#category_table").DataTable({
        dom: 'Bfrtip',
        ajax: {
            url: '/wp-admin/admin-ajax.php?action=category_datatables',
        },
        processing: true,
        serverSide: true,
        buttons: [
            {
                text: 'New Category',
                action: function (e, dt, node, config) {
                    window.location = "/saw-admin/add-category";
                }
            }
        ]
    });
    categoryTable.on('draw', function () {
        dropdownButtons();
    });
    categoryTable.on('search.dt', function () {
        dropdownButtons();
    });
    let articleTable = $("#article_table").DataTable({
        ajax: datatablesajax,
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        buttons: [
            {
                extend: 'collection',
                text: 'New Article',
                buttons: [
                    {
                        text: 'Spotlight',
                        action: function (e, dt, node, config) {
                            window.location = "/saw-admin/add-article?cpt=spotlight";
                        }
                    },
                    {
                        text: 'Styled Shoot',
                        action: function (e, dt, node, config) {
                            window.location = "/saw-admin/add-article?cpt=styled_shoot";
                        }
                    },
                    {
                        text: 'Wedding Story',
                        action: function (e, dt, node, config) {
                            window.location = "/saw-admin/add-article?cpt=wedding_story";
                        }
                    },
                    {
                        text: 'Blog Post',
                        action: function (e, dt, node, config) {
                            window.location = "/saw-admin/add-article?cpt=post";
                        }
                    }
                ]
            }
        ]
    });
    articleTable.on('draw', function () {
        dropdownButtons();
    });
    articleTable.on('search.dt', function () {
        dropdownButtons();
    });
    let homeSlideTable = $("#home_slider_table").DataTable({
        dom: 'Bfrtip',
        ajax: {
            url: '/wp-admin/admin-ajax.php?action=homeslide_datatables',
        },
        processing: true,
        serverSide: true,
        buttons: [
            {
                text: 'New Home Slider',
                action: function (e, dt, node, config) {
                    window.location = "/saw-admin/add-home-slider";
                }
            }
        ]
    });
    homeSlideTable.on('draw', function () {
        dropdownButtons();
    });
    homeSlideTable.on('search.dt', function () {
        dropdownButtons();
    });
    let bannerTable = $("#banner_ad_table").DataTable({
        dom: 'Bfrtip',
        ajax: {
            url: '/wp-admin/admin-ajax.php?action=banner_datatables',
        },
        processing: true,
        serverSide: true,
        buttons: [
            {
                text: 'New Banner Ad',
                action: function (e, dt, node, config) {
                    window.location = "/saw-admin/add-banner-ad";
                }
            }
        ]
    });
    bannerTable.on('draw', function () {
        dropdownButtons();
    });
    bannerTable.on('search.dt', function () {
        dropdownButtons();
    });
    let specialOfferTable = $("#special_offer_table").DataTable({
        dom: 'Bfrtip',
        ajax: {
            url: '/wp-admin/admin-ajax.php?action=special_offer_datatables',
        },
        processing: true,
        serverSide: true,
        buttons: [
            {
                text: 'New Special Offer',
                action: function (e, dt, node, config) {
                    window.location = "/saw-admin/add-special-offer";
                }
            }
        ]
    });
    specialOfferTable.on('draw', function () {
        dropdownButtons();
    });
    specialOfferTable.on('search.dt', function () {
        dropdownButtons();
    });
    dropdownButtons();

    function dropdownButtons() {
        $(".vmenu-button").on('click', function (event) {
            $(this).parent().toggleClass("visible");

        });
        $(document).on('click', function (event) {
            $target = $(event.target);
            if (!$target.closest('.vmenu-container').length && $('.vmenu-container').hasClass('visible')) {
                $(".visible").removeClass('visible');
            }
        });
    }

    /******************* DEACTIVATE BUTTON *************************/
    $(document).on('click', '.deactivate-post', function () {
        let data = {
            'action': 'deactivate_post',
            'article_id': $(this).attr('id')
        }

        $.post(fnajax.ajax_url, data, function (response) {
            // do something once the post has been deactivated!
            // maybe redraw the tables?
            if (response.post_type == 'vendor_profile') {
                alert("Vendor Profile Deactivated!");
                vendorTable.draw('page');
            } else if (response.post_type == 'post' || response.post_type == 'styled_shoot' || response.post_type == 'spotlight' || response.post_type == 'wedding_story') {
                alert("Article Deactivated!");
                articleTable.draw('page');
            } else if (response.post_type == 'category') {
                alert("Category Deactivated!");
                categoryTable.draw('page');
            } else if (response.post_type == 'home_slide') {
                alert("Home Slider Deactivated!");
                homeSlideTable.draw('page');
            } else if (response.post_type == 'banner') {
                alert("Banner Ad Deactivated!");
                bannerTable.draw('page');
            } else if (response.post_type == 'special_offers') {
                alert("Special Offer Deactivated!");
                specialOfferTable.draw('page');
            }
        });
    });

    /******************* ACTIVATE BUTTON *************************/
    $(document).on('click', '.activate-post', function () {
        let data = {
            'action': 'activate_post',
            'article_id': $(this).attr('id')
        }
        $.post(fnajax.ajax_url, data, function (response) {
            // do something once the post has been deactivated!
            // maybe redraw the tables?
            if (response.post_type === 'vendor_profile') {
                alert("Vendor Profile Activated!");
                vendorTable.draw('page');
            } else if (response.post_type === 'post' || response.post_type === 'styled_shoot' || response.post_type === 'spotlight' || response.post_type === 'wedding_story') {
                alert("Article Activated!");
                articleTable.draw('page');
            } else if (response.post_type === 'category') {
                alert("Category Activated!");
                categoryTable.draw('page');
            } else if (response.post_type === 'home_slide') {
                alert("Home Slider Activated!");
                homeSlideTable.draw('page');
            } else if (response.post_type === 'banner') {
                alert("Banner Ad Activated!");
                bannerTable.draw('page');
            } else if (response.post_type === 'special_offers') {
                alert("Special Offer Activated!");
                specialOfferTable.draw('page');
            }
        });
    });

    /* Vendor Spotlight Widget Buttons */
    $('.spotlight-widget-container .individual-spotlight').on('click', function () {
        // Get the read-more link, then go to it
        window.location = $(this).find('a').attr('href');
    });

    $('.admin-save-button')
        .parent().css("z-index", "11")
        .on('click', function () {
            // when clicked, click the form submit button
            $('input[type="submit"].acf-button.button-primary').click();
        });
    // navBar.stickybits();

    // check the post type with AJAX, and if 'wedding-story', come in and remove the size from the images
    var body = $('body');
    if (body.hasClass("single-wedding_story") || body.hasClass("single-spotlight") || body.hasClass("single-post") || body.hasClass("single-styled_shoot")) {
        resizeThumbnails($('.wedding-story-blog-square .et_pb_image_container'));
    }

    function resizeThumbnails($container) {
        let images = $container.find('img'); // Get all the images inside your $container

        images.each(function (index, element) {
            let src = $(element).attr('src'); // Get the image's source
            $(element).attr('src', src.replace('-400x250', '')); // Remove the thumbnail size portion from the source and replace it
        });
    }

    // ********* HOMEPAGE MID-NAV BAR VENDOR DROPDOWN MENU ************** //
    $('#home-mid-nav-right li.vendor-dropdown').on('click', function (e) {
        $('div.midnav-vendor-list').toggleClass('visible');
        e.preventDefault();
    });

    $('#menu-header-top-menu li.vendor-dropdown').on('click', function (e) {
        $('div.midnav-vendor-list').toggleClass('visible');
        e.preventDefault();
    });

    $('a#vendor-tablet-link').on('click', function (e) {
        $('div.midnav-vendor-list-tablet').toggleClass('visible');
        e.preventDefault();
    });


    // dropdown for tablet/phone widths
    // $('a#vendor-tablet-link').on('click', function(e) {
    // 	if ($(window).width() < 768) {
    // 		// phone width, so do full-screen modal
    // 		jPopupDemo.open();
    // 	} else {
    // 		// tablet width, so do tablet normal dropdown
    // 		$('div.midnav-vendor-list-tablet').toggleClass('visible');
    // 	}
    // 	e.preventDefault();
    // });

    // ********* FOOTER VENDOR MENU AND STAY CONNECTED POPUP ************** //
    $('a.hamburger-click').on('click', function (e) {
        $('div.vendor-list-container').toggleClass('visible');
        e.preventDefault();
    });
    $('#footer-stay-connected .red-container').on('click', function (e) {
        $('div.pop-up-social').toggleClass('visible');
        e.preventDefault();
    });
    // class to give display: block; --> header-search-dropdown
    // $("#sidebar").stickybits();

    // Format callable phone number
    // jQuery('.vendor-phone-call-text').text(function(i, text) {
    //     $phone_formatted = text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    //     return '<a href="tel:' + $phone_formatted + '">' + $phone_formatted + '</a>';
    // });
    $('.spotlight-vendor-info-container .vendor-phone-number span a').text(function (i, text) {
        return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    });

    // Set up the offset so it can be updated while the page is live
    let offset = 0;
    let alphabetize = false;
    let alphaClick = false;
    $('#archive-more-button a').on('click', function (e) {
        offset += $(this).data('offset');
        let post_type = $(this).data('post_type');
        let category = $(this).data('category-id');
        let searchTerm = $(this).data('search-query');
        alphaClick = false;
        console.log("Clicked Archive More");
        console.log(offset);
        // Want to set the offset based on how many articles are currently showing
        let data = {
            'action': 'archive_moreposts',
            'offset': offset,
            'post_type': post_type,
            'category': category,
            'alphabetize': alphabetize,
            'alphaClick': alphaClick,
            'search_term': searchTerm
        };
        $.post(fnajax.ajax_url, data, function (response) {
            // can pass messages back via 'response' if I want to check to see if everything worked
            $('#post-archive-list').append(response.newhtml);
        });
        e.preventDefault();
    });

    $('.alphabetize a.sort-alphabetically').on('click', function (e) {
        e.preventDefault();

        // go back to functions.php and get the current number of posts, but in alphabetical order
        let offsetButton = $('#archive-more-button a');
        offset = offsetButton.data('offset');
        // let post_type = offsetButton.data('post_type');
        // let category = offsetButton.data('category-id');
        let post_type = $(this).data('post_type');
        let category = $(this).data('category-id');
        alphaClick = true;
        alphabetize = true;
        let data = {
            'action': 'archive_sortposts',
            'offset': offset,
            'post_type': post_type,
            'category': category,
            'alphabetize': alphabetize,
            'alpha_click': alphaClick
        };
        $.post(fnajax.ajax_url, data, function (response) {
            // can pass messages back via 'response' if I want to check to see if everything worked
            $('#post-archive-list').html(response.newhtml);
        });
        $(this).hide();

    });

    // In client admin section, intercept YouTube links and do a full-screen modal to display them
    $('.profile-team-links a').on('click', function(e) {
        e.preventDefault();
        let oembedContainer = $('#client-oembed-container');
        // make an ajax call here to go get the oembed contents for this specific URL that was clicked
        let videoUrl = $(this).attr('href');
        let data = {
            'action': 'get_oembed',
            'videoUrl': videoUrl
        }
        $.post(fnajax.ajax_url, data, function(response) {
            // the necessary oembed html will be returned from this ajax call
            oembedContainer.html(response.oembedhtml);
        });
        oembedContainer.addClass('visible');
        MicroModal.show('tutorial-video-modal', {awaitCloseAnimation:true});
    });

    // var swiper = new Swiper('.swiper-container', {
    //     slidesPerView: 'auto',
    //     centeredSlides: true,
    //     spaceBetween: 5,
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    //     navigation: {
    //         nextEl: '.swiper-button-next',
    //         prevEl: '.swiper-button-prev'
    //     }
    // });
});