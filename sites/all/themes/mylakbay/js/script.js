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

            var car_distance =  parseFloat(obj.car_route_distance);
            var car_travel =  parseFloat(obj.car_route_travel_time);
            var pedestrian_distance =  parseFloat(obj.pedestrian_route_distance);
            var pedestrian_travel =  parseFloat(obj.pedestrian_route_travel_time);

            var pedestrian_average_time_week =  ((pedestrian_travel * 7) / 60 ) / 60;
            var pedestrian_average_time_year =  ((pedestrian_travel * 365) / 60 ) / 60;

            var car_average_time_week =  ((car_travel * 7) / 60 ) / 60;
            var car_average_time_year =  ((car_travel * 365) / 60 ) / 60;

            var header_text_walk = '';
            var header_car_walk = '';
            var car_class = '';
            var walk_class = '';

            if (pedestrian_distance >= 10000) {
              header_text_walk = 'Whoaa! This is a very long walk! Please make sure to have enough water for this!.';
              walk_class = 'w_verylong';
            } else if ( pedestrian_distance >= 5000 && pedestrian_distance <= 9999) {
              header_text_walk = 'This walk isn\'t that long enough! but its better to have someone with you.';
              walk_class = 'w_notsolong';
            } else {
              header_text_walk = 'This should be short walk! but beware of snatchers!';
              walk_class = 'w_short';
            }

            if (car_distance >= 30000) {
              header_car_walk = 'This ride is very long! its better to have enough foods with you!';
              car_class = 'c_verylong';
            } else if (car_distance >= 15000 && pedestrian_distance <= 29999) {
              header_car_walk = 'This ride shouldn\'t be that long enough! Take care, lovey!';
              car_class = 'c_notsolong';
            } else {
              header_car_walk = 'This should be a very short ride for you, babe!';
              car_class = 'c_short';
            }

            $('#tab1 h2').html(header_car_walk);
            $('#tab1 h2').removeClass();
            $('#tab1 h2').addClass(car_class);

            $('#tab2 h2').html(header_text_walk);
            $('#tab2 h2').removeClass();
            $('#tab2 h2').addClass(walk_class);

            $('#walk_average_time_week').html(pedestrian_average_time_week.toFixed(2));
            $('#walk_average_time_year').html(pedestrian_average_time_year.toFixed(2));

            $('#car_average_time_week').html(car_average_time_week.toFixed(2));
            $('#car_average_time_year').html(car_average_time_year.toFixed(2));

            $(".pop-wrapper #mod-start").html(obj.start_loc);
            $(".pop-wrapper #mod-end").html(obj.end_loc);
            $(".pop-wrapper #mod-car-text").html(obj.car_text);
            $(".pop-wrapper #mod-pedestrian-text").html(obj.pedestrian_text);
            $("#restaurant_nearby").attr("href", Drupal.settings.basePath + "restaurant?waypoint=" + obj.waypoint1);
            $("#restaurant_malls").attr("href", Drupal.settings.basePath + "malls?waypoint=" + obj.waypoint1);
            $("#map_helper_link").attr("href", Drupal.settings.basePath + "helper?waypoint=" + obj.waypoint1 + "&location=" + obj.end_loc);

            $('.pop-wrapper').show();           
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


    $('.close-button').click(function() {
      $('.pop-wrapper').hide();
    });

  });
}(jQuery));