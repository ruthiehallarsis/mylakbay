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

$longlat = explode(",", $waypoint);
?>

      <script src="http://js.cit.api.here.com/se/2.5.4/jsl.js?with=places" type="text/javascript" charset="utf-8"></script>

  <a class="anchor" name="Category search and detailed results"></a>
  <h3>Category search and detailed results</h3>
  <div> 
    <p>
      In this example, you can perform a category search, then select a place from the list of results to
      view the full details. The detailed information includes contact details, a map, opening
      hours, photographs and a list of reviews with ratings.
    </p>
  
    <p>The body of the HTML page contains:</p>
  
    <p>
      <a name="topic-1__ul_f01ce817-cc06-4e29-a2d1-ddb4dd187282"></a>
    </p>
    <ul id="topic-1__ul_f01ce817-cc06-4e29-a2d1-ddb4dd187282">
      <li>the Category Search Widget</li>
      <li>a list element to display the results</li>
      <li>an element in which the details of the selected place are shown</li>
    </ul>
    <p>
      The implementation obtains a Places API category search object, by calling
      <code>nokia.places.widgets.CategoryBox()</code>, passing to it:
    </p>
    <p>
      <a name="topic-1__ul_7e33aa0a-9c52-4aa4-af1a-50044fe7e9f5"></a>
    </p>
    <ul id="topic-1__ul_7e33aa0a-9c52-4aa4-af1a-50044fe7e9f5">
      <li>the id of the HTML element that contains the visible category search widget</li>
      <li>a function that provides the location of the search center</li>
    </ul>
    <p>
      <code>nokia.places.widgets.Place</code> is instantiated with the id of the HTML element
      which is to display the details of the place chosen by the user from the search results.
    </p>
    <p>
      For the search result, an instance of <code>nokia.places.widgets.ResultList</code> is created with
      the following parameters:
    </p>
    <p>
      <a name="topic-1__ul_8f6fe771-c290-419f-9ae9-0baf55df36d9"></a>
    </p>
    <ul id="topic-1__ul_8f6fe771-c290-419f-9ae9-0baf55df36d9">
      <li>the id of the HTML to display the results</li>
      <li>a list of event specifiers, whose place name element provides an event handler for a click
        on a list item; the handler causes the <code>PlacesPlayer</code> object to fetch  the details for the
        selected place
      </li>
    </ul>
  </div>

  <table cellspacing="2">
    <tr>
      <td valign="top">
        <div id="csSearch"></div>
        <div id="csResultList"></div>
      </td>
      <td valign="top">
        <div id="csPlaceWidget"></div>
      </td>
    </tr>
  </table>

<?php
  $jq = 'jQuery(document).ready(function(){

  nokia.Settings.set("app_id", "DemoAppId01082013GAL"); 
  nokia.Settings.set("app_code", "AJKnXv84fjrb0KIHawS0Tg");
  // Use staging environment (remove the line for production environment)
  nokia.Settings.set("serviceMode", "cit");
      
      var csPlaceWidget = new nokia.places.widgets.Place({
        targetNode: "csPlaceWidget",
        template: "nokia.general.place"
      });
    
      
      var csResultList = new nokia.places.widgets.ResultList({
        targetNode: "csResultList",
        events:[{
          rel: "nokia-place-name",
          name: "click",
          handler: function (data) {
            csPlaceWidget.setPlace({href:data.href});
          } 
        }]
      });
      
      var csSearchBox = new nokia.places.widgets.CategorySearch({
        targetNode: "csSearch",
        searchCenter: function () {
          return {
            latitude: '.$longlat[0].',
            longitude: '.$longlat[1].'
          };
        },
        onResults: function (data) {
          // Use place list to render results
          csResultList.setData(data);
        }
      });
    })';

  drupal_add_js($jq, array('type' => 'inline', 'scope' => 'footer'));

?>