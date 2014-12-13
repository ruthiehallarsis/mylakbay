<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

?>
  <script type="text/javascript" src="<?php print $GLOBALS['base_url'] . '/' . path_to_theme(); ?>/js/heremaps/hereAppIdAndToken.js"></script>
  <script type="text/javascript" src="<?php print $GLOBALS['base_url'] . '/' . path_to_theme(); ?>/js/heremaps/jQl.min.js"></script>
  <script type="text/javascript" src="<?php print $GLOBALS['base_url'] . '/' . path_to_theme(); ?>/js/heremaps/hereAsyncLoader.js"
    id="HereMapsLoaderScript"
    data-map-container="mapContainer"
    data-params="maps,directions,places"
    data-callback="afterHereMapLoad"
    data-libs="directions-renderer"
    >
  </script>
  <link href="<?php print $GLOBALS['base_url'] . '/' . path_to_theme(); ?>/css/routing.css" rel="stylesheet"/>

<div class="main-container container">
  <div id="mapContainer" style="width:540px; height:334px;float:left;" class="no-expand"></div>
  <div id="left-side">
    <div style="width:500px; padding: 1em;">
      <a class="anchor" name="Customized suggestion list"></a>
      <div id="fromSearchBox" class="main-search">
        <span class ="caption">Start location:</span>
        <div module="SearchBox">
          <input rel="searchbox-input" id="start_location" class="search-box-bckgrnd" type="text" placeholder="STARTING PLACE"/>
          <div rel="searchbox-list" class="search-list"></div>
        </div>
      </div>
      <div id="toSearchBox" class="main-search">
        <span class ="caption">End location:</span>
        <div module="SearchBox">
          <input rel="searchbox-input" id="end_location" class="search-box-bckgrnd" type="text" placeholder="DESTINATION"/>
          <div rel="searchbox-list" class="search-list"></div>
        </div>
      </div>
      <input type="button" id="findRoute" value="Find Route" />
      <input type="button" id="modal-trigger" value="See Results" />
      <input type="button" id="pop-trigger" value="open" />
      </br/>
    </div>
    <div id="directions" style="float:left; color: rgb(102, 102, 102);height:334px;overflow:auto;width:500px; max-width: 500px;"></div>
  </div>
</div>

<div class="bs-example">
  <div id="myModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Your Lakbay!</h4>
        </div>
        <div class="modal-body">
          <p><span id="mod-start"></span> to <span id="mod-end"></span></p> <br/>
          <p>Car</p><br/>
          <p><span id="mod-car-text"></span></p><br/><br/>
          <p>Walk</p><br/>
          <p><span id="mod-pedestrian-text"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="pop-wrapper">
  <div class="inner">
    <div class="pop-top">
      <h2 class="long-distance">This trip wouldn't take long.<br>Have a safe trip, Lovey!</h2>
    </div>
    <div class="pop-body">
      <div class="dist-places">
        <h1><span id="mod-start"></span> to <span id="mod-end"></span></h1>
      </div>
      <div class="tabs">
        <ul class="tab-links">
          <li class="active"><a href="#tab1">RIDE YOUR CAR?</a></li>
          <li><a href="#tab2">GONNA WALK?</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab1" class="tab active">
            <span id="mod-car-text"></span>
          </div>
          <div id="tab2" class="tab">
            <span id="mod-pedestrian-text"></span>
          </div>
        </div>
      </div>
      <span id="nearby">
        <ul>
            <li><?php echo l('Restaurant', 'restaurant', array('attributes' => array('id' => 'restaurant_nearby', 'target' => '_blank'))); ?></li>
            <li><?php echo l('Malls', 'malls', array('attributes' => array('id' => 'restaurant_malls', 'target' => '_blank'))); ?></li>
        </ul>
      </span>
      <span id="map_helper">
        <ul>
            <li><?php echo l('Map Helper', 'helper', array('attributes' => array('id' => 'map_helper', 'target' => '_blank'))); ?></li>
        </ul>
      </span>
    </div>
    <div class="pop-footer">
      <a class="close-button">CLOSE</a>
    </div>
  </div>
</div>

<script  id="example-code" data-categories="routing,library" type="text/javascript" >
//<![CDATA[
var map,
  startPoint,
  endPoint,
  router,
  directionsRenderer;

function onRouteCalculated(observedRouter, key, value) {
  if (value === 'finished') {
    var routes = observedRouter.getRoutes(),
      //create the default map representation of a route
      mapRoute =
        new nokia.maps.routing.component.RouteResultSet(
          routes[0]
        ).container; //first option found
    map.objects.add(mapRoute);
    directionsRenderer.set('route', routes[0]);

    //Zoom to the bounding box of the route
    map.zoomTo(mapRoute.getBoundingBox(), false, 'default');
  } else if (value === 'failed') {
    alert('The routing request failed.');
  }
}

function makeRouteRequest(startPoint, endPoint) {
  var waypoints = new nokia.maps.routing.WaypointParameterList(),
    modes = [{
      type: 'shortest',
      transportModes: ['car'],
      options: 'avoidTollroad',
      trafficMode: 'default'
    }];

  waypoints.addCoordinate(startPoint);
  waypoints.addCoordinate(endPoint);

  router = new nokia.maps.routing.Manager();
  router.addObserver('state', onRouteCalculated);
  router.calculateRoute(waypoints, modes);
}

function setUpSuggestionBoxes() {
  var fromSearchBox = new nokia.places.widgets.SearchBox({
    targetNode: 'fromSearchBox',
    template: 'fromSearchBox',
    map: map,
    onResults: function (data) {
      // The argument data, which is an instance of nokia.places.objectsSearchResponseView
      // contains the search results
      startPoint = data.results.items[0].position;
    }
  }),
    toSearchBox = new nokia.places.widgets.SearchBox({
      targetNode: 'toSearchBox',
      template: 'toSearchBox',
      map: map,
      onResults: function (data) {
        // The argument data, which is an instance of nokia.places.objectsSearchResponseView
        // contains the search results
        endPoint = data.results.items[0].position;
      }
    });
  $('#findRoute').click(function () {
    makeRouteRequest(startPoint, endPoint);
  });
}

function addDirectionsRenderer(map) {
   directionsRenderer = new DirectionsRenderer(document.getElementById('directions'));
   map.addComponent(directionsRenderer);

}

function afterHereMapLoad(theMap) {
  map = theMap;
  infoBubbles = new nokia.maps.map.component.InfoBubbles();
  infoBubbles.options.defaultWidth = 200;
  infoBubbles.options.width = 200;
  map.addComponent(infoBubbles);
  addDirectionsRenderer(map);
  setUpSuggestionBoxes();
}
//]]>
</script>


