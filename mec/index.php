<?php
require('../../config.php');

$cid = optional_param('cid', 0, PARAM_INT);

switch ($cid) {
  case 1:
    $bgimg = 'bkg_1.jpg';
    break;
  case 2:
    $bgimg = 'bkg_2.jpg';
    break;
  case 3:
    $bgimg = 'bkg_3.jpg';
    break;
  case 4:
    $bgimg = 'bkg_4.jpg';
    break;
  case 5:
    $bgimg = 'bkg_5.jpg';
    break;
  case 6:
    $bgimg = 'bkg_6.jpg';
    break;
  default:
    $bgimg = 'bkg_1.jpg';
}

//require('/moodle_root/public/config.php');
require_once($CFG->libdir . '/authlib.php');
$authsequence = get_enabled_auth_plugins(true);
$identityproviders = \auth_plugin_base::get_identity_providers($authsequence);
foreach($identityproviders as $identityprovider){
    if ($identityprovider['name'] == 'Clever'){
        $cleverurl = $identityprovider['url'];
        $clevericonurl = $identityprovider['iconurl'];
    } elseif ($identityprovider['name'] == 'Microsoft') {
        $microsofturl = $identityprovider['url'];
        $microsofticonurl = $identityprovider['iconurl'];
    } elseif ($identityprovider['name'] == 'Google') {
        $googleurl = $identityprovider['url'];
        $googleiconurl = $identityprovider['iconurl'];

    } elseif ($identityprovider['name'] == 'ClassLink OAuth2') {
        //add an icon for classlink
        if (!empty($identityprovider['icon'])) {
            // Pre-3.3 auth plugins provide icon as a pix_icon instance. New auth plugins (since 3.3) provide iconurl.
            $identityprovider['iconurl'] = $OUTPUT->image_url($identityprovider['icon']->pix, $identityprovider['icon']->component);
        }
        if ($identityprovider['iconurl'] instanceof moodle_url) {
            $identityprovider['iconurl'] = $identityprovider['iconurl']->out(false);
        }
        unset($identityprovider['icon']);
        if ($identityprovider['url'] instanceof moodle_url) {
            $identityprovider['url'] = $identityprovider['url']->out(false);
        }
        $classlinkurl = $identityprovider['url'];
        $classlinkiconurl = $identityprovider['iconurl'];
    }
}

$logintoken='<input type="hidden" name="logintoken" value="'.\core\session\manager::get_login_token().'" />';


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style type="text/css">
body{
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
}
#bg{
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	display:block; /*!*/
	position:absolute;
	z-index:1;
}
p, h1, form, button{
	border:0;
	margin:0;
	padding:0;
}
.spacer{clear:both; height:10px;}
/* ----------- My Form ----------- */
.myform{
	margin:0 auto;
	width:400px;
	padding:14px;
	position: relative;
	top: 160px;
	z-index:5;
}

/* ----------- stylized ----------- */
#stylized{
	border:7px solid #666;
	-moz-border-radius: 15px;
	border-radius: 15px;
	background-color: #ebf4fb;
}
#stylized h1 {
font-size:16px;
font-weight:bold;
margin-bottom:8px;
}
#stylized p{
font-size:11px;
color:#666666;
margin-bottom:20px;
border-bottom:solid 1px #b7ddf2;
padding-bottom:10px;
}
#stylized label{
display:block;
font-weight:bold;
text-align:right;
width:140px;
float:left;
}
#stylized .small{
color:#666666;
display:block;
font-size:11px;
font-weight:normal;
text-align:right;
width:140px;
}
#stylized input{
float:left;
font-size:13px;
padding:5px 3px;
border:solid 1px #aacfe4;
width:200px;
margin:2px 0 20px 10px;
}
#stylized button{
clear:both;
width:150px;
height:35px;
background:url(button.png) no-repeat;
text-align:center;
line-height:31px;
color:#FFFFFF;
font-size:20px;
}

