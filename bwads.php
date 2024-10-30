<?php
/*
Plugin Name: BrokersWeb Ads
Plugin URI: http://www.brokersweb.com/
Description: WordPress plugin to insert BrokersWeb iListings into posts and pages.
Author: BrokersWeb
Author URI: http://www.brokersweb.com/
Version: v2.2.1
*/

function BWadminHeader()
{
 $bwads_url = plugins_url();
 $bwads_url = $bwads_url . '/brokerswebads';
 print '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
 print '<link rel="stylesheet" type="text/css" media="all" href="' . $bwads_url . '/styles/bw-styles.css" />' . "\n";
 if (version_compare($wp_version, '2.7', '>=')) {
  print '<link rel="stylesheet" type="text/css" href="' . $bwads_url . '/styles/bw-styles-reset.css" />' . "\n";
 }
 print '<script type="text/javascript" src="' . $bwads_url . '/scripts/custom.js"></script>' . "\n";
}

add_action('admin_head', 'BWadminHeader', 1);
$wp_bw_ad_insert_version = "2.2.2";

function plugin_links($links, $file)
{
 if ($file == plugin_basename(__FILE__)) {
  $links[] = '<a target="_blank" style="color: #42a851; font-weight: bold;" href="mailto:cristopher@brokersweb.com">' . __("Get Support", "brokersweb-ads") . '</a>';
 }
 return $links;
}

add_filter('plugin_row_meta', 'plugin_links', 10, 2);

function plugin_actions($links, $file)
{
 if ($file == plugin_basename(__FILE__)) {
  $settings_link = '<a href="admin.php?page=brokerswebads">' . __("Settings", "brokersweb-ads") . '</a>';
  array_unshift($links, $settings_link);
 }
 return $links;
}

add_filter('plugin_action_links', 'plugin_actions', 10, 2);

function bwads_trigger()
{
 do_action('bwads_trigger');
}

//global $bwads_geoip, $bwads_stylesheet, $bwads_prodid, $bwads_state, $bwads_zip, $bwads_id, $bwads_cid, $bwads_maxads, $bwads_source, $bwads_chars, $bwdas_prodname, $bwads_stname, $bwads_zipname, $bwads_hf, $bwads_css, $wp_version;
global  $wp_version;

function bwads_renderscript()
{

 //$bwads_geoip = "";
 //global $bwads_scripts;
 $bwadsprodid = get_option('bwapsprodid');
 $bwadsstv = get_option('bwapsstate');
 $bwadszipv = get_option('bwapszip');
 $bwadshf = get_option('bwheaderfunctions');
 $bwadsmaxads = get_option('bwapsmaxads');
 $bwadsstyle = get_option('bwadsstylesheet');
 //Validation for the rendering of the rendring script
 if ( empty($bwadshf) ) {
  if($bwadsstyle == "1"){
    $bwadscss = "";
    $bwadshf = "//bwserver.net/scripts/bw-load-bwads.js";
  }elseif($bwadsstyle == "2"){
    $bwadscss = "";
    $bwadshf = "//bwserver.net/scripts/bw-load-bwads-skinny.js";
  }else{
   $bwadscss = '<link rel="stylesheet" media="screen" href="//cdn.bwserver.net/styles/BWads-ilistings.css" />' . "\n";
   $bwadshf = "//cdn.bwserver.net/scripts/bwads-load.js";
  }
 }else{
  $bwadscss = "";
  $bwadshf = "//bwserver.net/scripts/bw-load-bwads.js";
 }

 if ($bwadsprodid == "") { //if the user input a value for the product ID, if not follows the next code
  if ($_REQUEST["prodid"] == "") { //if prodid exists on the URL and if it's not empty
   $bwadsprodid = "200"; //if empty the value of prodid is 200
  }
 }
 if (empty($bwadsstv) && empty($bwadszipv) ) { //if the user input an especific state, if not follows the next code
   if ($_REQUEST["zip"] == "" && $_REQUEST["st"] == "") {
    $bwads_geoip = "\n<script type=\"text/javascript\" language=\"javascript\" src=\"//www.bwserver.net/scripts/jsgeo.php\"></script>";
    $bwadsstv = "state_cd"; //if non of the previous values exists grabs a GEO-IP state value
   }else{
    $bwads_geoip = "";
    $bwadsstv = '""';
   }
 }elseif( !empty($bwadsstv) ){
  $bwadsstv = '"'.$bwadsstv.'"';
 }
 //the condition ends

 if (empty($bwadszipv) && $_REQUEST["zip"] != "") { //if zip exist on the URL
   $bwadszipv = "";
  }  else $bwadszipv = "";
 //the condition ends

 if ($bwadsmaxads == "") {
  $bwadsmaxads = "8";
 } //if the user doesn't input a max ads value the default value will be 8

 $bwads_scripts = $bwads_geoip . "\n";
 $bwads_scripts .= $bwadscss;
 $bwads_scripts .= '<script type="text/javascript" language="Javascript">' . "\n";
 $bwads_scripts .= 'bwapsprodid = "' . $bwadsprodid . '";' . "\n";
 $bwads_scripts .= 'bwapsstate = ' . $bwadsstv .';'. "\n";
 $bwads_scripts .= 'bwapszip = "' . $bwadszipv .'";'. "\n";
 $bwads_scripts .= 'bwapsaid ="' . get_option('bwapsaid') . '";' . "\n";
 $bwads_scripts .= 'bwapscid ="' . get_option('bwapscid') . '";' . "\n";
 $bwads_scripts .= 'bwapsmaxads ="' . $bwadsmaxads . '";' . "\n";
 $bwads_scripts .= 'bwapsadsource = "' . get_option('bwapsadsource') . '";' . "\n";
 $bwads_scripts .= 'bwapsprodidparam ="' . get_option('bwapsprodidparam') . '";' . "\n";
 $bwads_scripts .= 'bwapsstateparam ="' . get_option('bwapsstateparam') . '";' . "\n";
 $bwads_scripts .= 'bwapszipparam ="' . get_option('bwapszipparam') . '";' . "\n";
 $bwads_scripts .= '</script>' . "\n";
 $bwads_scripts .= '<script type="text/javascript" src="' . $bwadshf . '"></script>' . "\n";
 echo apply_filters('bwads_renderscript', $bwads_scripts);
}

