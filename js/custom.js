/**
 * 
 */
$(document).ready(function(){
	$( "#datepicker" ).datepicker({
		dateFormat:"dd/mm/yy",
	});
});

/*jQuery(function($) {
  function fixDiv() {
    var $cache = $('#search-information');
    if ($(window).scrollTop() > 100)
      $cache.css({
        'position': 'fixed',
        'top': '10px'
      });
    else
      $cache.css({
        'position': 'relative',
        'top': 'auto'
      });
  }
  $(window).scroll(fixDiv);
  fixDiv();
});*/

/*var tableOffset = $("#table_header_fixed").offset().top;
var $header = $("#table_header_fixed > thead").clone();
var $fixedHeader = $("#header-fixed").append($header);

$(window).bind("scroll", function() {
    var offset = $(this).scrollTop();
    
    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        $fixedHeader.show();
    }
    else if (offset < tableOffset) {
        $fixedHeader.hide();
    }
});*/