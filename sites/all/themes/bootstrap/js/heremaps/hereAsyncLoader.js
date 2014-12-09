
(function (exports, ctx) {
  jQl.loadjQ(exports.HereMapsConstants.JSLibs.jQueryUrl, function () {
    var script = null,
      baseNS = null,
      mapsNS = null,
      map = null;

    // Iterate through the <SCRIPT> Tags to find the loader
    // Then use the element to obtain additional constants
    // such as the name of the DOM element that displays the
    // map
    jQuery(ctx.getElementsByTagName('script')).each(function (index, value) {
      if (jQuery(this).attr('id') === 'HereMapsLoaderScript') {
        script = jQuery(this);
        return false;
      }
      return true;
    });

    // This method is a convenience function that intialises a map for the
    // Given DOM element and at the specified location.

    function createMap(location, domElement) {
      return new mapsNS.Display(domElement, {
        center: [location.longitude, location.latitude],
        zoomLevel: location.zoomLevel, // Bigger numbers are closer in
        components: [  // We use these components to make the map interactive
          new mapsNS.component.ZoomBar(),
          new mapsNS.component.Behavior()
        ]
      });
    }

    // This method is a convenience function that intialises the Settings
    // to authenticate the app with the HERE Maps JS library.
    function authenticate(settings) {
      baseNS.Settings.set('app_id', settings.appId);
      baseNS.Settings.set('app_code', settings.appCode);
      if (settings.language) {
        baseNS.Settings.set('defaultLanguage', settings.language);
      }
      if (settings.serviceMode) {
        baseNS.Settings.set('serviceMode', settings.serviceMode);
      }
    }

    // This method is called once the base JS library has loaded, it
    // initialises the requested features, authenticates the app to
    // the library, and sets up an appropriately located  map in
    // the specified DOM element.
    function hereMapLoaderCallback() {
      // Set the mapsNS for further use
      baseNS = exports[exports.HereMapsConstants.NS];

      var params = 'maps',
        fmatrix,
        // This callback is run if the feature load was successful.
        onApiFeaturesLoaded = function (error) {
          mapsNS = baseNS.maps.map;
          authenticate(exports.HereMapsConstants.AppIdAndToken);
          var libsArray = jQuery(script).data('libs'),
            libs,
            callbackKey;

          if (libsArray !== undefined) {
            jQuery.ajaxSetup({async: false});
            libs = libsArray.split(',');
            jQuery.each(libs, function (index, value) {
              jQuery.getScript(Drupal.settings.basePath + 'sites/all/themes/bootstrap/js/heremaps/' + value + '.js');
            });
            jQuery.ajaxSetup({async: true});
          }


          if (map === null) {
            callbackKey = jQuery(script).data('callback');
            if (jQuery(script).data('map-container') !== undefined) {
              map = createMap(exports.HereMapsConstants.InitialLocation,
                ctx.getElementById(jQuery(script).data('map-container')));
              map.addListener('displayready', function () {
                exports[callbackKey](map);
              }, false);
            } else {
              exports[callbackKey](null);
            }
          }
        },
        // This callback is run if an error occurs during the feature loading
        onApiFeaturesError = function (error) {
          alert('Whoops! ' + error);
        };

      if (jQuery(script).data('params') !== undefined) {
        params = jQuery(script).data('params');
      }
      fmatrix = baseNS.Features.getFeaturesFromMatrix(params.split(','));

      baseNS.Features.load(
        fmatrix,
        onApiFeaturesLoaded, // an callback when everything was successfully loaded
        onApiFeaturesError, // an error callback
        null,  // Indicates that the current document applies
        false  //Indicates that loading should be asynchronous
      );
    }

    if (jQuery(script).data('enterprise-only')){
       jQuery.getScript(exports.HereMapsConstants.JSLibs.HereMapsEnterpriseUrl, hereMapLoaderCallback);
    } else {
      jQuery.getScript(exports.HereMapsConstants.JSLibs.HereMapsUrl, hereMapLoaderCallback);
    }
  });

})(window, document);