<template lang="html">
<div>
  <section class="cover-joinasvendor"></section>
  <div class="uk-container">
    <div class="uk-width-3-4 uk-align-center container-joinasvendor">
      <div class="uk-margin-bottom slugtext-joinasvendor">Bergabung dengan Mitra kami di seluruh Nusantara Indonesia</div>
      <div class="uk-card uk-card-default uk-card-body sectioncontainer-joinasvendor">
        <!--<h3 class="sectionheading-joinasvendor">Pendaftaran Vendor</h3>-->
        <div class="uk-padding uk-margin-bottom sectionbox-joinasvendor">
          <div>Kami perlu tahu tentang diri Anda</div>
          <span>Silahkan lengkapi formulir dengan informasi yang valid. Informasi ini tidak akan muncul di profil Anda</span>
        </div>
        <form class="uk-form-stacked">
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nama Anda *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nomor Ponsel Anda *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nomor Telepon Bisnis *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Alamat Email *</label>
            <div class="uk-form-controls">
              <input type="email" class="uk-width-1-1 uk-input form-joinasvendor">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nama Jasa/Vendor *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor">
            </div>
          </div>
          <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-default button-joinasvendor">Daftar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {}
  },
  mounted() {}
}
</script>
