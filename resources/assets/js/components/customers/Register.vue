<template lang="html">
<div class="uk-container uk-margin-top uk-margin-large-bottom">
  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
    <img :src="url + '/images/logobrand/gplogo-white.png'" class="customers-loginlogo uk-align-center" alt="Garden Buana">
    <div class="uk-card uk-card-body uk-card-default customers-logincontainer">
      <span v-if="errors.errorMessage">
        <div class="uk-margin-bottom uk-margin-top uk-alert-danger" uk-alert>{{ errors.errorMessage }}</div>
      </span>
      <form class="uk-form-stacked" @submit.prevent="doRegister">
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="user"></span>
              <input type="text" v-model="forms.fullname" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Nama Lengkap">
            </div>
            <div v-if="errors.fullname" class="uk-text-danger uk-text-small">{{ errors.fullname }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="mail"></span>
              <input type="email" v-model="forms.email" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Email">
            </div>
            <div v-if="errors.email" class="uk-text-danger uk-text-small">{{ errors.email }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="receiver"></span>
              <input type="text" v-model="forms.notelepon" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Nomor Telepon">
            </div>
            <div v-if="errors.notelepon" class="uk-text-danger uk-text-small">{{ errors.notelepon }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="lock"></span>
              <input type="password" v-model="forms.password" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Sandi">
            </div>
            <div v-if="errors.password" class="uk-text-danger uk-text-small">{{ errors.password }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <button v-html="btnsubmit" class="uk-width-1-1 uk-button customers-btnlogin">Daftar</button>
        </div>
      </form>
      <div class="uk-text-center customers-loginlead">Sudah punya akun? <a :href="url + '/customers/login'">Masuk Disini</a></div>
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
      btnsubmit: 'Daftar',
      forms: {
        notelepon: '',
        password: '',
        email: '',
        fullname: '',
        error: false
      }
    }
  },
  methods: {
    doRegister() {
      this.errors = {};
      if( this.forms.fullname === '' )
      {
        this.forms.error = true;
        this.errors.fullname = 'Nama lengkap wajib diisi';
      }

      if( this.forms.email === '' )
      {
        this.forms.error = true;
        this.errors.email = 'Email wajib diisi';
      }

      if( this.forms.notelepon === '' )
      {
        this.forms.error = true;
        this.errors.notelepon = 'Nomor telepon wajib diisi';
      }

      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = 'Sandi wajib diisi';
      }

      if( this.forms.error === true ) {
        this.forms.error = false;
        return false;
      }

      if( this.countLength( this.forms.password ) < 8 )
      {
        this.errors.password = 'Sandi minimal 8 karakter';
      }
      else
      {
        this.btnsubmit = '<span uk-spinner></span>';
        axios({
          method: 'post',
          url: this.url + '/customers/doRegister',
          headers: { 'Content-Type': 'application/json' },
          params: {
            fullname: this.forms.fullname,
            email: this.forms.email,
            telepon: this.forms.notelepon,
            password: this.forms.password
          }
        })
        .then( res => {
          swal({
            title: 'Berhasil',
            text: res.data.statusText,
            icon: 'success',
            timer: 3000
          });
          this.errors.errorMessage = '';
          var redirect = this.url + '/customers/account';
          setTimeout(function(){ document.location = redirect; }, 3000);
        })
        .catch( err => {
          let status = err.response.status;
          if( status === 422 )
          {
            this.errors.errorMessage = err.response.data.statusText;
          }
          else
          {
            this.errors.errorMessage = err.response.statusText;
          }
          this.btnsubmit = 'Daftar';
        });
      }
    },
    countLength: function(str) { return str.length; }
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
