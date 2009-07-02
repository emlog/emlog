/*Style Sheet Switcher version 1.1x April 13, 2008
Author: Dynamic Drive: http://www.dynamicdrive.com
Usage terms: http://www.dynamicdrive.com/notice.htm
Modified/Compressed for use in Inanis Wordpress Themes*/
//var defaultstyle = ""; // Default Theme
//var manual_or_random = "manual";
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('3 8="7 a";3 z="15";3 s="/";3 O="";2(J=="16"){3 F=b(z);2(F==t){4(17)}h{4(F)}}h 2(J=="l"){2(8=="18"){4("","l")}h 2(8=="19"){2(b("A")==t){c.m="A="+4("","l")+"; g=/"}h{4(b("A"))}}h 2(8.1b(/^[1-9]+ a/i)!=-1){2(b("C")==t||n(b("Q"))!=n(8)){r("C",4("","l"),n(8));r("Q",8,n(8))}}h{4(b("C"))}}k 4(j,u){3 i,6,f=[""];1d(i=0;(6=c.1f("1g")[i]);i++){2(6.q("1h").1i()=="1j 1k"&&6.q("j")){6.w=1l;f.1m(6);2(6.q("j")==j){6.w=I}}}2(D u!="E"){3 o=T.U(T.l()*f.W);f[o].w=I}G(D u!="E"&&f[o]!="")?f[o].q("j"):""}k b(K){3 y=M Z(K+"=[^;]+","i");2(c.m.L(y)){G c.m.L(y)[0].14("=")[1]}G t}k r(d,H,a,g,p,v){3 e=M 1a();3 1c=(D a!="E")?e.P(e.R()+n(a)):e.P(e.R()-5);c.m=d+"="+V(H)+(a?"; N="+e.X():"")+(g?"; g="+g:"")+(p?"; p="+p:"")+(v?"; v":"")}k 10(B,a){2(c.11){4(B);r(z,B,a,s,O)}}k 1n(d){2(b(d)){c.m=d+"="+((s)?"; g="+s:"")+";N = S/S/Y x:x:x";13(d+" - 12 1e")}}',62,86,'||if|var|setStylesheet||cacheobj||randomsetting||days|getCookie|document|name|expireDate|altsheets|path|else||title|function|random|cookie|parseInt|randomnumber|domain|getAttribute|setCookie|cookiepath|null|randomize|secure|disabled|00|re|cookiename|mysheet_s|styletitle|mysheet_r|typeof|undefined|selectedtitle|return|value|false|manual_or_random|Name|match|new|expires|cookiesecure|setDate|mysheet_r_days|getDate|01|Math|floor|escape|length|toGMTString|2000|RegExp|chooseStyle|getElementById|Cookie|alert|split|moot|manual|defaultstyle|eachtime|sessiononly|Date|search|expstring|for|Deleted|getElementsByTagName|link|rel|toLowerCase|alternate|stylesheet|true|push|deleteCookie'.split('|'),0,{}))

/* Clock Function
Author: Inanis (http://www.inanis.net)
Compressed by http://javascriptcompressor.com/ */
function init()
	{
	timeDisplay=document.createTextNode("");
	document.getElementById("clockhr").appendChild(timeDisplay);
	timeDisplay1=document.createTextNode("");
	document.getElementById("clockmin").appendChild(timeDisplay1);
	timeDisplay2=document.createTextNode("");
	document.getElementById("clockpart").appendChild(timeDisplay2)
}
function updateClock()
	{
	var currentTime=new Date();
	var currentHours=currentTime.getHours();
	var currentMinutes=currentTime.getMinutes();
	currentMinutes=(currentMinutes<10?"0":"")+currentMinutes;
	var timeOfDay;
	//var timestyle = 1;
	
	if (timestyle == 2 ){
  	//24 hour display
  	timeOfDay=" ";
	}
	else {
	  //12 hour display
	  timeOfDay=(currentHours<12)?"AM":"PM";
  	currentHours=(currentHours>12)?currentHours-12:currentHours;
  	currentHours=(currentHours===0)?12:currentHours;
  }
  
	document.getElementById("clockhr").firstChild.nodeValue=currentHours;
	document.getElementById("clockmin").firstChild.nodeValue=currentMinutes;
	document.getElementById("clockpart").firstChild.nodeValue=timeOfDay
}

/* Start Menu Functions
Author: Inanis (http://www.inanis.net) */

//Set some startup variables
var $sbox;
var OrbWasClicked = 0;
var MenuIsUp=0;
var l=0;
var w=0;
var lt=0;
var throb=0;
var throbcount=0;
var FlyOutOpen=0;
var FlyOutSum = 0;
var FlyOutWasClicked = 0;
var mhovIsUp = 0;
var mhovLastUp = 0;
var mhovering = 0;
var lhovering=0;
var timer = "";
var tid;
var qlm=0;
var MOWasClicked=0;
var MOOpen=0;
var osIsNix=0;

