$=jQuery,$(document).ready((function(){$(".vendor-login a").on("click",(function(){$("div.vendor-login-form").toggleClass("visible")})),$(".header-search a").on("click",(function(){$("div.header-search-dropdown").toggleClass("visible")})),$(".text-below-hero").html((function(){let t=".hero-text-content."+$(this).attr("id"),a="";if($(this).hasClass("style-1")){a+=$(t+" .head-2").wrap("<span/>").parent().html(),$(t+" .head-2").unwrap(),a+=$(t+" .subhead").wrap("<span/>").parent().html(),$(t+" .subhead").unwrap(),a+=$(t+" .read-more.saw-button").wrap("<span/>").parent().html(),$(t+" .read-more.saw-button").unwrap()}else if($(this).hasClass("style-2")){a+=$(t+" .head-1").wrap("<span/>").parent().html(),$(t+" .head-1").unwrap(),a+=$(t+" .read-more.saw-button").wrap("<span/>").parent().html(),$(t+" .read-more.saw-button").unwrap()}return a}));let t=$(".vendor-sticky-nav");$("body").on("scroll",(function(){window.scrollY;t.offsetTop<=54&&(t.css("position","fixed"),t.css("top","54px"),t.css("left","0"),t.css("z-index","99"))}));let a=$("#vendor_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=vendor_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Advertiser",action:function(t,a,e,n){window.location="/saw-admin/add-advertiser"}}]});a.on("draw",(function(){r()})),a.on("search.dt",(function(){r()}));let e=$("#category_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=category_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Category",action:function(t,a,e,n){window.location="/saw-admin/add-category"}}]});e.on("draw",(function(){r()})),e.on("search.dt",(function(){r()}));let n=$("#article_table").DataTable({ajax:datatablesajax,dom:"Bfrtip",processing:!0,serverSide:!0,buttons:[{extend:"collection",text:"New Article",buttons:[{text:"Spotlight",action:function(t,a,e,n){window.location="/saw-admin/add-article?cpt=spotlight"}},{text:"Styled Shoot",action:function(t,a,e,n){window.location="/saw-admin/add-article?cpt=styled_shoot"}},{text:"Wedding Story",action:function(t,a,e,n){window.location="/saw-admin/add-article?cpt=wedding_story"}},{text:"Blog Post",action:function(t,a,e,n){window.location="/saw-admin/add-article?cpt=post"}}]}]});n.on("draw",(function(){r()})),n.on("search.dt",(function(){r()}));let o=$("#home_slider_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=homeslide_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Home Slider",action:function(t,a,e,n){window.location="/saw-admin/add-home-slider"}}]});o.on("draw",(function(){r()})),o.on("search.dt",(function(){r()}));let i=$("#banner_ad_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=banner_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Banner Ad",action:function(t,a,e,n){window.location="/saw-admin/add-banner-ad"}}]});i.on("draw",(function(){r()})),i.on("search.dt",(function(){r()}));let s=$("#special_offer_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=special_offer_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Special Offer",action:function(t,a,e,n){window.location="/saw-admin/add-special-offer"}}]});function r(){$(".vmenu-button").on("click",(function(t){$(this).parent().toggleClass("visible")})),$(document).on("click",(function(t){$target=$(t.target),!$target.closest(".vmenu-container").length&&$(".vmenu-container").hasClass("visible")&&$(".visible").removeClass("visible")}))}s.on("draw",(function(){r()})),s.on("search.dt",(function(){r()})),r(),$(document).on("click",".deactivate-post",(function(){let t={action:"deactivate_post",article_id:$(this).attr("id")};$.post(fnajax.ajax_url,t,(function(t){"vendor_profile"==t.post_type?(alert("Vendor Profile Deactivated!"),a.draw("page")):"post"==t.post_type||"styled_shoot"==t.post_type||"spotlight"==t.post_type||"wedding_story"==t.post_type?(alert("Article Deactivated!"),n.draw("page")):"category"==t.post_type?(alert("Category Deactivated!"),e.draw("page")):"home_slide"==t.post_type?(alert("Home Slider Deactivated!"),o.draw("page")):"banner"==t.post_type?(alert("Banner Ad Deactivated!"),i.draw("page")):"special_offers"==t.post_type&&(alert("Special Offer Deactivated!"),s.draw("page"))}))})),$(document).on("click",".activate-post",(function(){let t={action:"activate_post",article_id:$(this).attr("id")};$.post(fnajax.ajax_url,t,(function(t){"vendor_profile"==t.post_type?(alert("Vendor Profile Activated!"),a.draw("page")):"post"==t.post_type||"styled_shoot"==t.post_type||"spotlight"==t.post_type||"wedding_story"==t.post_type?(alert("Article Activated!"),n.draw("page")):"category"==t.post_type?(alert("Category Activated!"),e.draw("page")):"home_slide"==t.post_type?(alert("Home Slider Activated!"),o.draw("page")):"banner"==t.post_type?(alert("Banner Ad Activated!"),i.draw("page")):"special_offers"==t.post_type&&(alert("Special Offer Activated!"),s.draw("page"))}))})),$(".spotlight-widget-container .individual-spotlight").on("click",(function(){window.location=$(this).find("a").attr("href")})),$(".admin-save-button").parent().css("z-index","11").on("click",(function(){$('input[type="submit"].acf-button.button-primary').click()}));var d,c=$("body");(c.hasClass("single-wedding_story")||c.hasClass("single-spotlight")||c.hasClass("single-post")||c.hasClass("single-styled_shoot"))&&(d=$(".wedding-story-blog-square .et_pb_image_container"),$images=d.find("img"),$images.each((function(t,a){$src=$(a).attr("src"),$(a).attr("src",$src.replace("-400x250",""))}))),$("a.hamburger-click").on("click",(function(t){$("div.vendor-list-container").toggleClass("visible"),t.preventDefault()})),$("#footer-stay-connected .red-container").on("click",(function(t){$("div.pop-up-social").toggleClass("visible"),t.preventDefault()})),$("#sidebar").stickybits(),$(".spotlight-vendor-info-container .vendor-phone-number span a").text((function(t,a){return a.replace(/(\d{3})(\d{3})(\d{4})/,"$1-$2-$3")}))}));