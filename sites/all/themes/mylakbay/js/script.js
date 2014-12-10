(function ($) {
  $(document).ready(function() {
    $('.page-mylakbay .main-container.container').append('<div id="left-side"></div>');
    $('.page-mylakbay .main-container.container div').first().appendTo('.page-mylakbay #left-side');
    $(".page-mylakbay #directions").appendTo('.page-mylakbay #left-side');
    $('#fromSearchBox input').attr('placeholder', 'STARTING PLACE');
    $('#toSearchBox input').attr('placeholder', 'DESTINATION');
  });
}(jQuery));