#dps {
	position: absolute;
	z-index: 5;
	left: 5px;
	top: 32px;
	font-size: 18px;
	font-weight: bold;
	padding: 5px;
}
.meclearn-logo {
  z-index: 1;
  position: absolute;
}
.sso-button {
  clear: both;
  margin-left: 130px;
  width: 150px;
  height: 35px;
  background-color: grey;
  text-align: center;
  line-height: 31px;
  color: #FFFFFF;
  font-size: 22px;
  padding: 5px 22px 5px;
  border: 2px solid darkgrey;
  border-radius: 5px;
}
a.sso-button {
  text-decoration: none;
}
.login-heading {
  margin-top: -16px;
  margin-bottom: 22px;
}
img {
  vertical-align: middle;
}
#form {
  margin-top: -15px;
}
center {
  margin-top: -15px;
}
</style>
<style>
/* Media query for small devices */
@media only screen and (max-width: 767px) {
  #stylized {
		width: 90%;
		padding: 10px;
    top: 140px;
	}

	#stylized label,
	#stylized .small {
		width: 100%;
		float: none;
		text-align: left;
	}

	#stylized input {
		width: 100%;
		margin: 2px 0 10px 0;
	}

	#stylized button {
		margin: auto;
		width:;
	}

	#dps {
		position: static;
		display: block;
		margin-top: 10px;
	}

	.meclearn-logo {
		osition: static;
		display: block;
    width: 200px;
	}

	.sso-button {
		margin-left: 0;
		width: 100%;
		padding: 5px;
	}
}
</style>
</head>

<body>
<?php
if ($cid === 0 || $cid == 1) {
?>
<div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
    <?php echo $logintoken ?>
    <!--<div id="dps">Choo Smith Youth Empowerment - CommuniVersity</div>-->
<label>UserName
<span class="small">Enter your Username</span>
</label>
<input type="text" name="username" id="name" />

<label>Password
<span class="small">Enter Your Password</span>
</label>
<input type="password" name="password" id="password" />

<center><button type="submit">Login</button></center>
<div class="spacer"></div>

</form>
</div>
</div>
<?php } else if ($cid == 2){?> 
  <div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
<!--<div id="dps">School A</div>-->

<center><h2 class="login-heading">Log in using your account</h2></center>
  <a class="sso-button" href="<?php echo $cleverurl;?>">                
    <img src="<?php echo $clevericonurl;?>" alt="" width="26" height="26"/>
    Clever
  </a>
<div class="spacer"></div>

<?php } else if ($cid == 3){?> 
  <div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
<!--<div id="dps">School A</div>-->

<center><h2 class="login-heading">Log in using your account</h2></center>
  <a class="sso-button" href="<?php echo $classlinkurl;?>">                
    <img src="<?php echo $classlinkiconurl;?>" alt="" width="26" height="26"/>
    ClassLink
  </a>
<div class="spacer"></div>
<?php } else if ($cid == 4){?>
  <div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
<!--<div id="dps">School A</div>-->

<center><h2 class="login-heading">Log in using your account</h2></center>
  <a class="sso-button" href="<?php echo $googleurl;?>">                
    <img src="<?php echo $googleiconurl;?>" alt="" width="26" height="26"/>
    Google
  </a>
<div class="spacer"></div>
<?php } else if ($cid == 5){?>
  <div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
<!--<div id="dps">School A</div>-->

<center><h2 class="login-heading">Log in using your account</h2></center>
  <a class="sso-button" href="<?php echo $classlinkurl;?>">                
    <img src="<?php echo $classlinkiconurl;?>" alt="" width="26" height="26"/>
    ClassLink
  </a>
<div class="spacer"></div>
<?php } else if ($cid == 6){?>
  <div class="main-content">
<img id="bg" src="<?php echo $bgimg ?>" />

<img class="meclearn-logo" src="logo.png" height="115px" alt="iLearn 2.0" />
<div id="stylized" class="myform">

<center><img src="youth.png" height="200px" width="250px" alt="iLearn 2.0" /></center>
  <form id="form" name="form" method="post" action="https://dev3-moodle41-node1.mec-edu.net/login/index.php">
<!--<div id="dps">School A</div>-->

<center><h2 class="login-heading">Log in using your account</h2></center>
  <a class="sso-button" href="<?php echo $classlinkurl;?>">                
    <img src="<?php echo $classlinkiconurl;?>" alt="" width="26" height="26"/>
    ClassLink
  </a>
<div class="spacer"></div>
<?php } ?>
</body>
</html>
