<?php
/**
 * Plugin Name: HippoChat
 * Plugin URI: https://hippochat.io
 * Description: Capture, Convert & Retain more customers using Real-Time Chat platform
 * Version: 2.1
 * Author: JungleWorks
 * Author URI: https://jungleworks.com
 * License: GPL
 * License URI: https://www.gnu.org/licenses/gpl.html
 */

if(!defined('ABSPATH'))
{
die;
}
add_action('admin_menu','hippochat_admin_menu');
function hippochat_admin_menu(){
  add_menu_page('Header and Footer Data - HippoChat','HippoChat','manage_options','hippo-admin-menu','hippochat_overview',plugin_dir_url( __FILE__ ) .'assets/group-2.png',200); //adding plugin to admin page
  add_action( 'admin_init', 'register_hippochatsettings' );
}

function register_hippochatsettings() {
  register_setting( 'hippochat-group', 'hippochat_code_source' );
  register_setting( 'hippochat-group', 'hippochat_code_secret' );
 }

 function hippochat_overview() { ?>
  <div class="wrap">
<?php
  if(get_option('hippochat_code_source') == '' || get_option('hippochat_code_secret') == '')
  {
    echo "<h1>Please add input values in the boxes below</h1>
    <p>Note:- Please do not repeat the code you are adding in the Input Box.
    </p>";
  }
  
  else
  {
    echo '<h4>Settings Have Been Saved.</h4>';
  }

  if(isset($_POST['hippochat_code_radio']))
  {
    if($_POST['hippochat_code_radio']=="hippochat_code_radio_one")
    {
      add_action('wp_head', 'echohippochatcode_head');
    }
    if($_POST['hippochat_code_radio']=="hippochat_code_radio_two")
    {
      add_action('wp_footer', 'echohippochatcode_foot');
    }
  }
?>
      <form method="post" action="options.php" <?php echo "wp_nonce_field('update-options');" ?> >
          <?php settings_fields( 'hippochat-group' ); ?>
          <br>
          <h2>Script Source </h2>
          <input style="height: 38px;width: 500px;" type="text" name="hippochat_code_source" id="hippochat_code_source" placeholder="Enter Script Source" value="<?php echo get_option('hippochat_code_source'); ?>"/><br><br>
          <h2>App Secret </h2>
          <input style="height: 38px;width: 500px;" type="text" name="hippochat_code_secret" id="hippochat_code_secret" placeholder="Enter App Secret Key" value="<?php echo get_option('hippochat_code_secret'); ?>"/><br><br>
          <input type="radio" name="hippochat_code_radio" value="hippochat_code_radio_one" checked>Header
          <input type="radio" name="hippochat_code_radio" value="hippochat_code_radio_two">Footer
          <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
          </p>
      </form>
  </div>
  
  <?php }
  
  function echohippochatcode_head() 
  {
      $hippochat_sanitize_code_source = sanitize_text_field( get_option("hippochat_code_source") );
      $hippochat_esc_code_source = esc_html( $hippochat_sanitize_code_source );
      $hippochat_sanitize_code_secret = sanitize_text_field( get_option("hippochat_code_secret") );
      $hippochat_esc_code_secret = esc_html( $hippochat_sanitize_code_secret );
      $hippochat_final_code='<script src="'.$hippochat_esc_code_source.'"></script><script>window.fuguInit({appSecretKey: "'.$hippochat_esc_code_secret.'"});</script>';
      echo $hippochat_final_code;
  }
  add_action('wp_head', 'echohippochatcode_head');
  
  function echohippochatcode_foot() 
  {
    $hippochat_sanitize_code_source = sanitize_text_field( get_option("hippochat_code_source") );
    $hippochat_esc_code_source = esc_html( $hippochat_sanitize_code_source );
    $hippochat_sanitize_code_secret = sanitize_text_field( get_option("hippochat_code_secret") );
    $hippochat_esc_code_secret = esc_html( $hippochat_sanitize_code_secret );
    $hippochat_final_code='<script src="'.$hippochat_esc_code_source.'"></script><script>window.fuguInit({appSecretKey: "'.$hippochat_esc_code_secret.'"});</script>';
    echo $hippochat_final_code;
  }
  add_action('wp_footer', 'echohippochatcode_foot');
  
  ?>