add_action('bwads_trigger', 'bwads_renderscript');

function show_bwads_camp_1()
{
 $ad_camp_encoded_value_1 = get_option('bwads_camp_1_code');
 $ad_camp_decoded_value_1 = html_entity_decode($ad_camp_encoded_value_1, ENT_COMPAT);
 if (!empty($ad_camp_decoded_value_1)) {
  $output = " $ad_camp_decoded_value_1";
 }
 return $output;
}

function show_bwads_camp_2()
{
 $ad_camp_encoded_value_2 = get_option('bwads_camp_2_code');
 $ad_camp_decoded_value_2 = html_entity_decode($ad_camp_encoded_value_2, ENT_COMPAT);
 if (!empty($ad_camp_decoded_value_2)) {
  $output = " $ad_camp_decoded_value_2";
 }
 return $output;
}

function show_bwads_camp_3()
{
 $ad_camp_encoded_value_3 = get_option('bwads_camp_3_code');
 $ad_camp_decoded_value_3 = html_entity_decode($ad_camp_encoded_value_3, ENT_COMPAT);
 if (!empty($ad_camp_decoded_value_3)) {
  $output = " $ad_camp_decoded_value_3";
 }
 return $output;
}

function show_bwads_camp_4()
{
 $ad_camp_encoded_value_4 = bwads_trigger();
 $ad_camp_decoded_value_4 = html_entity_decode($ad_camp_encoded_value_4, ENT_COMPAT);
 if (!empty($ad_camp_decoded_value_4)) {
  $output = " $ad_camp_decoded_value_4";
 }
 return $output;
}

function show_bwads_camp_5()
{
 $ad_camp_encoded_value_5 = get_option('bwadsstylesheet');
 $ad_camp_encoded_value_5 .= get_option('bwapsprodid');
 $ad_camp_encoded_value_5 .= get_option('bwapsstate');
 $ad_camp_encoded_value_5 .= get_option('bwapszip');
 $ad_camp_encoded_value_5 .= get_option('bwapsaid');
 $ad_camp_encoded_value_5 .= get_option('bwapscid');
 $ad_camp_encoded_value_5 .= get_option('bwapsmaxads');
 $ad_camp_encoded_value_5 .= get_option('bwapsadsource');
 $ad_camp_encoded_value_5 .= get_option('bwapsprodidparam');
 $ad_camp_encoded_value_5 .= get_option('bwapsstateparam');
 $ad_camp_encoded_value_5 .= get_option('bwapszipparam');
 $ad_camp_encoded_value_5 .= get_option('bwheaderfunctions');
 $ad_camp_decoded_value_5 = html_entity_decode($ad_camp_encoded_value_5, ENT_COMPAT);
 if (!empty($ad_camp_decoded_value_5)) {
  $output = " $ad_camp_decoded_value_5";
 }
 return $output;
}

