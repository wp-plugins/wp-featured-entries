jQuery(document).ready(function() {
	jQuery("#jft_p_i-1").addClass("current-ft-pg");
	jQuery(".jft_post:first-child").addClass("current-ft");
	jQuery(".jft_post:first-child").css("display", "block");
	
	var interval = setInterval(nextSlide, 8000);
	
	jQuery(".jft_pag a").click(function(event) {
		clearInterval(interval);
		interval = setInterval(nextSlide, 8000);
		var ref = jQuery(this).attr("data-ref");
		
		jQuery(".current-ft-pg").removeClass("current-ft-pg");
		jQuery("#jft_p_i-"+ref).addClass("current-ft-pg");
		
		jQuery(".current-ft").removeClass("current-ft");
		jQuery("#jft_post-"+ref).addClass("current-ft");
		
		jQuery(".jft_post").hide("slide");
		jQuery("#jft_post-"+ref).show("slide");
		
		event.preventDefault();
	});
});
function nextSlide() {
	var next = jQuery(".current-ft").next(".jft_post").attr("data-id");
	
	if (next != undefined) {
		jQuery(".current-ft-pg").removeClass("current-ft-pg");
		jQuery("#jft_p_i-"+next).addClass("current-ft-pg");
		
		jQuery(".current-ft").removeClass("current-ft");
		jQuery("#jft_post-"+next).addClass("current-ft");
		
		jQuery(".jft_post").hide("slide");
		jQuery(".jft_post").next("#jft_post-"+next).show("slide");
		
	}
	else {
		jQuery(".current-ft-pg").removeClass("current-ft-pg");
		jQuery("#jft_p_i-1").addClass("current-ft-pg");
		
		jQuery(".current-ft").removeClass("current-ft");
		jQuery("#jft_post-1").addClass("current-ft");
		
		jQuery(".jft_post").hide("slide");
		jQuery("#jft_post-1").show("slide");
		
	}
}