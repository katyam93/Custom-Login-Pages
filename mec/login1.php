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

?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bootstrap 5 - Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
</head>
<style>
:root{
  --main-bg:#e91e63;
}

.main-bg {
  background: var(--main-bg) !important;
}

input:focus, button:focus {
  border: 1px solid var(--main-bg) !important;
  box-shadow: none !important;
}

.form-check-input:checked {
  background-color: var(--main-bg) !important;
  border-color: var(--main-bg) !important;
}

.card, .btn, input{
  border-radius:0 !important;
}
</style>

<body>
<?php if ($cid == 1) {?>    
<!-- Login Form -->
  <div class="main-content">
  <img id="bg" src="<?php echo $bgimg ?>" />
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Login</h2>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-4">
                <label for="username" class="form-label">Username/Email</label>
                <input type="text" class="form-control" id="username" />
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" />
              </div>
              <div class="mb-4">
                <input type="checkbox" class="form-check-input" id="remember" />
                <label for="remember" class="form-label">Remember Me</label>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn text-light main-bg">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</body>
</html>