function bwads_camp_process($content)
{
 if (strpos($content, "<!-- bwads_camp_1 -->") !== FALSE) {
  $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
  $content = str_replace('<!-- bwads_camp_1 -->', show_bwads_camp_1(), $content);
 }
 if (strpos($content, "<!-- bwads_camp_2 -->") !== FALSE) {
  $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
  $content = str_replace('<!-- bwads_camp_2 -->', show_bwads_camp_2(), $content);
 }
 if (strpos($content, "<!-- bwads_camp_3 -->") !== FALSE) {
  $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
  $content = str_replace('<!-- bwads_camp_3 -->', show_bwads_camp_3(), $content);
 }
 if (strpos($content, "<!-- bwads_camp_3 -->") !== FALSE) {
  $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
  $content = str_replace('<!-- bwads_camp_3 -->', show_bwads_camp_3(), $content);
 }
 if (strpos($content, "<!-- bwads_camp_4 -->") !== FALSE) {
  $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
  $content = str_replace('<!-- bwads_camp_4 -->', show_bwads_camp_4(), $content);
 }
 return $content;
}

// Displays BrokersWeb Ads Options menu
function bwads_camp_add_option_page()
{
 if (function_exists('add_options_page')) {
  add_menu_page('BrokersWeb Ads Settings', 'BrokersWeb Ads', 8, 'brokerswebads', 'bwads_insertion_options_page', '../wp-content/plugins/brokerswebads/images/menu_icon.ico');
  // Add submenu page with same slug as parent to ensure no duplicates
  add_submenu_page('brokerswebads', 'BrokersWeb Ads Banners', 'Banner Showcase', 8, 'bwads_banners', 'bwads_banners_page');
 }
}

