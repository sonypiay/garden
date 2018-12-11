<template lang="html">
  <div class="uk-container uk-margin-large-top">
    <div class="uk-tile uk-tile-default signup_login">
      <div class="uk-grid-large uk-grid-match" uk-grid>
        <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
          <a :href="url + '/vendor/login'" class="uk-display-block uk-tile uk-tile-default signup_login_container">
            <!--<div class="uk-card-title signup_login_heading">Masuk Sebagai Vendor</div>-->
            <div class="signup_login_icon">
              <span class="fas fa-users"></span>
            </div>
            <div class="signup_login_text">Masuk Sebagai Vendor</div>
          </a>
        </div>
        <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
          <a :href="url + '/customers/login'" class="uk-display-block uk-tile uk-tile-default signup_login_container">
            <!--<div class="uk-card-title signup_login_heading">Masuk Sebagai Pelanggan</div>-->
            <div class="signup_login_icon">
              <span class="fas fa-user-circle"></span>
            </div>
            <div class="signup_login_text">Masuk Sebagai Pelanggan</div>
          </a>
        </div>
      </div>
      <div class="uk-text-center">
        <a class="uk-button uk-button-default uk-button-large signup_login_backtohome" :href="url + '/'">Kembali ke Halaman Utama</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url']
}
</script>

<style lang="css">
html, body {
  background: linear-gradient(108deg,
  rgba(246,161,146,1),
  rgba(246,176,146,1)) !important;
}
</style>
