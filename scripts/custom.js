// JavaScript Document
jQuery(window).resize(function () {
 bwfontResize();
});

jQuery(function () {
 imagePreview();
 bwfontResize();
 bwzebra();
 bwbanners();

 WindowTimer = setTimeout("bwadsaffiliate()", 10000);
 jQuery("#BrokersWeb_warning").hover(function () {
  clearTimeout(WindowTimer)
 });
 /****TABS****/
 var bwcookie = getCookie('bwIntroduction');
 if (bwcookie) {
  jQuery("#BrokersWeb_warning").css("display", "none");
  jQuery(".bwselected").removeClass("bwselected");
  jQuery(".tabcontent").attr("class", "tabhidden");
  jQuery("ul#bwnav li").find("a[href=" + bwcookie + "]").attr("class", "bwselected");
  jQuery(getCookie('bwIntroduction')).attr("class", "tabcontent");
 }
 jQuery("ul#bwnav li a").click(function () {
  var bwhref = jQuery(this).attr("href");
  setCookie('bwIntroduction', bwhref, 30);
  jQuery(".bwselected").removeClass("bwselected");
  jQuery(this).attr("class", "bwselected");
  jQuery(".tabcontent").attr("class", "tabhidden");
  jQuery(bwhref).attr("class", "tabcontent");
  return false;
 });

 jQuery("#bwclose").click(function () {
  jQuery("#BrokersWeb_warning").slideUp()
  return false;
 });

 jQuery("#bwads_trigger").toggle(
  function () {
   jQuery("#bwwrapper .wizard-table .bwads_advanced_container")
    .slideDown("slow")
   jQuery(this)
    .attr('title', 'Basic Mode')
    .html('Basic Mode')
   return false;
  },
  function () {
   jQuery("#bwwrapper .wizard-table .bwads_advanced_container")
    .slideUp("slow")
   jQuery(this)
    .attr('title', 'Advanced Mode')
    .html("Advanced Mode")
   return false;
  }
 );
 jQuery("#bwads-page").click(function () {
  if (jQuery("#bwads-page").is(":checked"))
   jQuery("#bwapsaid").focus();
 });
 jQuery("#bwads-remove-page").click(function () {
  if (jQuery("#bwads-remove-page").is(":checked")) {
   jQuery("#bwads-remove-page_warning").fadeIn(100)
   for (i = 0; i < 4; i++) {
    jQuery("#bwads-remove-page_warning").animate({right:"+=1%"}, 60);
    jQuery("#bwads-remove-page_warning").animate({right:"-=1%"}, 60);
   }
  }
  else {
   jQuery("#bwads-remove-page_warning").fadeOut("slow")
  }
 });
 jQuery("#bwapsaid")
  .blur(function () {
   if (!isID(jQuery("#bwapsaid").val())) {
    jQuery("#bwapsaid_warning").fadeIn('slow')
   }
   else jQuery("#bwapsaid_warning").fadeOut('slow')
   if (jQuery("#bwads-page").is(":checked"))
    jQuery("#bwapscid").focus();
  });
 jQuery("#bwapscid")
  .blur(function () {
   if (!isCID(jQuery("#bwapscid").val())) {
    jQuery("#bwapscid_warning").fadeIn('slow')
   }
   else jQuery("#bwapscid_warning").fadeOut('slow')
  });
 jQuery("#bwapsprodid")
  .blur(function () {
   if (jQuery("#bwapsprodid").val() != "") {
    if (!isPROD(jQuery("#bwapsprodid").val())) {
     jQuery("#bwapsprodid_warning").fadeIn('slow')
    }
    else jQuery("#bwapsprodid_warning").fadeOut('slow')
   }
  });
 jQuery("#bwapsstate")
  .blur(function () {
   if (jQuery("#bwapsstate").val() != "") {
    if (!isST(jQuery("#bwapsstate").val())) {
     jQuery("#bwapsstate_warning").fadeIn('slow')
    }
    else jQuery("#bwapsstate_warning").fadeOut('slow')
   }
  });
 jQuery("#bwapszip")
  .blur(function () {
   if (jQuery("#bwapszip").val() != "") {
    if (!isZIP(jQuery("#bwapszip").val())) {
     jQuery("#bwapszip_warning").fadeIn('slow')
    }
    else jQuery("#bwapszip_warning").fadeOut('slow')
   }
  });
 jQuery("#bwapsmaxads")
  .blur(function () {
   if (jQuery("#bwapsmaxads").val() != "") {
    if (!isMAX(jQuery("#bwapsmaxads").val())) {
     jQuery("#bwapsmaxads_warning").fadeIn('slow')
    }
    else jQuery("#bwapsmaxads_warning").fadeOut('slow')
   }
  });
 jQuery("#bwapsSnippetCharsLimit")
  .blur(function () {
   if (jQuery("#bwapsSnippetCharsLimit").val() != "") {
    if (!isCHAR(jQuery("#bwapsSnippetCharsLimit").val())) {
     jQuery("#bwapsSnippetCharsLimit_warning").fadeIn('slow')
    }
    else jQuery("#bwapsSnippetCharsLimit_warning").fadeOut('slow')
   }
  });
 jQuery("#bwheaderfunctions")
  .blur(function () {
   if (jQuery("#bwheaderfunctions").val() != "") {
    if (!isURI(jQuery("#bwheaderfunctions").val())) {
     jQuery("#bwheaderfunctions_warning").fadeIn('slow')
    }
    else jQuery("#bwheaderfunctions_warning").fadeOut('slow')
   }
  });
 jQuery("#bwadsstylesheet")
  .blur(function () {
   if (jQuery("#bwadsstylesheet").val() != "") {
    if (!isURI(jQuery("#bwadsstylesheet").val())) {
     jQuery("#bwadsstylesheet_warning").fadeIn('slow')
    }
    else jQuery("#bwadsstylesheet_warning").fadeOut('slow')
   }
  });

 jQuery(".bwads_warning").click(function () {
  jQuery(this).fadeOut('slow')
 });

 jQuery(".button-primary").click(function () {
  if (jQuery("#bwads-page").is(":checked") && (!isID(jQuery("#bwapsaid").val()) || !isCID(jQuery("#bwapscid").val()))) {
   if (!isID(jQuery("#bwapsaid").val())) {
    jQuery("#bwapsaid").focus();
   }
   else {
    jQuery("#bwapscid").focus();
   }
   return false;
  } else {
   return true;
  }
 });
});