function bwads_insertion_options_page()
{
 global $wp_bw_ad_insert_version;
 if (isset($_POST['info_update'])) {
  echo '<div id="message" class="updated fade"><p><strong>';
  $tmpCode1 = htmlentities(stripslashes($_POST['bwads_camp_1_code']), ENT_COMPAT);
  update_option('bwads_camp_1_code', $tmpCode1);
  $tmpCode2 = htmlentities(stripslashes($_POST['bwads_camp_2_code']), ENT_COMPAT);
  update_option('bwads_camp_2_code', $tmpCode2);
  $tmpCode3 = htmlentities(stripslashes($_POST['bwads_camp_3_code']), ENT_COMPAT);
  update_option('bwads_camp_3_code', $tmpCode3);
  $bwads_stylesheet = htmlentities(stripslashes($_POST['bwadsstylesheet']), ENT_COMPAT); //overrides the default stylesheet
  update_option('bwadsstylesheet', $bwads_stylesheet);
  $bwads_prodid = htmlentities(stripslashes($_POST['bwapsprodid']), ENT_COMPAT); //bwapsprodid variable
  update_option('bwapsprodid', $bwads_prodid);
  $bwads_state = htmlentities(stripslashes($_POST['bwapsstate']), ENT_COMPAT); //bwapsstate variable
  update_option('bwapsstate', $bwads_state);
  $bwads_zip = htmlentities(stripslashes($_POST['bwapszip']), ENT_COMPAT); //bwapszip variable
  update_option('bwapszip', $bwads_zip);
  $bwads_id = htmlentities(stripslashes($_POST['bwapsaid']), ENT_COMPAT); //bwapsaid variable
  update_option('bwapsaid', $bwads_id);
  $bwads_cid = htmlentities(stripslashes($_POST['bwapscid']), ENT_COMPAT); //bwapscid variable
  update_option('bwapscid', $bwads_cid);
  $bwads_maxads = htmlentities(stripslashes($_POST['bwapsmaxads']), ENT_COMPAT); //bwapsmaxads variable
  update_option('bwapsmaxads', $bwads_maxads);
  $bwads_source = htmlentities(stripslashes($_POST['bwapsadsource']), ENT_COMPAT); //bwapsadsource variable
  update_option('bwapsadsource', $bwads_source);
  $bwdas_prodname = htmlentities(stripslashes($_POST['bwapsprodidparam']), ENT_COMPAT); //bwapsprodidparam variable
  update_option('bwapsprodidparam', $bwdas_prodname);
  $bwads_stname = htmlentities(stripslashes($_POST['bwapsstateparam']), ENT_COMPAT); //bwapsstateparam variable
  update_option('bwapsstateparam', $bwads_stname);
  $bwads_zipname = htmlentities(stripslashes($_POST['bwapszipparam']), ENT_COMPAT); //bwapszipparam variable
  update_option('bwapszipparam', $bwads_zipname);
  $bwads_hf = htmlentities(stripslashes($_POST['bwheaderfunctions']), ENT_COMPAT); //overrides the defauld header functions
  update_option('bwheaderfunctions', $bwads_hf);
  $bwadscreated = array();
  if (isset($_POST["bwads-page"]) /* and !empty($bwads_id) and !empty($bwads_cid)*/) {
   $postArray = array(
    'post_title' => __('Results', 'brokersweb-ads'),
    'post_status' => 'publish',
    'post_content' => __('<!-- bwads_camp_4 -->', 'brokersweb-ads'),
    'post_type' => 'page'
   );
   if ($post = wp_insert_post($postArray)) {
    $bwadscreated['bwads-page'] = true;
    unset ($input['bwads-page']);
   }
  }
  $bwadsremoved = array();
  if (isset($_POST["bwads-remove-page"]) /* and !empty($bwads_id) and !empty($bwads_cid)*/) {
   $postDelete = get_page_by_title('Results');
   if ($post = wp_delete_post($postDelete->ID, $force_delete = true)) {
    $bwadsremoved['bwads-page'] = true;
    unset ($input['bwads-page']);
   }
  }

  if (isset($bwads_id) and isset($bwads_cid)) {
  }
  $tmpCode4 = $_POST['bwads_renderscript'];
  update_option('bwads_renderscript', $tmpCode4);
  echo 'Options Updated!';
  echo '</strong></p></div>';
 }

 ?>

<div id="bwwrapper" class="wrap">
<img class="bwlogo" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/brokerswebads/images/bw-logo.png" alt="BrokersWeb.com"/>

<h2>Brokers Web Ads &raquo; Plugin Settings V.<?php echo $wp_bw_ad_insert_version; ?></h2>

<h3 id="bwphone">1-877-887-5267 <br/>
 <small>8am - 5pm PST (M - F)</small>
</h3>
<div id="BrokersWeb_warning" class="error fade">
 <p><strong>If you don't have an account yet, register your accout
  at:&nbsp;</strong><a target="_blank" href="http://www.brokersweb.com/Affiliates.aspx">BrokersWeb.com</a><a id="bwclose" href="#">X</a></p>
</div>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
 <input type="hidden" name="info_update" id="info_update" value="true"/>

 <ul id="bwnav">
  <li><a href="#bwusage" title="Usage" class="bwselected">Usage</a></li>
  <li> /</li>
  <li><a href="#bwwizard" title="BrokersWeb Ads Wizard">BrokersWeb Ads Page Wizard</a></li>
  <li> /</li>
  <li><a href="#bwmanual" title="Manual Input">Manual Input</a></li>
 </ul>

 <!--BW Ads Usage -->
 <div id="bwusage" class="tabcontent">
  <h4>Use this plugin to easily insert Brokers Web iListings to your posts and pages.<br/>There are three ways you can use this plugin:</h4>
  <ul>
   <li>
    <div class="liheading">Use the BrokersWeb Ads plugin wizard:</div>
    <div class="licont">
     <div class="bbottom bwadsli">It's Easier</div>
     <div class="bbottom btop bwadsli">No Coding At ALL!</div>
     <div class="bbottom btop bwadsli">Easy to undo</div>
     <div class="btop bwadsli"></div>
    </div>
    <div id="demowiz" class="tabhidden"></div>
   </li>
   <li>
    <div class="liheading">Add the trigger text to your posts or pages:</div>
    <div class="licont">
     <div class="bbottom bwadsli">&lt;!-- bwads_camp_1 --&gt;</div>
     <div class="bbottom btop bwadsli">&lt;!-- bwads_camp_2 --&gt;</div>
     <div class="bbottom btop bwadsli">&lt;!-- bwads_camp_3 --&gt;</div>
     <div class="btop bwadsli"></div>
    </div>
    <div id="demotrig" class="tabhidden"></div>
   </li>
   <li>
    <div class="liheading">Call the function from template files:</div>
    <div class="licont">
     <div class="bbottom bwadsli">&lt;?php echo show_bwads_camp_1(); ?&gt;</div>
     <div class="bbottom btop bwadsli">&lt;?php echo show_bwads_camp_2(); ?&gt;</div>
     <div class="bbottom btop bwadsli">&lt;?php echo show_bwads_camp_3(); ?&gt;</div>
     <div class="btop bwadsli"></div>
    </div>
    <div id="demofunc" class="tabhidden"></div>
   </li>
  </ul>
 </div>
 <!--#bwusage ends-->

 <!--BW Ads Wizard -->
 <div id="bwwizard" class="tabhidden">
  <h3>BrokersWeb Ads Page Wizard</h3>

  <div class="wizard-table">
   <?php if (get_page_by_title('Results')) { ?>
   <div><?php _e('The BrokersWeb results page had been created, wasn\'t that easy?', 'brokersweb-ads'); ?></div>
   <div>If you have any questions please <a href="mailto:cristopher@brokersweb.com" title="let us know">let us know</a>
    <input type="hidden" name="bwapsaid" value="<?php echo get_option('bwapsaid') ?>"/><input type="hidden" name="bwapscid" value="<?php echo get_option('bwapscid') ?>"/></div>
   <div>
    <label>Undo BrokersWeb Ads work? <input type="checkbox" name="bwads-remove-page" id="bwads-remove-page"> Yes</label><br/>
    <div id="bwads-remove-page_warning" class="bwads_warning" style="font-weight:700;font-size:14px;">WARNING THIS CANT BE UNDONE</div>
   </div>
   <?php } else { ?>
   <div id="bwwizcta">
     <?php _e('Let BrokersWeb-Ads take care of the dirty work?', 'brokersweb-ads'); ?><br/>
    <label><input type="checkbox" name="bwads-page" id="bwads-page"/> Yes</label></div>
   <div>
    <label for="bwapsaid"><?php _e('BrokersWeb aps ID (bwapsaid)', 'brokersweb-ads'); ?></label><br/>
    <span class="bwrequired">*</span><input type="text" name="bwapsaid" id="bwapsaid" value="<?php echo get_option('bwapsaid') ?>" placeholder="10901"/>
    <div id="bwapsaid_warning" class="bwads_warning">Invalid Affiliate ID please double check on <a target="_blank" href="http://www.brokersweb.com/Affiliates.aspx">BrokersWeb.com</a></div>
   </div>
   <div><label for="bwapscid">
    <?php _e('BrokersWeb Campaing ID (bwapscid)', 'brokersweb-ads'); ?></label><br/>
    <span class="bwrequired">*</span><input type="text" name="bwapscid" id="bwapscid" value="<?php echo get_option('bwapscid') ?>" placeholder="2173"/>
    <div id="bwapscid_warning" class="bwads_warning">Invalid Campaign ID please double check on <a target="_blank" href="http://www.brokersweb.com/Affiliates.aspx">BrokersWeb.com</a></div>
   </div>
   <?php } ?>
   <!--Advanced Mode-->
   <div class="bwads_advanced_container">
    <label for="bwapsprodid"><?php _e('Specific product ID (bwapsprodid)', 'brokersweb-ads'); ?></label><br/>
    <select name="bwapsprodid" id="bwapsprodid">
     <option <?php selected(get_option('bwapsprodid'), "") ?> value=""> Product</option>
     <option <?php selected(get_option('bwapsprodid'), "200") ?> value="200"> Health</option>
     <option <?php selected(get_option('bwapsprodid'), "300") ?> value="300"> Auto</option>
     <option <?php selected(get_option('bwapsprodid'), "400") ?> value="400"> Home</option>
     <option <?php selected(get_option('bwapsprodid'), "401") ?> value="401"> Renters</option>
     <option <?php selected(get_option('bwapsprodid'), "260") ?> value="260"> Life</option>
     <option <?php selected(get_option('bwapsprodid'), "500") ?> value="500"> Mortgage Refinance</option>
     <option <?php selected(get_option('bwapsprodid'), "501") ?> value="501"> Mortgage Purchase</option>
     <option <?php selected(get_option('bwapsprodid'), "220") ?> value="220"> Group</option>
     <option <?php selected(get_option('bwapsprodid'), "250") ?> value="250"> Student</option>
     <option <?php selected(get_option('bwapsprodid'), "240") ?> value="240"> Medicare</option>
     <option <?php selected(get_option('bwapsprodid'), "210") ?> value="210"> Short Term</option>
     <option <?php selected(get_option('bwapsprodid'), "230") ?> value="230"> Dental</option>
    </select>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapsstate"><?php _e('Specific state ID (bwapsstate)', 'brokersweb-ads'); ?></label><br/>
    <select name="bwapsstate" id="bwapsstate">
     <option <?php selected(get_option('bwapsstate'), ""); ?> value="">Select</option>
     <option <?php selected(get_option('bwapsstate'), "AL"); ?> value="AL">ALABAMA</option>
     <option <?php selected(get_option('bwapsstate'), "AK"); ?> value="AK">ALASKA</option>
     <option <?php selected(get_option('bwapsstate'), "AZ"); ?> value="AZ">ARIZONA</option>
     <option <?php selected(get_option('bwapsstate'), "AR"); ?> value="AR">ARKANSAS</option>
     <option <?php selected(get_option('bwapsstate'), "CA"); ?> value="CA">CALIFORNIA</option>
     <option <?php selected(get_option('bwapsstate'), "CO"); ?> value="CO">COLORADO</option>
     <option <?php selected(get_option('bwapsstate'), "CT"); ?> value="CT">CONNECTICUT</option>
     <option <?php selected(get_option('bwapsstate'), "DE"); ?> value="DE">DELAWARE</option>
     <option <?php selected(get_option('bwapsstate'), "DC"); ?> value="DC">DC</option>
     <option <?php selected(get_option('bwapsstate'), "FL"); ?> value="FL">FLORIDA</option>
     <option <?php selected(get_option('bwapsstate'), "GA"); ?> value="GA">GEORGIA</option>
     <option <?php selected(get_option('bwapsstate'), "HI"); ?> value="HI">HAWAII</option>
     <option <?php selected(get_option('bwapsstate'), "ID"); ?> value="ID">IDAHO</option>
     <option <?php selected(get_option('bwapsstate'), "IL"); ?> value="IL">ILLINOIS</option>
     <option <?php selected(get_option('bwapsstate'), "IN"); ?> value="IN">INDIANA</option>
     <option <?php selected(get_option('bwapsstate'), "IA"); ?> value="IA">IOWA</option>
     <option <?php selected(get_option('bwapsstate'), "KS"); ?> value="KS">KANSAS</option>
     <option <?php selected(get_option('bwapsstate'), "KY"); ?> value="KY">KENTUCKY</option>
     <option <?php selected(get_option('bwapsstate'), "LA"); ?> value="LA">LOUISIANA</option>
     <option <?php selected(get_option('bwapsstate'), "ME"); ?> value="ME">MAINE</option>
     <option <?php selected(get_option('bwapsstate'), "MA"); ?> value="MA">MASSACHUSETTS</option>
     <option <?php selected(get_option('bwapsstate'), "MD"); ?> value="MD">MARYLAND</option>
     <option <?php selected(get_option('bwapsstate'), "MI"); ?> value="MI">MICHIGAN</option>
     <option <?php selected(get_option('bwapsstate'), "MN"); ?> value="MN">MINNESOTA</option>
     <option <?php selected(get_option('bwapsstate'), "MS"); ?> value="MS">MISSISSIPPI</option>
     <option <?php selected(get_option('bwapsstate'), "MO"); ?> value="MO">MISSOURI</option>
     <option <?php selected(get_option('bwapsstate'), "MT"); ?> value="MT">MONTANA</option>
     <option <?php selected(get_option('bwapsstate'), "NE"); ?> value="NE">NEBRASKA</option>
     <option <?php selected(get_option('bwapsstate'), "NV"); ?> value="NV">NEVADA</option>
     <option <?php selected(get_option('bwapsstate'), "NH"); ?> value="NH">NEW HAMPSHIRE</option>
     <option <?php selected(get_option('bwapsstate'), "NJ"); ?> value="NJ">NEW JERSEY</option>
     <option <?php selected(get_option('bwapsstate'), "NM"); ?> value="NM">NEW MEXICO</option>
     <option <?php selected(get_option('bwapsstate'), "NY"); ?> value="NY">NEW YORK</option>
     <option <?php selected(get_option('bwapsstate'), "NC"); ?> value="NC">NORTH CAROLINA</option>
     <option <?php selected(get_option('bwapsstate'), "ND"); ?> value="ND">NORTH DAKOTA</option>
     <option <?php selected(get_option('bwapsstate'), "OH"); ?> value="OH">OHIO</option>
     <option <?php selected(get_option('bwapsstate'), "OK"); ?> value="OK">OKLAHOMA</option>
     <option <?php selected(get_option('bwapsstate'), "OR"); ?> value="OR">OREGON</option>
     <option <?php selected(get_option('bwapsstate'), "PA"); ?> value="PA">PENNSYLVANIA</option>
     <option <?php selected(get_option('bwapsstate'), "RI"); ?> value="RI">RHODE ISLAND</option>
     <option <?php selected(get_option('bwapsstate'), "SC"); ?> value="SC">SOUTH CAROLINA</option>
     <option <?php selected(get_option('bwapsstate'), "SD"); ?> value="SD">SOUTH DAKOTA</option>
     <option <?php selected(get_option('bwapsstate'), "TN"); ?> value="TN">TENNESSEE</option>
     <option <?php selected(get_option('bwapsstate'), "TX"); ?> value="TX">TEXAS</option>
     <option <?php selected(get_option('bwapsstate'), "UT"); ?> value="UT">UTAH</option>
     <option <?php selected(get_option('bwapsstate'), "VA"); ?> value="VA">VIRGINIA</option>
     <option <?php selected(get_option('bwapsstate'), "VI"); ?> value="VI">VIRGIN ISLANDS</option>
     <option <?php selected(get_option('bwapsstate'), "VT"); ?> value="VT">VERMONT</option>
     <option <?php selected(get_option('bwapsstate'), "WA"); ?> value="WA">WASHINGTON</option>
     <option <?php selected(get_option('bwapsstate'), "WV"); ?> value="WV">WEST VIRGINIA</option>
     <option <?php selected(get_option('bwapsstate'), "WI"); ?> value="WI">WISCONSIN</option>
     <option <?php selected(get_option('bwapsstate'), "WY"); ?> value="WY">WYOMING</option>
    </select>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapszip"><?php _e('Specific ZIP code (bwapszip)', 'brokersweb-ads'); ?></label><br/>
    <input type="text" name="bwapszip" id="bwapszip" value="<?php echo get_option('bwapszip') ?>" placeholder="33138"/>
    <div id="bwapszip_warning" class="bwads_warning">Invalid ZIP code, the range must be from 4 to 5 numeric characters for example: 33138</div>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapsmaxads"><?php _e('Specific amount of ads to be displayed (bwapsmaxads)', 'brokersweb-ads'); ?></label><br/>
    <select name="bwapsmaxads" id="bwapsmaxads">
     <option <?php selected(get_option('bwapsmaxads'), "3"); ?> value="3">3</option>
     <option <?php selected(get_option('bwapsmaxads'), "4"); ?> value="4">4</option>
     <option <?php selected(get_option('bwapsmaxads'), "5"); ?> value="5">5</option>
     <option <?php selected(get_option('bwapsmaxads'), "6"); ?> value="6">6</option>
     <option <?php selected(get_option('bwapsmaxads'), "7"); ?> value="7">7</option>
     <option <?php selected(get_option('bwapsmaxads'), "8"); ?> value="8">8</option>
     <option <?php selected(get_option('bwapsmaxads'), "9"); ?> value="9">9</option>
     <option <?php selected(get_option('bwapsmaxads'), "10"); ?> value="10">10</option>
    </select>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapsadsource"><?php _e('Add a source to your campaign (bwapsadsource)', 'brokersweb-ads'); ?></label><br/>
    <input type="text" size="75" name="bwapsadsource" id="bwapsadsource" value="<?php echo get_option('bwapsadsource') ?>" placeholder="FloridaSerp"/>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapsprodidparam"><?php _e('Are you using a diferent name on your form instead of prodid (bwapsprodidparam)', 'brokersweb-ads'); ?></label><br/>
    <input type="text" size="75" name="bwapsprodidparam" id="bwapsprodidparam" value="<?php echo get_option('bwapsprodidparam') ?>" placeholder="Type"/>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapsstateparam"><?php _e('Are you using a diferent name on your form instead of st (bwapsstateparam)', 'brokersweb-ads'); ?></label><br/>
    <input type="text" size="75" name="bwapsstateparam" id="bwapsstateparam" value="<?php echo get_option('bwapsstateparam') ?>" placeholder="State"/>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwapszipparam"><?php _e('Are you using a diferent name on your form instead of zip (bwapszipparam)', 'brokersweb-ads'); ?></label><br/>
    <input type="text" size="75" name="bwapszipparam" id="bwapszipparam" value="<?php echo get_option('bwapszipparam') ?>" placeholder="Zip"/>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwadsstylesheet"><?php _e('Select the layout style for your ads ', 'brokersweb-ads'); ?></label><br/>
    <select name="bwadsstylesheet" id="bwadsstylesheet" >
     <option <?php selected(get_option('bwadsstylesheet'), "1"); ?> value="1">Default</option>
     <option <?php selected(get_option('bwadsstylesheet'), "2"); ?> value="2">Skinny</option>
     <option <?php selected(get_option('bwadsstylesheet'), "3"); ?> value="3">Old</option>
    </select>
   </div>
   <div class="bwads_advanced_container">
    <label for="bwheaderfunctions"><?php _e('Paste here the custom script URL provided by your affiliate manager', 'brokersweb-ads'); ?></label><br/>
    <input type="text" size="75" name="bwheaderfunctions" id="bwheaderfunctions" value="<?php echo get_option('bwheaderfunctions') ?>" placeholder="https://cdn.bwserver.net/scripts/bwads-load.js"/>
    <div id="bwheaderfunctions_warning" class="bwads_warning">Invalid URL use the URL provided by your affiliate manager for example: https://cdn.bwserver.net/scripts/bwads-load.js</div>
   </div>
   <div><a id="bwads_trigger" href="#" title="Advanced Mode">Advanced Mode</a></div>
  </div>
  <div class="submit">
   <input type="submit" class="button-primary" name="info_update" value="<?php _e('Update options'); ?> &raquo;"/>
  </div>
 </div>
 <!--#bwwizard ends-->

 <!--BW Ads Manual Input -->
 <div id="bwmanual" class="tabhidden">
  <h3>Manual Input via Shortcuts</h3>

  <div id="input-table">

   <!--BW Ads shortcode 1 -->
   <div><span class="bwinputtitle">BW Ad iListing Code 1:</span><br/>
    <p>Paste the BrokersWeb.com rendering script here.<br/><br/>
     <textarea cols="90" rows="5" name="bwads_camp_1_code"><?php echo get_option('bwads_camp_1_code'); ?></textarea><br/><br/>
     To show this add in your posts or pages use the token <code>&lt;!-- bwads_camp_1 --&gt;</code><br/>
     <span class="bwadsor"><span>&tilde;</span> OR <span>&tilde;</span></span>
     Call the function from a template file <code>&lt;?php echo show_bwads_camp_1(); ?&gt;</code></p>
   </div>

   <!--BW Ads shortcode 2 -->
   <div><span class="bwinputtitle">BWAds iListing Code 2:</span><br/>
    <p>Paste the BrokersWeb.com rendering script here.<br/><br/>
     <textarea cols="90" rows="5" name="bwads_camp_2_code"><?php echo get_option('bwads_camp_2_code'); ?></textarea><br/><br/>
     To show this add in your posts or pages use the token <code>&lt;!-- bwads_camp_2 --&gt;</code><br/>
     <span class="bwadsor"><span>&tilde;</span> OR <span>&tilde;</span></span>
     Call the function from a template file <code>&lt;?php echo show_bwads_camp_2(); ?&gt;</code></p>
   </div>

   <!--BW Ads shortcode 3 -->
   <div><span class="bwinputtitle">BWAds iListing Code 3:</span><br/>
    <p>Paste the BrokersWeb.com rendering script here.<br/><br/>
     <textarea cols="90" rows="5" name="bwads_camp_3_code"><?php echo get_option('bwads_camp_3_code'); ?></textarea><br/><br/>
     To show this add in your posts or pages use the token <code>&lt;!-- bwads_camp_3 --&gt;</code><br/>
     <span class="bwadsor"><span>&tilde;</span> OR <span>&tilde;</span></span>
     Call the function from a template file <code>&lt;?php echo show_bwads_camp_3(); ?&gt;</code></p>
   </div>
  </div>

  <div class="submit">
   <input type="submit" class="button-primary" name="info_update" value="<?php _e('Update options'); ?> &raquo;"/>
  </div>
 </div>
 <!--#bwmanual ends-->
</form>
</div>
<?php
}

//Function for the banner showcase submenu
function bwads_banners_page()
{
 include_once ('bwads_banners.php');
}

//calling the Widget class
include_once ('bwadsbannerswidget.php');

//ads a nofollow, no index tag on the results page
function bwNofollow()
{
 $content = "<meta name=\"robots\" content=\"noindex,nofollow\" /> \n";
 echo apply_filters('bwNofollow', $content);
}

add_action('wp_head', 'bwNofollow');

//Insert the BrokersWeb iListings.
add_filter('the_content', 'bwads_camp_process');
// Insert the bwads in the 'admin_menu'.
add_action('admin_menu', 'bwads_camp_add_option_page');

?>