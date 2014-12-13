(function ($) {
  $(document).ready(function() {
    $('#modal-trigger').click(function(e){
      e.preventDefault();
      var start = $("#start_location").val();
      var end = $("#end_location").val();
      var data = { start : start, end : end };

        $.ajax({
          type: "GET",
          url: Drupal.settings.basePath + "show-result",
          data: data,
          success: function(response) {
            var obj = $.parseJSON(response);
            if(obj.res_status == "success") {
              var car_distance =  obj.car_route_distance;
              var car_travel =  obj.car_route_travel_time;
              var pedestrian_distance =  obj.pedestrian_route_distance;
              var pedestrian_travel =  obj.pedestrian_route_travel_time;

              $("#mod-start").html(obj.start_loc);
              $("#mod-end").html(obj.end_loc);
              $("#mod-car-text").html(obj.car_text);
              $("#mod-pedestrian-text").html(obj.pedestrian_text);
              $("#myModal").modal('show');              
            }
            else {
              alert("Routing failed!");
            }

          }
        });
    });

    $('.tabs .tab-links a').on('click', function(e)  {
      var currentAttrValue = $(this).attr('href');
      $('.tabs ' + currentAttrValue).show().siblings().hide();
      $(this).parent('li').addClass('active').siblings().removeClass('active');
      e.preventDefault();
    });

    $('#pop-trigger').click(function(e) {

      e.preventDefault();
      var start = $("#start_location").val();
      var end = $("#end_location").val();
      var data = { start : start, end : end };

      $.ajax({
        type: "GET",
        url: Drupal.settings.basePath + "show-result",
        data: data,
        success: function(response) {
          var obj = $.parseJSON(response);
          if(obj.res_status == "success") {
            $(".pop-wrapper #mod-start").html(obj.start_loc);
            $(".pop-wrapper #mod-end").html(obj.end_loc);
            $(".pop-wrapper #mod-car-text").html(obj.car_text);
            $(".pop-wrapper #mod-pedestrian-text").html(obj.pedestrian_text);
            $("#restaurant_nearby").attr("href", Drupal.settings.basePath + "restaurant?waypoint=" + obj.waypoint1);

            $('.pop-wrapper').show();              
          }
          else {
            alert("Routing failed!");
          }

        }
      });


      
    });

    $('.close-button').click(function() {
      $('.pop-wrapper').hide();
    });

  });
}(jQuery));