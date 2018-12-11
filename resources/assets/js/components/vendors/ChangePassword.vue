<template lang="html">
<div class="uk-container">
  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
    <div class="uk-card uk-card-body uk-card-default forgotpassword-container">
      <h2 class="uk-text-center uk-margin-bottom">Ganti Kata Sandi</h2>
      <span v-if="errorMessage">
        <div class="uk-margin-bottom uk-margin-top uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      </span>
      <form class="uk-form-stacked" @submit.prevent="onCheckEmail">
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <input type="password" v-model="forms.password" class="uk-width-1-1 uk-input forgotpassword_form" placeholder="Kata sandi baru">
            </div>
            <div v-if="errors.password" class="uk-text-danger uk-text-small">{{ errors.password }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <input type="password" v-model="forms.confirmpassword" class="uk-width-1-1 uk-input forgotpassword_form" placeholder="Ketik ulang kata sandi">
            </div>
            <div v-if="errors.confirmpassword" class="uk-text-danger uk-text-small">{{ errors.confirmpassword }}</div>
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
      errorMessage: '',
      btnsubmit: 'Reset',
      forms: {
        password: '',
        confirmpassword: '',
        error: false
      }
    }
  },
  methods: {
    onCheckEmail() {
      this.errors = {};

      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = 'Masukkan kata sandi baru Anda';
      }

      if( this.forms.confirmpassword === '' )
      {
        this.forms.error = true;
        this.errors.confirmpassword = 'Ketik ulang kata sandi Anda.';
      }

      if( this.forms.error === true ) {
        this.forms.error = false;
        return false;
      }

      if( this.lengthPassword( this.forms.password ) < 8 && this.lengthPassword( this.forms.confirmpassword ) < 8 )
      {
        this.errorMessage = 'Kata sandi minimal 8 karakter';
      }
      else if( this.forms.password !== this.forms.confirmpassword )
      {
        this.errorMessage = 'Kata sandi tidak sesuai';
      }
      else
      {
        this.btnsubmit = '<span uk-spinner></span>';
        axios({
          method: 'put',
          url: this.url + '/vendor/reset_password',
          headers: { 'Content-Type': 'application/json' },
          params: {
            password: this.forms.password
          }
        })
        .then( res => {
          this.errorMessage = '';
          var redirect = this.url + '/';
          swal({
            title: 'Berhasil',
            text: 'Kata sandi berhasil direset.',
            icon: 'success',
            timer: 3000
          });
          setTimeout(function(){ document.location = redirect; }, 3000);
        })
        .catch( err => {
          let status = err.response.status;
          if( status === 401 )
          {
            this.errorMessage = err.response.data.statusText;
          }
          else
          {
            this.errorMessage = err.response.statusText;
          }
          this.btnsubmit = 'Reset';
        });
      }
    },
    lengthPassword: function( s )
    {
      return s.length;
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
