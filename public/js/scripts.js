$ = jQuery;

$(document).ready(function () {

	$(".vendor-login a").on('click',function () {
		$("div.vendor-login-form").toggleClass("visible");
	});
	$(".header-search a").on('click', function () {
		$("div.header-search-dropdown").toggleClass("visible");
	});

	// Change the nav bar to fixed position after a certain amount of scroll
	let navBar = $(".vendor-sticky-nav");
	$("body").on('scroll',function () {
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
				action: function ( e, dt, node, config ) {
					window.location = "/saw-admin/add-advertiser";
				}
			}
		]
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
				action: function ( e, dt, node, config ) {
					window.location = "/saw-admin/add-category";
				}
			}
		]
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
						action: function ( e, dt, node, config ) {
							window.location = "/saw-admin/add-article?cpt=spotlight";
						}
					},
					{
						text: 'Styled Shoot',
						action: function ( e, dt, node, config ) {
							window.location = "/saw-admin/add-article?cpt=styled_shoot";
						}
					},
					{
						text: 'Wedding Story',
						action: function ( e, dt, node, config ) {
							window.location = "/saw-admin/add-article?cpt=wedding_story";
						}
					},
					{
						text: 'Blog Post',
						action: function ( e, dt, node, config ) {
							window.location = "/saw-admin/add-article?cpt=post";
						}
					}
				]
			}
		]
	});

	vendorTable.on( 'draw', function () {
		dropdownButtons();
	});
	vendorTable.on( 'search.dt', function() {
		dropdownButtons();
	});
	articleTable.on( 'draw', function() {
		dropdownButtons();
	});
	articleTable.on( 'search.dt', function() {
		dropdownButtons();
	});
	categoryTable.on( 'draw', function() {
		dropdownButtons();
	});
	categoryTable.on( 'search.dt', function() {
		dropdownButtons();
	});

	dropdownButtons();
	function dropdownButtons() {
		$(".vmenu-button").on('click', function(event) {
			$(this).parent().toggleClass("visible");

		});
		$(document).on('click',  function(event) {
			$target = $(event.target);
			if(!$target.closest('.vmenu-container').length && $('.vmenu-container').hasClass('visible')) {
				$(".visible").removeClass('visible');
			}
		});
	}

	/******************* DEACTIVATE BUTTON *************************/
	$(document).on('click', '.deactivate-post', function () {
		let data = {
			'action': 'deactivate_post',
			'article_id': $(this).attr('id'),
		}

		$.post(fnajax.ajax_url, data, function (response) {
			// do something once the post has been deactivated!
			// maybe redraw the tables?
			if(response.post_type == 'vendor_profile') {
				alert("Vendor Profile Deactivated!");
				vendorTable.draw();
			} else if (response.post_type == 'post' || response.post_type == 'styled_shoot' || response.post_type == 'spotlight' || response.post_type == 'wedding_story') {
				alert("Article Deactivated!");
				articleTable.draw();
			} else if (response.post_type == 'category') {
				alert("Category Deactivated!");
				categoryTable.draw();
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
			if(response.post_type == 'vendor_profile') {
				alert("Vendor Profile Activated!");
				vendorTable.draw();
			} else if (response.post_type == 'post' || response.post_type == 'styled_shoot' || response.post_type == 'spotlight' || response.post_type == 'wedding_story') {
				alert("Article Activated!");
				articleTable.draw();
			} else if (response.post_type == 'category') {
				alert("Category Activated!");
				categoryTable.draw();
			}
		});
	});


	// navBar.stickybits();


	// class to give display: block; --> header-search-dropdown
	// jQuery("#sidebar").stickybits();

	// Format callable phone number
	// jQuery('.vendor-phone-call-text').text(function(i, text) {
	//     $phone_formatted = text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	//     return '<a href="tel:' + $phone_formatted + '">' + $phone_formatted + '</a>';
	// });
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