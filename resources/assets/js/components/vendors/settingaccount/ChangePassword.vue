<template lang="html">
  <div class="uk-margin-top">
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Ubah Sandi</h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-action" @submit.prevent="onUpdateAccount">
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Sandi Baru</label>
          <div class="uk-form-controls">
            <input type="password" placeholder="Minimal 8 karakter" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.password">
          </div>
          <div v-if="errors.password" class="uk-text-danger uk-text-small">{{ errors.password }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Konfirmasi Sandi</label>
          <div class="uk-form-controls">
            <input type="password" placeholder="Konfirmas Sandi" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.confirmpassword">
          </div>
          <div v-if="errors.confirmpassword" class="uk-text-danger uk-text-small">{{ errors.confirmpassword }}</div>
        </div>
        <div class="uk-margin">
          <button v-html="forms.submit" class="uk-button uk-button-default btn_settingaction">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        password: '',
        confirmpassword: '',
        error: false,
        submit: 'Ubah Data'
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    onUpdateAccount()
    {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = 'Kata sandi wajib diisi';
      }
      if( this.forms.confirmpassword === '' )
      {
        this.forms.error = true;
        this.errors.confirmpassword = 'Konfirmasi sandi wajib diisi.';
      }
      if( this.lengthPassword( this.forms.password ) < 8 )
      {
        this.forms.error = true;
        this.errorMessage = 'Kata sandi minimal 8 karakter.';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }

      if( this.forms.confirmpassword !== this.forms.password )
      {
        this.errorMessage = 'Konfirmasi sandi tidak sesuai.';
        return false;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/vendor/account/change_password',
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          password: this.forms.password
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errors = {};
        this.errorMessage = '';
      }).catch( err => {
        this.errorMessage = err.response.statusText;
        swal({
          title: 'Terjadi kesalahan',
          text: err.response.status + ' ' + err.response.statusText,
          icon: 'error',
          timer: 5000,
          dangerMode: true
        });
      });
      this.forms.submit = 'Ubah Data';
    },
    lengthPassword: function( s )
    {
      return s.length;
    }
  }
}
</script>
