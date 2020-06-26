jQuery(document).ready(function () {

	jQuery(".vendor-login a").click(function () {
		console.log("just clicked vendor login");
		jQuery("div.vendor-login-form").toggleClass("visible");
	});
	jQuery(".header-search a").click(function () {
		console.log("just clicked search button");
		jQuery("div.header-search-dropdown").toggleClass("visible");
	});

	// Change the nav bar to fixed position after a certain amount of scroll
	let navBar = jQuery(".vendor-sticky-nav");
	jQuery("body").scroll(function () {
		let fromTop = window.scrollY;
		// 54px - once the nav bar is 54px from the top, make it fixed
		if (navBar.offsetTop <= 54) {
			navBar.css("position", "fixed");
			navBar.css("top", "54px");
			navBar.css("left", "0");
			navBar.css("z-index", "99");
		}
	});

	var vendorTable = jQuery("#vendor_table").DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				text: 'New Advertiser',
				action: function ( e, dt, node, config ) {
					window.location = "/saw-admin/add-advertiser";
				}
			}
		]
	});
	var categoryTable = jQuery("#category_table").DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				text: 'New Category',
				action: function ( e, dt, node, config ) {
					window.location = "/saw-admin/add-category";
				}
			}
		]
	});
	var articleTable = jQuery("#article_table").DataTable({
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
							window.location = "/saw-admin/add-article?cpt=blog";
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
		jQuery(".vmenu-button").click(function(event) {
			jQuery(this).parent().toggleClass("visible");

		});
		jQuery(document).click( function(event) {
			$target = jQuery(event.target);
			if(!$target.closest('.vmenu-container').length &&
				jQuery('.vmenu-container').hasClass('visible')) {
				jQuery(".visible").removeClass('visible');
			}
		});
	}

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