// Search Box
function SearchBoxFocus() {
  $sbox = document.getElementById('searchbox').value;
  if ($sbox == $sboxtext ){
    document.getElementById('searchbox').value = "";
    document.getElementById('searchbox').style.fontStyle = "normal";
  }
}
function SearchBoxBlur() {
  $sbox = document.getElementById('searchbox').value;
  if ($sbox == "" ){
    document.getElementById('searchbox').style.fontStyle = "italic";
    document.getElementById('searchbox').value = $sboxtext;
  }
}

//Throb Cookie
function get_cookie ( cookie_name )
  {
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
  
    if ( results )
      return ( unescape ( results[2] ) );
    else
      return null;
  }

//Hide Opts Menu
function FadeOutMenu(){
    SMsHideAll();
    document.getElementById('StartMenu').style.visibility = "hidden";
    if (document.getElementById("smif")){
        document.getElementById("smif").style.display="none";
        document.getElementById("avif").style.display="none";
        document.getElementById("smif").style.visibility="hidden";
        document.getElementById("avif").style.visibility="hidden";
      }
}

//When Orb is clikt
function OClkd() {
  OrbWasClicked = 1;
  if (MenuIsUp == 0)
  {
    document.getElementById('StartMenu').style.visibility = "visible";
    document.getElementById('StartMenu').style.left = "0px";
    MenuIsUp = 1;
    if (osIsNix==1){
      document.getElementById("smif").style.display="block";
      document.getElementById("avif").style.display="block";
      document.getElementById("smif").style.visibility="visible";
      document.getElementById("avif").style.visibility="visible";
    }
  }
  else
  {
    FadeOutMenu();
    MenuIsUp=0;
  }
}

//When Options is clikt
function SMClkd(){
  MenuIsUp=1;
  OrbWasClicked=1;
  
  if (FlyOutSum > 0)
    {
      FlyOutSum = FlyOutSum - FlyOutOpen;
      SMLower(FlyOutSum);
      FlyOutSum=0;
    }
}

//When Document is clikt
function BodyClicked() {
  
  if (OrbWasClicked != 1)
    {
      FadeOutMenu();
      MenuIsUp=0;
    }
  if (FlyOutWasClicked != 1 && FlyOutOpen > 0)
    {
      SMLower(4);
      SMLower(5);
      FlyOutOpen=0;
      if (document.getElementById("flif")){
        document.getElementById("flif").style.display="none";
        document.getElementById("flif").style.visibility="hidden";
        document.getElementById("flif").style.width="1px";
        document.getElementById("flif").style.height="1px";
        document.getElementById("flif").style.left="-200px";
        document.getElementById("flif").style.bottom="0px";
      }
    }

  if (MOOpen > 0 && MOWasClicked!=1){
   molist(MOOpen);
   MOOpen=0;
  }

  OrbWasClicked=0;
  FlyOutWasClicked=0;
  MOWasClicked=0;
  lowermhov();
}

//Throb balloon
function ThrobBaloon() {
  if (throbcount<20){
    if (throb==0)
      {
        document.getElementById('StartBaloon').style.color = "#F22";
        throb=1;
        setTimeout ( ThrobBaloon, 120 );
        throbcount++;
      }
    else {
        document.getElementById('StartBaloon').style.color = "#000";
        throb=0;
        setTimeout ( ThrobBaloon, 120 );
        throbcount++;
    }
  }
}

//Hide balloon
function HideThrob(){
  document.getElementById('StartBaloon').style.visibility = "hidden";
  document.getElementById('StartBaloon').style.left = "-1000px";
  }

//Init baloon
function StartThrob(){
  var throbbedyet = get_cookie("throb");
  if (throbbedyet!="yes") {
    document.getElementById('StartBaloon').style.visibility = "visible";
    ThrobBaloon();
    document.cookie = "throb=yes";
  }
  if (throbbedyet=="yes"){
    HideThrob();
  }
  setTimeout (HideThrob, 6000);
}

//Hide/Show Secondary Submenus
function SMRaise(m) {
  element = "SMSub" + m;
  document.getElementById(element).style.visibility = "visible"; 
  if (m>0&&m<4) {
    document.getElementById(element).style.top = "35px";
  }
}
function SMLower(m){
  element = "SMSub" + m;
  if (m > 0){
    document.getElementById(element).style.visibility = "hidden";
  }
  
  if (m>0&&m<4) {
    //document.getElementById(element).style.top = "1000px";
  }
}

// Hide/Show Flyout Menus
function SMFlot(n) {
  element = "SMSub" + n;
  if (document.getElementById(element).style.visibility == "visible")
    {
      document.getElementById(element).style.visibility = "hidden";
      if (document.getElementById("flif")){
        document.getElementById("flif").style.display="none";
        document.getElementById("flif").style.visibility="hidden";
        document.getElementById("flif").style.width="1px";
        document.getElementById("flif").style.height="1px";
        document.getElementById("flif").style.left="-200px";
        document.getElementById("flif").style.bottom="0px";
      }
    }
  else
    { 
      if (osIsNix==1){
        if (n==4){
          document.getElementById("flif").style.width="146px";
          document.getElementById("flif").style.height="72px";
          document.getElementById("flif").style.left="395px";
          document.getElementById("flif").style.bottom="37px";
          document.getElementById("flif").style.display="block";
          document.getElementById("flif").style.visibility="visible";
        }
       if (n==5){
          document.getElementById("flif").style.width="129px";
          document.getElementById("flif").style.height="181px";
          document.getElementById("flif").style.left="395px";
          document.getElementById("flif").style.bottom="70px";
          document.getElementById("flif").style.display="block";
          document.getElementById("flif").style.visibility="visible";
        }
      }
      document.getElementById(element).style.visibility = "visible";
      FlyOutWasClicked = 1;
      FlyOutSum = FlyOutOpen + n;
      FlyOutOpen = n;
    } 
}

