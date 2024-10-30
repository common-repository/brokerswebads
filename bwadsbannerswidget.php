<?php
class Banners
{
 function activate()
 {
  $data = array(
   'title' => '',
   'default' => 'multiple',
   'actionuri' => 'results.html'
  );
  if (!get_option('widget_banner')) {
   add_option('widget_banner', $data);
  }
  else {
   update_option('widget_banner', $data);
  }
 }

 function deactivate()
 {
  delete_option('widget_banner');
 }

 function control_admin()
 {
  $data = get_option('widget_banner');
  //Evaluates the selected option and add the selected a "selected" attribute
  ?><div class="widget-content">
          <p>
            <label for="bwadsWidName">Title:</label><br />
            <input class="widefat" id="bwadsWidName" name="title" type="text" value="<?php echo $data['title'] ?>" />
          </p>
          <p>
            <label for="bwadsBannerURL">Banner Action URL</label><br />
            <input class="widefat" id="bwadsBannerURL" name="actionuri" type="text" value="<?php echo $data['actionuri']?>" />
          </p>
            <hr>
          <p>
            <label>Default Banner</label><br />
            <select class="widefat" name="bwadsBtype">
             <option value="multiple" <?php selected($data['default'], "multiple")?> >Multiple Insurance</option>
             <option value="auto" <?php selected($data['default'], "auto")?> >Auto Insurance</option>
             <option value="home" <?php selected($data['default'], "home")?> >Home Insurance</option>
             <option value="life" <?php selected($data['default'], "life")?> >Life Insurance</option>
             <option value="health" <?php selected($data['default'], "health")?> >Health Insurance</option>
             <option value="dental" <?php selected($data['default'], "dental")?> >Dental Insurance</option>
           </select>
          </p>
            <hr>
          <p><em>Your sidebar width must be at least 300px width</em></p>
        </div>
  <?php
  if (!empty($_POST)) {
   /*if(!empty($_POST['accDef'])) {
        $data['default'] = attribute_escape($_POST['accDef']);
   }
   else{
       $data['default'] = 'none';
   }*/
   $data['default'] = attribute_escape($_POST['bwadsBtype']);
   $data['title'] = attribute_escape($_POST['title']);
   $data['actionuri'] = attribute_escape($_POST['actionuri']);
   update_option('widget_banner', $data);
  }
 }

