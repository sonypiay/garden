<template lang="html">
  <div class="uk-margin-top">
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Ubah Email</h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-action" @submit.prevent="onUpdateAccount">
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Email</label>
          <div class="uk-form-controls">
            <input type="email" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.email">
          </div>
          <div v-if="errors.email" class="uk-text-danger uk-text-small">{{ errors.email }}</div>
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
  props: ['url', 'vendors'],
  data() {
    return {
      forms: {
        email: this.vendors,
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
      if( this.vendors.email === '' )
      {
        this.forms.error = true;
        this.errors.email = 'Email wajib diisi.';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/vendor/account/edit_email',
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          email: this.vendors.email
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
        setTimeout(function() { document.location=''; }, 3000);
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
    }
  }
}
</script>
