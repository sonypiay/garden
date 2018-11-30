<template lang="html">
<div class="uk-container uk-margin-top">
  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
    <!--<a :href="url"><img :src="url + '/images/logobrand/gplogo-white.png'" class="customers-loginlogo uk-align-center" alt="Garden Buana"></a>-->
    <div class="uk-margin-large-top uk-card uk-card-body uk-card-default customers-logincontainer">
      <h3 class="uk-text-center customers-loginheading">Masuk Pengguna</h3>
      <div class="uk-text-center customers-loginlead">Belum punya akun? <a :href="url + '/customers/register'">Daftar sekarang</a> </div>
      <span v-if="errors.errorMessage">
        <div class="uk-margin-bottom uk-margin-top uk-alert-danger" uk-alert>{{ errors.errorMessage }}</div>
      </span>
      <form class="uk-form-stacked" @submit.prevent="doLogin">
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="user"></span>
              <input type="email" v-model="forms.email" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Alamat Email">
            </div>
            <div v-if="errors.email" class="uk-text-small uk-text-danger">{{ errors.email }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div class="uk-width-1-1 uk-inline">
              <span class="uk-form-icon" uk-icon="lock"></span>
              <input type="password" v-model="forms.password" class="uk-width-1-1 uk-input customers-formlogin" placeholder="Kata Sandi">
            </div>
            <div v-if="errors.password" class="uk-text-small uk-text-danger">{{ errors.password }}</div>
          </div>
        </div>
        <div class="uk-margin">
          <button v-html="btnlogin" class="uk-width-1-1 uk-button customers-btnlogin">Masuk</button>
        </div>
        <div class="uk-margin">
          <a href="#" class="uk-float-right lupapassword">Lupa Kata Sandi?</a>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      btnlogin: 'Masuk',
      errors: {},
      forms: {
        email: '',
        password: '',
        error: false
      }
    }
  },
  methods: {
    doLogin()
    {
      this.errors = {};
      if( this.forms.email === '' )
      {
        this.forms.error = true;
        this.errors.email = 'Silahkan masukkan alamat email Anda.';
      }

      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = 'Silahkan masukkan kata sandi Anda.';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }
      this.btnlogin = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + '/customers/doLogin',
        headers: { 'Content-Type': 'application/json' },
        params: {
          email: this.forms.email,
          password: this.forms.password
        }
      })
      .then( res => {
        this.errors.errorMessage = '';
        var redirect = this.url + '/customers/account';
        setTimeout(function(){ document.location = redirect; }, 3000);
        console.log(res.data);
      })
      .catch( err => {
        let statusResponse = err.response.status;
        if( statusResponse === 401 )
        {
          this.errors.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errors.errorMessage = err.response.statusText;
        }
        this.btnlogin = 'Masuk';
      });
    }
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
