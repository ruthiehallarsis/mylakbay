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

  });
}(jQuery));