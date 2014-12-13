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
$waypoint = $_GET['waypoint'];
?>

    <link rel="stylesheet" type="text/css" href="http://apidocs-legacy-documentations3bucket.s3-website-eu-west-1.amazonaws.com/apiexplorer/examples/templates/js/exampleHelpers.css"/>
    <!-- By default we add ?with=all to load every package available,
      it's better to change this parameter to your use case. 
      Options ?with=maps|positioning|places|placesdata|directions|datarendering|all -->
    <script type="text/javascript" charset="UTF-8" src="http://js.cit.api.here.com/se/2.5.4/jsl.js?with=all"></script>
    <!-- JavaScript for example container (NoteContainer & Logger)  -->
    <script type="text/javascript" charset="UTF-8" src="http://apidocs-legacy-documentations3bucket.s3-website-eu-west-1.amazonaws.com/apiexplorer/examples/templates/js/exampleHelpers.js"></script>
    <style type="text/css">
      html {
        overflow:hidden;
      }
      
      body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        width: 100%;
        height: 100%;
        position: absolute;
      }
      
      #mapContainer {
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        position: absolute;
      }
    </style>

    <div id="mapContainer"></div>
    <div id="uiContainer"></div>

<?php
  $jq = 'jQuery(document).ready(function(){

nokia.Settings.set("app_id", "DemoAppId01082013GAL"); 
nokia.Settings.set("app_code", "AJKnXv84fjrb0KIHawS0Tg");
// Use staging environment (remove the line for production environment)
nokia.Settings.set("serviceMode", "cit");


// Get the DOM node to which we will append the map
var mapContainer = document.getElementById("mapContainer");
// Create a map inside the map container DOM node
var map = new nokia.maps.map.Display(mapContainer, {
  // Initial center and zoom level of the map
  center: ['.$waypoint.'],
  zoomLevel: 14,
  components: [   
    new nokia.maps.map.component.Behavior()
  ]
});

var searchCenter = new nokia.maps.geo.Coordinate('.$waypoint.'),
  searchManager = nokia.places.search.manager,
  resultSet;

// Function for receiving search results from places search and process them
var processResults = function (data, requestStatus, requestId) {
  var i, len, locations, marker;
  
  if (requestStatus == "OK") {
    // The function findPlaces() and reverseGeoCode() of  return results in slightly different formats
    locations = data.results ? data.results.items : [data.location];
    // We check that at least one location has been found
    if (locations.length > 0) {
      // Remove results from previous search from the map
      if (resultSet) map.objects.remove(resultSet);
      // Convert all found locations into a set of markers
      resultSet = new nokia.maps.map.Container();
      for (i = 0, len = locations.length; i < len; i++) {
        marker = new nokia.maps.map.StandardMarker(locations[i].position, { text: i+1 });
        resultSet.objects.add(marker);
      }

      map.objects.add(resultSet);

      map.zoomTo(resultSet.getBoundingBox(), false);
    } else { 
      alert("Your search produced no results!");
    }
  } else {
    alert("The search request failed");
  }
};

var noteContainer = new NoteContainer({
  id: "searchUi",
  parent: document.getElementById("uiContainer"),
  title: "Search Manager",
  content:
    "Results for malls <small id=progress></small>" 
});

var progressUiElt = document.getElementById("progress");

var category = "shopping";
progressUiElt.innerHTML = "";

map.addListener("displayready", function () {
  searchManager.findPlacesByCategory({
    category: category,
    onComplete: processResults,
    searchCenter: searchCenter
  });
});

  })';

  drupal_add_js($jq, array('type' => 'inline', 'scope' => 'footer'));

?>