function isID(value) {
 var exp_bwapsaid = new RegExp(/(^(10)(([0-9])){3,3}$)|(^(11)(([0-9])){3,3}$)/);
 return exp_bwapsaid.test(value);
}
function isCID(value) {
 var exp_bwapscid = new RegExp(/(^\d{4,4}$)/);
 return exp_bwapscid.test(value);
}
function isPROD(value) {
 var exp_prodid = new RegExp(/^(200|210|220|230|240|250|260|300)$/);
 return exp_prodid.test(value);
}
function isST(value) {
 var exp_st = new RegExp(/^([A-Z]){2,2}$/);
 return exp_st.test(value);
}
function isZIP(value) {
 var exp_zip = new RegExp(/(^\d{5,5}$)|(^\d{4,4}$)/);
 return exp_zip.test(value);
}
function isMAX(value) {
 var exp_maxads = new RegExp(/^([\d]|1[0,1,2,3,4,5,6,7,8,9])$/);
 return exp_maxads.test(value);
}
function isCHAR(value) {
 var exp_char = new RegExp(/^([1-9][0-9][0-9])$/);
 return exp_char.test(value);
}
function isURI(value) {
 var exp_URI = new RegExp(/(((f|ht)tp(s)?):\/\/)?(www\.)?([a-zA-Z0-9\-]{1,}\.){1,}?([a-zA-Z0-9\-]{2,}\.(com|org|net|mil|edu|ca|co.uk|com.au|gov)(\.[a-zA-Z0-9\-]{2,4})?)/);
 return exp_URI.test(value);
}
this.imagePreview = function () {
 xOffset = 50;
 yOffset = 100;
 jQuery("#bwwrapper #bwusage ul li").hover(function (e) {
   jQuery(this).children(".tabhidden")
    .css('z-index', '20')
    .addClass("bwtooltip")
    .removeClass("tabhidden")
    .css("top", (e.pageY - xOffset) + "px")
    .css("left", (e.pageX + yOffset) + "px")
  },
  function () {
   jQuery(".bwtooltip")
    .addClass("tabhidden")
    .removeClass("bwtooltip");
  });
 jQuery("#bwwrapper #bwusage ul li").mousemove(function (e) {
  jQuery(".bwtooltip")
   .css("top", (e.pageY - xOffset) + "px")
   .css("left", (e.pageX - yOffset) + "px");
 });
};

this.bwfontResize = function () {
 var bwwrappresWidth = jQuery("#bwwrapper").width();
 if (bwwrappresWidth <= "592") {
  jQuery("#bwwrapper h2").animate({
   fontSize:"22px",
   lineHeight:"24px"
  }, 5);
  jQuery("#bwwrapper #bwusage ul li").animate({
   width:"300px",
   fontSize:"10px"
  }, 5);
  jQuery("#bwwrapper .wizard-table").animate({width:"100%"}, 5);
  //jQuery("#input-table").animate({width:"97%"},5);
 } else {
  jQuery("#bwwrapper h2").animate({
   fontSize:"26px",
   lineHeight:"30px"
  }, 5);
  jQuery("#bwwrapper #bwusage ul li").animate({
   width:"400px",
   fontSize:"12px"
  }, 5);
  jQuery("#bwwrapper .wizard-table").animate({width:"765px"}, 5);
  //jQuery("#input-table").animate({width:"695px"},5);
 }
}
this.bwzebra = function () {
 jQuery("#bwwrapper .wizard-table .bwads_advanced_container").css("display", "none");
 jQuery("#bwwizard .wizard-table").children(":even").addClass("bwstrip");
}
this.bwbanners = function () {
 jQuery("#bwbanners #input-table div:even").addClass("bwadsleft");
 jQuery("#bwbanners #input-table div:odd").addClass("bwadsright");
}
function bwadsaffiliate() {
 jQuery("#BrokersWeb_warning").slideUp();
}

/*Jquery Cookie */
function setCookie(name, value, days) {
 if (days) {
  var date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  var expires = "; expires=" + date.toGMTString();
 }
 else var expires = "";
 document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(name) {
 var nameEQ = name + "=";
 var ca = document.cookie.split(';');
 for (var i = 0; i < ca.length; i++) {
  var c = ca[i];
  while (c.charAt(0) == ' ') c = c.substring(1, c.length);
  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
 }
 return null;
}

function deleteCookie(name) {
 setCookie(name, "", -1);
}