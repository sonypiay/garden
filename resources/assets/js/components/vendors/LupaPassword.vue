<template lang="html">
<div class="uk-container">
  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
    <div class="uk-card uk-card-body uk-card-default forgotpassword-container">
      <h2 class="uk-text-center uk-margin-bottom">Lupa Password</h2>
      <span v-if="errors.errorMessage">
        <div class="uk-margin-bottom uk-margin-top uk-alert-danger" uk-alert>{{ errors.errorMessage }}</div>
      </span>
      <form class="uk-form-stacked" @submit.prevent="onCheckEmail">
        <div class="uk-margin">
          <label class="forgotpassword_label">Masukan E-mail anda untuk mendapatkan password baru:</label>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="mail"></span>
              <input type="email" v-model="forms.email" class="uk-width-1-1 uk-input forgotpassword_form" placeholder="Email">
            </div>
            <div v-if="errors.email" class="uk-text-danger uk-text-small">{{ errors.email }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <button v-html="btnsubmit" class="uk-width-1-1 uk-button uk-button-default forgotpassword_btn">Verifikasi</button>
        </div>
      </form>
      <div class="uk-text-center homepage"><a :href="url + '/'">Kembali ke Halaman Utama</a></div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      errors: '',
      btnsubmit: 'Verifikasi',
      forms: {
        email: '',
        error: false
      }
    }
  },
  methods: {
    onCheckEmail() {
      this.errors = {};

      if( this.forms.email === '' )
      {
        this.forms.error = true;
        this.errors.email = 'Email wajib diisi';
      }

      if( this.forms.error === true ) {
        this.forms.error = false;
        return false;
      }

      this.btnsubmit = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + '/vendor/checkemail',
        headers: { 'Content-Type': 'application/json' },
        params: {
          email: this.forms.email
        }
      })
      .then( res => {
        this.errors.errorMessage = '';
        var redirect = this.url + '/vendor/change_password';
        setTimeout(function(){ document.location = redirect; }, 3000);
      })
      .catch( err => {
        let status = err.response.status;
        if( status === 401 )
        {
          this.errors.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errors.errorMessage = err.response.statusText;
        }
        this.btnsubmit = 'Verifikasi';
      });
    }
  },
  mounted() {
  }
}
</script>

<style lang="css">
html, body {
  background: linear-gradient(108deg,
  rgba(246,161,146,1),
  rgba(246,176,146,1)) !important;
}
</style>
