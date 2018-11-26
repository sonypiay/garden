<template lang="html">
<div class="uk-margin-top">
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <div v-if="errors.error" class="uk-alert-danger uk-margin-bottom" uk-alert>
      {{ errors.error }}
    </div>
    <h3 class="content_headingsettingprofile">Edit Sandi</h3>
    <form class="uk-form-stacked" @submit.prevent="changePassword">
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="password" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.password" placeholder="Sandi Baru">
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="password" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.confirmpassword" placeholder="Konfirmasi Sandi">
        </div>
      </div>
      <div class="uk-margin">
        <button class="uk-button uk-button-default btn_settingaction" v-html="btnsave">Ubah Sandi</button>
      </div>
    </form>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'customers'],
  data() {
    return {
      forms: {
        password: '',
        confirmpassword: ''
      },
      errors: {},
      btnsave: 'Ubah Sandi'
    }
  },
  methods: {
    changePassword()
    {
      this.errors = {};
      if( this.forms.password === '' )
      {
        this.errors.error = 'Kata sandi wajib diisi';
      }
      else if( this.forms.confirmpassword === '' )
      {
        this.errors.error = 'Konfirmasi sandi wajib diisi';
      }
      else if( this.forms.password !== this.forms.confirmpassword )
      {
        this.errors.error = 'Konfirmasi kata sandi tidak sesuai.';
      }
      else
      {
        if( this.contentLength( this.forms.password ) < 8 )
        {
          this.errors.error = 'Kata sandi minimal 8 huruf';
        }
        else
        {
          this.btnsave = '<span uk-spinner></span>';
          axios({
            method: 'put',
            url: this.url + '/customers/account/change_password',
            headers: { 'Content-Type': 'application/json' },
            params: {
              password: this.forms.password
            }
          }).then( res => {
            this.errors = {};
            swal({
              title: 'Berhasil',
              text: 'Kata sandi berhasil diubah',
              icon: 'success',
              timer: 5000
            });
            this.forms.password = '';
            this.forms.confirmpassword = '';
          }).catch( err => {
            if( err.response.status === 422 )
            {
              this.errors.error = err.response.data.statusText;
            }
            else
            {
              this.errors.error = err.response.statusText;
            }
          });
          this.btnsave = 'Ubah Sandi';
        }
      }
    },
    contentLength: function(str)
    {
      return str.length;
    }
  }
}
</script>
