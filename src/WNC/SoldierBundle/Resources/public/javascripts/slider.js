(function($) {
      var slider = $(".slider-tabs").jtTabs(".images > div", {

      // enable "cross-fading" effect
      effect: 'fade',
      fadeOutSpeed: "slow",

      // start from the beginning after the last tab
      rotate: true

      // use the slideshow plugin. It accepts its own configuration
      }).slideshow({
        autoplay:true,
        clickable: false,
        interval: 10000
      });
      
      // get handle to the api (must have been constructed before this call)
       var single = 164;
       var api = slider.data("tabs");
       var total = api.getPanes().length;
       var min = 5 * single;
       var current = total * single;
       var maxOffset = current - min;
       var prevIndex = 0;
      

      
       

      api.onClick(function(event, index) {
      
            var diff = index - prevIndex;
            
            var offset = (diff * single);
            
            if(Math.abs(offset) > maxOffset)
            {
                offset = offset >= 0 ? maxOffset : -maxOffset;
            }
            

            prevIndex = api.getIndex();


            var margin = offset > 0 ? "-=" : "+=";
            margin += Math.abs(offset) + "px";

            if(current - offset >= min) {
                slider.animate({
                    marginLeft: margin,
                }, 500 );
                current = current - offset;
                
            }
      
            
            
      });
      

      
  })(jQuery);