 //The Widget front end
 function widget($args)
 {
  global $wp_registered_widget;
  $data = get_option('widget_banner');
  //Evaluates which banner has been selected
  switch ($data['default']) {
   //if the selected banner is for Multiple Insurance
   case 'multiple' :
    $bw_selected_banner = '
<script language="javascript" src="https://cdn.bwserver.net/11000/11030/scripts/zipvalidate.js"></script>
<div id="QB-OrangeWave-300x250" style="margin: 0; padding: 0; width: 300px; height: 250px; background: url(https://cdn.bwserver.net/images/searchboxes/300x250-all-in-one1.png) no-repeat top left; text-align: left; position: relative;">
<form onSubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '">
    <select name="prodid" style="margin: 0; padding: 0; width: 145px; font: normal 12px Arial, Helvetica, sans-serif; position: absolute; top: 130px; left: 90px;">
         <option value="200">- Health</option>
         <option value="300">- Auto</option>
         <option value="400">- Home</option>
         <option value="260">- Life</option>
         <option value="500">- Mortgage Refinance</option>
         <option value="501">- Mortgage Purchase</option>
         <option value="220">- Group</option>
         <option value="250">- Student</option>
         <option value="240">- Medicare</option>
         <option value="210">- Short Term</option>
         <option value="230">- Dental</option>
    </select>
     <input type="text" maxlength="20" id="zip" name="zip" style="margin: 0; padding: 0; _padding: 1px 0 0 3px; width: 90px; font: normal 24px Arial, Helvetica, sans-serif; position: absolute; top: 165px; left: 90px;" />
   <input border="none" type="image" name="submit-button" src="https://cdn.bwserver.net/images/searchboxes/bw-all-in-one-btn-10827.png" alt="InsureMe - Insurance Quotes" style="margin: 0; padding: 0; border: none; position: absolute; bottom: 10px; left: 213px;"/>
</form></div>';
    break;
   //if the selected banner is for Auto Insurance
   case 'auto' :
    $bw_selected_banner = '
<script language="javascript" src="https://cdn.bwserver.net/scripts/bwvalidateform.js"></script>
<div style="background: transparent url(https://cdn.bwserver.net/selfimp/img/300X250/auto/300X250_br.png) no-repeat scroll 0 0; height:250px; left:0px; margin:auto; position:relative; width:300px;">
<div style=" height: 138px; left: 106px; position: absolute; top: 67px; width: 190px;">
<form onsubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '" style="background-color:transparent  !important; border:0px none !important; margin:0px; padding:0px;">
<div style="margin:0; padding:0;">
<div style=" left: 27px; margin: 0; padding: 0; position: absolute; top: 32px; width: 134px;">
<input id="zip" name="zip" type="text" maxlength="5" value= "ZIP Code..." onfocus="clearZipValue(this)" onblur="getZipValue(this)" style="text-align:center; width:134px; font-size:20px;  background:#FFF; height:37px; border:1px #000 solid;" />
</div>
<div style=" height: 44px; left: 19px; margin: 0; padding: 0; position: absolute; top: 75px; width: 148px;">
<input style="border:0 none;" id="submit" type="image" src="https://cdn.bwserver.net/selfimp/img/300X250/auto/300X250_btn.png" />
</div></div></form></div></div>';
    break;
   //if the selected banner is for Health Insurance
   case 'health' :
    $bw_selected_banner = '
<script language="javascript" src="https://cdn.bwserver.net/scripts/bwvalidateform.js"></script>
<div style="background: transparent url(https://cdn.bwserver.net/selfimp/img/300X250/health/300X250_br.jpg) no-repeat scroll 0 0; height:250px; left:0px; margin:auto; position:relative; width:300px;">
<div style="height: 110px;left: 135px;position: absolute;top: 127px;width: 163px;">
<form onsubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '" style="background-color:transparent  !important; border:0px none !important; margin:0px; padding:0px;">
<div style="margin:0; padding:0;">
<div style="left: 36px;margin: 0;padding: 0;position: absolute;top: 16px;width: 109px;">
<input id="zip" name="zip" type="text" maxlength="5" style="text-align:center; width:109px; font-size:20px;  background:url(https://cdn.bwserver.net/selfimp/img/300X250/health/300X250_zip.png) no-repeat scroll 0px 0px; height:40px; border:1px #000 solid;" />
</div>
<div style="height: 45px;left: 35px;margin: 0;padding: 0;position: absolute;top: 61px;width: 124px;">
<input style="border:0 none;" id="submit" type="image" src="https://cdn.bwserver.net/selfimp/img/300X250/health/300X250_btn.png" />
</div></div></form></div></div>';
    break;
   //if the selected banner is for Home Insurance
   case 'home' :
    $bw_selected_banner = '
<div style="background: transparent url(https://cdn.bwserver.net/selfimp/img/300X250/home/300X250_br.png) no-repeat scroll 0 0; height:250px; left:0px; margin:auto; position:relative; width:300px;">
<div style=" height: 119px; left: 95px; position: absolute; top: 117px; width: 165px;">
<form onsubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '" style="background-color:transparent  !important; border:0px none !important; margin:0px; padding:0px;">
<div style="margin:0; padding:0;">
<div style=" left: 36px; margin: 0; padding: 0;  position: absolute; top: 16px; width: 115px;">
<input id="zip" name="zip" type="text" maxlength="5" style="text-align:center; width:115px; font-size:20px;  background:url(https://cdn.bwserver.net/selfimp/img/300X250/home/300X250_zip.png) no-repeat scroll 0px 0px; height:42px; border:1px #000 solid;" />
</div>
<div style=" height: 47px; left: 38px; margin-bottom: 0; padding-bottom: 0; position: absolute; top: 66px; width: 113px;">
<input style="border:0 none;" id="submit" type="image" src="https://cdn.bwserver.net/selfimp/img/300X250/home/300X250_btn.png" />
</div></div></form></div></div>';
    break;
   //if the selected banner is for Life Insurance
   case 'life' :
    $bw_selected_banner = '
			<script language="javascript" src="https://cdn.bwserver.net/scripts/bwvalidateform.js"></script>
<div style="background: transparent url(https://cdn.bwserver.net/selfimp/img/300X250/life/300X250_br.png) no-repeat scroll 0 0; height:250px; left:0px; margin:auto; position:relative; width:300px;">
<div style=" height: 66px; left: 10px; position: absolute; top: 75px; width: 256px;">
<form onsubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '" style="background-color:transparent  !important; border:0px none !important; margin:0px; padding:0px;">
<div style="margin:0; padding:0;">
<div style=" left: 20px; margin: 0; padding: 0; position: absolute; top: 15px; width: 94px;">
<input id="zip" name="zip" type="text" maxlength="5" value= "ZIP Code..." onfocus="clearZipValue(this)" onblur="getZipValue(this)" style="text-align:center; width:94px; font-size:15px;  background:url(https://cdn.bwserver.net/selfimp/img/300X250/life/300X250_zip.png) no-repeat scroll 0px 0px; height:36px; border:1px #000 solid;" />
</div>
<div style=" height: 43px; left: 131px; margin: 0; padding: 0; position: absolute; top: 11px; width: 107px;">
<input style="border:0 none;" id="submit" type="image" src="https://cdn.bwserver.net/selfimp/img/300X250/life/300X250_btn.png" />
</div></div></form></div><div>';
    break;
   //if the selected banner is for Dental Insurance
   case 'dental' :
    $bw_selected_banner = '
<script language="javascript" src="https://cdn.bwserver.net/scripts/bwvalidateform.js"></script>
<div style="background: transparent url(https://cdn.bwserver.net/selfimp/img/300X250/dental_v2/300X250_V2_br.png) no-repeat scroll 0 0; height:250px; left:0px; margin:auto; position:relative; width:300px;">
<div style="height: 110px;left: 135px;position: absolute;top: 127px;width: 163px;">
<form onsubmit="return bwvalidateForm(this);" id="bwform" name="bwform" method="get" action="' . $data['actionuri'] . '" style="background-color:transparent  !important; border:0px none !important; margin:0px; padding:0px;">
<div style="margin:0; padding:0;">
<div style="left: 21px;margin: 0;padding: 0;position: absolute;top: 12px;width: 120px;">
<input id="zip" name="zip" type="text" maxlength="5" value= "ZIP Code..." onfocus="clearZipValue(this)" onblur="getZipValue(this)" style="text-align:center; width:120px; font-size:20px;  background:url(https://cdn.bwserver.net/selfimp/img/300X250/dental_v2/300X250_V2_zip.png) no-repeat scroll 0px 0px; height:38px; border:1px #000 solid;" />
</div>
<div style="height: 45px;left: 23px;margin: 0;padding: 0;position: absolute;top: 59px;width: 124px;">
<input style="border:0 none;" id="submit" type="image" src="https://cdn.bwserver.net/selfimp/img/300X250/dental_v2/300X250_V2_btn.png" />
</div></div></form></div></div>';
    break;
  }
  echo $args['before_widget'];
  echo $args['before_title'] . $data['title'] . $args['after_title'];
  echo $bw_selected_banner;
  echo $args['after_widget'];
 }

 //register the widget and it's control
 function register()
 {
  wp_register_sidebar_widget('BrokersWebAds-banners', 'BrokersWebAds-banners', array('Banners', 'widget'));
  wp_register_widget_control('BrokersWebAds-banners', 'BrokersWebAds-banners', array('Banners', 'control_admin'));
 }
}

add_action("widgets_init", array('Banners', 'register'));

//Register the Activation and Deactivation event
register_activation_hook(__FILE__, array('Banners', 'activate'));
register_deactivation_hook(__FILE__, array('Banners', 'deactivate'));
?>