function molist(n) {
  element = "SMSub" + n;
  MOWasClicked = 1;
  if (document.getElementById(element).style.visibility == "visible")
    {
      document.getElementById(element).style.visibility = "hidden";
      document.getElementById(element).style.left="-200px";
      if (osIsNix==1){
        document.getElementById("moif").style.display="none";
        document.getElementById("moif").style.visibility="hidden";
        document.getElementById("moif").style.left = "-200px";
      }
      MOOpen = 0;
    }
  else
    { 
      document.getElementById(element).style.visibility = "visible";
      document.getElementById(element).style.left="705px";
      //window.alert("os is nix? = "+osIsNix);
if (osIsNix==1){
        document.getElementById("moif").style.display="block";
        document.getElementById("moif").style.visibility="visible";
        document.getElementById("moif").style.left = "705px";
      }
      MOOpen = n;
    }
}

function SMsHideAll() {
  document.getElementById("StartMenu").style.left = "-1000px";
  SMLower(1);SMLower(2);SMLower(3);
}
//Resize Sidebar to full document length, in pixels.
function sizeSidebar() {dh = document.getElementById("colwrap").scrollHeight;document.getElementById("sidebar").style.height=dh+"px";}

// Taskbar Menu Mouseovers
function mhov(id,mt) {
  mt = (mt*73) + 10 + qlm;
  tid = "hov" + id;
  lhovering = 1;
  clearTimeout(timer);
  if (MenuIsUp == 0){
    if (mhovIsUp == 0){
      mhtimer = setTimeout("raisemhov('"+mt+"')", 500);
    }
    else {
      temptid = tid;
      tid = mhovLastUp;
      lowermhov();
      tid = temptid;
      raisemhov(mt);
    }
  }
} 
function munhov(){
  lhovering = 0;
  if(typeof mhtimer !== "undefined"){clearTimeout(mhtimer);}
  timer = setTimeout ( "mhovkill()", 250 );
}
function mhovkill(){
  if (mhovering == 0 && lhovering == 0) {
    lowermhov();
  }
}
function raisemhov(mt){
  // if still over menu.
  if (lhovering==1){
    document.getElementById(tid).style.visibility = "visible";
    document.getElementById(tid).style.left = mt + "px";
    mhovLastUp = tid;
    mhovIsUp = 1;
    if (MOOpen > 0 && MOWasClicked!=1){
      molist(MOOpen);
      MOOpen=0;
    }
    if (osIsNix==1){
      document.getElementById("hovif").style.display="block";
      document.getElementById("hovif").style.visibility="visible";
      document.getElementById("hovif").style.left = mt + "px";
    }
  }
}
function lowermhov(){   
  if (tid){
    document.getElementById(tid).style.left = "-200px";
    if (osIsNix==1){
      document.getElementById("hovif").style.display="none";
      document.getElementById("hovif").style.visibility="hidden";
      document.getElementById("hovif").style.left = "-200px";
    }
    }
  mhovLastUp = 0;mhovIsUp = 0; 
}
function hovmhov(){mhovering = 1;}
function unhovmhov(){mhovering = 0;munhov();}

function InitIFrame(){
  if (osIsNix==1){
    document.getElementById("tbif").style.display="block";
    document.getElementById("tbif").style.visibility="visible";
  }
}

function getOS() {
  // This script sets OSName variable as follows:
  // "Windows"    for all versions of Windows
  // "MacOS"      for all versions of Macintosh OS
  // "Linux"      for all versions of Linux
  // "UNIX"       for all other UNIX flavors 
  // "Unknown OS" indicates failure to detect the OS
  if (navigator.appVersion.indexOf("Win")!=-1) osIsNix=0;
  if (navigator.appVersion.indexOf("Mac")!=-1) osIsNix=0;
  if (navigator.appVersion.indexOf("X11")!=-1) osIsNix=1;
  if (navigator.appVersion.indexOf("Linux")!=-1) osIsNix=1;
}
//Initfuncts on pg load
function InitPage() {getOS();InitIFrame();SearchBoxBlur();updateClock();setInterval('updateClock()', 5000 );StartThrob();SMsHideAll();sizeSidebar();}

function AddOnload(myfunc)
  {
    if(window.addEventListener)
    window.addEventListener('load', myfunc, false);
    else if(window.attachEvent)
    window.attachEvent('onload', myfunc);
  }

AddOnload(InitPage);