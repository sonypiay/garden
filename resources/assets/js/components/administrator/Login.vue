<template>
<div class="uk-container uk-margin-large-top login-section">
  <div class="uk-width-2-3@xl uk-width-2-3@l uk-width-2-3@m uk-width-1-2@s uk-margin-large-top uk-align-center">
    <div class="uk-hidden@m uk-text-center"><img class="uk-width-1-2" v-bind:src="url + '/images/logobrand/gplogo-green.png'" /></div>
    <div class="uk-grid-small uk-grid-collapse uk-grid-match" uk-grid>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-visible@m uk-visible@s">
        <div class="uk-tile uk-tile-default uk-padding-large logo-container">
          <div class="uk-position-center">
            <img class="logo-login uk-border-circle" v-bind:src="url + '/images/logobrand/gplogo-white.png'" />
          </div>
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-card uk-card-body uk-card-default login-container">
          <h2 class="uk-card-title uk-text-center">Login</h2>
          <form class="uk-form-stacked" @submit.prevent="doLogin">
            <div class="uk-margin">
              <div v-if="errors.username">
                <div class="uk-alert-warning" uk-alert>{{ errors['username'] }}</div>
              </div>
              <label class="uk-form-label label-login">Username</label>
              <div class="uk-form-controls">
                <input type="text" v-model="username" class="uk-input input-login" placeholder="" />
              </div>
            </div>
            <div class="uk-margin">
              <div v-if="errors.password">
                <div class="uk-alert-warning" uk-alert>{{ errors.password }}</div>
              </div>
              <label class="uk-form-label label-login">Password</label>
              <div class="uk-form-controls">
                <input type="password" v-model="password" class="uk-input input-login" placeholder="" />
              </div>
            </div>
            <div class="uk-margin">
              <button v-html="signinLoading" class="uk-width-1-1 uk-button uk-button-default button-login">Sign In</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        props: ['url'],
        data() {
          return {
            username: '',
            password: '',
            iserror: false,
            errors: {},
            signinLoading: 'Sign In'
          }
        },
        methods: {
          doLogin() {
            this.errors = {};
            if( this.username === '' )
            {
              this.errors.username = 'Silahkan masukkan username.';
              this.iserror = true;
            }

            if( this.password === '' )
            {
              this.errors.password = 'Silahkan masukkan password';
              this.iserror = true;
            }
            if( this.iserror === true ) return false;
            this.signinLoading = '<span uk-spinner></span>';
            axios({
              url: this.url + '/cp/login',
              method: 'post',
              headers: {
                'Content-Type': 'application/json'
              },
              params: {
                username: this.username,
                password: this.password
              }
            }).then(res => {
              let result = res.data;
              if( result.status === 200 )
              {
                swal({
                  title: 'Login berhasil',
                  text: 'Redirecting...',
                  icon: 'success'
                });
                setTimeout(function(){ document.location= ''; }, 3000);
              }
            }).catch(err => {
              let status = err.response.status;
              let message = err.response.data;
              if( status === 422 )
              {
                swal({
                  title: 'Pesan Error',
                  text: message.statusText,
                  icon: 'warning',
                  dangerMode: true
                });
              }
              this.signinLoading = 'Log in';
            });
          }
        }
    }
</script>
