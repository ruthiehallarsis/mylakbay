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

            var header_text_walk = '';
            var header_car_walk = '';
            var car_class = '';
            var walk_class = '';

            if (pedestrian_distance >= 10000) {
              header_text_walk = 'This is a very long walk!';
              walk_class = 'w_verylong';
            } else if ( pedestrian_distance >= 5000 && pedestrian_distance <= 9999) {
              header_text_walk = 'This is a not so long walk!';
              walk_class = 'w_notsolong';
            } else {
              header_text_walk = 'This is a short walk!';
              walk_class = 'w_short';
            }

            if (car_distance >= 20000) {
              header_car_walk = 'This is a very long car ride!';
              car_class = 'c_verylong';
            } else if (car_distance >= 10000 && pedestrian_distance <= 19999) {
              header_car_walk = 'This is a not so car ride!';
              car_class = 'c_notsolong';
            } else {
              header_car_walk = 'This is a car ride!';
              car_class = 'c_short';
            }

            $('#tab1 h2').html(header_car_walk);
            $('#tab1 h2').removeClass();
            $('#tab1 h2').addClass(car_class);

            $('#tab2 h2').html(header_text_walk);
            $('#tab2 h2').removeClass();
            $('#tab2 h2').addClass(walk_class);

            //alert(final_car_distance + 'km ' + car_travel +' and '+ pedestrian_distance +' '+ pedestrian_travel);

            $(".pop-wrapper #mod-start").html(obj.start_loc);
            $(".pop-wrapper #mod-end").html(obj.end_loc);
            $(".pop-wrapper #mod-car-text").html(obj.car_text);
            $(".pop-wrapper #mod-pedestrian-text").html(obj.pedestrian_text);

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