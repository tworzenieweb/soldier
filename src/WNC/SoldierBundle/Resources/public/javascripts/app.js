(function($){  
//    $(document).foundationMediaQueryViewer();
//    
//    $(document).foundationAlerts();
//    $(document).foundationAccordion();
//    $(document).tooltips();
//    $('input, textarea').placeholder();
//    
//    
//    
//    $(document).foundationButtons();
//    
//    
//    
//    $(document).foundationNavigation();
//    
//    
//    
//    $(document).foundationCustomForms();
//    
//    
//    
//      
//      $(document).foundationTabs({callback:$.foundation.customForms.appendCustomMarkup});
//      
    
    
    
//    $("#featured").orbit();
    
    $('input.date').datepicker({
			showOn: "button",
			buttonText: '<span class="ui-icon ui-icon-calendar"></span>',
      dateFormat: 'mm-dd-yy'
		});
    
    $('.register_button').colorbox({
      height: '520px',
      width: '477px',
    });
    
    
    
    // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
    // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'left'});
    // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'left'});
    // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'left'});
    // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'left'});
  
})(jQuery);


(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=200123070080537";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


