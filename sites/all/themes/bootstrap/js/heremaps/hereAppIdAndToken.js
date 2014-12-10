// This file holds all the constants used in the Demos.
(function (exports, ctx) {
  exports.HereMapsConstants = {
    AppIdAndToken :{
      appId: '8V5UOidiiKWZdcJUDoxN',
      appCode: 'fKFlIG27I5xkDkLNvxX4mA',
      language: 'en-US',
      serviceMode: 'cit'
    },
    // Initial center and zoom level of the map
    InitialLocation : {
      longitude: 14.5833,
      latitude:  121.0333,
      zoomLevel: 12},

    JSLibs  :{
      // versioned URL to load the HERE maps API.
      // Check on:  http://developer.here.com/versions
      // to obtain the latest version.
      HereMapsUrl :'http://js.cit.api.here.com/se/2.5.4/jsl.js?blank=true',
      HereMapsEnterpriseUrl :'https://js.cit.api.here.com/ee/2.5.4/jsl.js?blank=true',
      // versioned URL to load jQuery
      jQueryUrl : 'http://code.jquery.com/jquery-1.10.1.min.js',
      jQueryUIUrl: 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'
    },
    NS : 'nokia'

  }
})(window, document);