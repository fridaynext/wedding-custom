$=jQuery,$(document).ready((function(){$(".vendor-login a").on("click",(function(){$("div.vendor-login-form").toggleClass("visible")})),$(".header-search a").on("click",(function(){$("div.header-search-dropdown").toggleClass("visible")})),$(".text-below-hero").html((function(){let t=".hero-text-content."+$(this).attr("id"),a="";if($(this).hasClass("style-1")){a+=$(t+" .head-2").wrap("<span/>").parent().html(),$(t+" .head-2").unwrap(),a+=$(t+" .subhead").wrap("<span/>").parent().html(),$(t+" .subhead").unwrap(),a+=$(t+" .read-more.saw-button").wrap("<span/>").parent().html(),$(t+" .read-more.saw-button").unwrap()}else if($(this).hasClass("style-2")){a+=$(t+" .head-1").wrap("<span/>").parent().html(),$(t+" .head-1").unwrap(),a+=$(t+" .read-more.saw-button").wrap("<span/>").parent().html(),$(t+" .read-more.saw-button").unwrap()}return a}));let t=$(".vendor-sticky-nav");$("body").on("scroll",(function(){window.scrollY;t.offsetTop<=54&&(t.css("position","fixed"),t.css("top","54px"),t.css("left","0"),t.css("z-index","99"))}));let a=$("#vendor_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=vendor_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Advertiser",action:function(t,a,e,o){window.location="/saw-admin/add-advertiser"}}]});a.on("draw",(function(){i()})),a.on("search.dt",(function(){i()}));let e=$("#category_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=category_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Category",action:function(t,a,e,o){window.location="/saw-admin/add-category"}}]});e.on("draw",(function(){i()})),e.on("search.dt",(function(){i()}));let o=$("#article_table").DataTable({ajax:datatablesajax,dom:"Bfrtip",processing:!0,serverSide:!0,buttons:[{extend:"collection",text:"New Article",buttons:[{text:"Spotlight",action:function(t,a,e,o){window.location="/saw-admin/add-article?cpt=spotlight"}},{text:"Styled Shoot",action:function(t,a,e,o){window.location="/saw-admin/add-article?cpt=styled_shoot"}},{text:"Wedding Story",action:function(t,a,e,o){window.location="/saw-admin/add-article?cpt=wedding_story"}},{text:"Blog Post",action:function(t,a,e,o){window.location="/saw-admin/add-article?cpt=post"}}]}]});o.on("draw",(function(){i()})),o.on("search.dt",(function(){i()}));let n=$("#home_slider_table").DataTable({dom:"Bfrtip",ajax:{url:"/wp-admin/admin-ajax.php?action=homeslide_datatables"},processing:!0,serverSide:!0,buttons:[{text:"New Home Slider",action:function(t,a,e,o){window.location="/saw-admin/add-home-slider"}}]});function i(){$(".vmenu-button").on("click",(function(t){$(this).parent().toggleClass("visible")})),$(document).on("click",(function(t){$target=$(t.target),!$target.closest(".vmenu-container").length&&$(".vmenu-container").hasClass("visible")&&$(".visible").removeClass("visible")}))}n.on("draw",(function(){i()})),n.on("search.dt",(function(){i()})),i(),$(document).on("click",".deactivate-post",(function(){let t={action:"deactivate_post",article_id:$(this).attr("id")};$.post(fnajax.ajax_url,t,(function(t){"vendor_profile"==t.post_type?(alert("Vendor Profile Deactivated!"),a.draw()):"post"==t.post_type||"styled_shoot"==t.post_type||"spotlight"==t.post_type||"wedding_story"==t.post_type?(alert("Article Deactivated!"),o.draw()):"category"==t.post_type?(alert("Category Deactivated!"),e.draw()):"home_slide"==t.post_type&&(alert("Home Slider Deactivated!"),n.draw())}))})),$(document).on("click",".activate-post",(function(){let t={action:"activate_post",article_id:$(this).attr("id")};$.post(fnajax.ajax_url,t,(function(t){"vendor_profile"==t.post_type?(alert("Vendor Profile Activated!"),a.draw()):"post"==t.post_type||"styled_shoot"==t.post_type||"spotlight"==t.post_type||"wedding_story"==t.post_type?(alert("Article Activated!"),o.draw()):"category"==t.post_type?(alert("Category Activated!"),e.draw()):"home_slide"==t.post_type&&(alert("Home Slider Activated!"),n.draw())}))})),$(".spotlight-widget-container .individual-spotlight").on("click",(function(){window.location=$(this).find("a").attr("href")})),$(".admin-save-button").parent().css("z-index","11").on("click",(function(){$('input[type="submit"].acf-button.button-primary').click()}))}));