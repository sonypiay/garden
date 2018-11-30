<template lang="html">
  <div class="uk-margin-top">
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Telepon</h3>
      <form class="uk-form-action" @submit.prevent="onUpdateMobilePrivate">
        <div v-if="errorMessageMobilePrivate" class="uk-alert-danger" uk-alert>{{ errorMessageMobilePrivate }}</div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nomor Ponsel Anda</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.mobile_private">
          </div>
          <div v-if="errors.mobile_private" class="uk-text-danger uk-text-small">{{ errors.mobile_private }}</div>
        </div>
        <div class="uk-margin">
          <button v-html="forms.submitMobilePrivate" class="uk-button uk-button-default btn_settingaction">Simpan</button>
        </div>
      </form>
      <hr>
      <form class="uk-form-action" @submit.prevent="onUpdateMobileBusiness">
        <div v-if="errorMessageMobileBusiness" class="uk-alert-danger" uk-alert>{{ errorMessageMobileBusiness }}</div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nomor Telepon Bisnis</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.mobile_business">
          </div>
          <div v-if="errors.mobile_business" class="uk-text-danger uk-text-small">{{ errors.mobile_business }}</div>
        </div>
        <div class="uk-margin">
          <button v-html="forms.submitMobileBusiness" class="uk-button uk-button-default btn_settingaction">Simpan</button>
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
        error: false,
        submitMobilePrivate: 'Simpan',
        submitMobileBusiness: 'Simpan'
      },
      errors: {},
      errorMessageMobilePrivate: '',
      errorMessageMobileBusiness: ''
    }
  },
  methods: {
    onUpdateMobilePrivate()
    {
      this.errors = {};
      this.errorMessageMobilePrivate = '';
      if( this.vendors.mobile_private === '' )
      {
        this.forms.error = true;
        this.errors.mobile_private = 'Nomor ponsel wajib diisi';
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }

      this.forms.submitMobilePrivate = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/vendor/account/edit_mobileprivate',
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          mobile_private: this.vendors.mobile_private
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errors = {};
        this.errorMessageMobilePrivate = '';
        setTimeout(function() { document.location=''; }, 3000);
      }).catch( err => {
        let status = err.response.status;
        if( status === 409 )
        {
          this.errorMessageMobilePrivate = err.response.data.statusText;
          swal({
            title: 'Terjadi kesalahan',
            text: err.response.data.statusText,
            icon: 'warning',
            timer: 5000,
            dangerMode: true
          });
        }
        else
        {
          this.errorMessageMobilePrivate = err.response.status + ' ' + err.response.statusText;
          swal({
            title: 'Terjadi kesalahan',
            text: err.response.status + ' ' + err.response.statusText,
            icon: 'error',
            timer: 5000,
            dangerMode: true
          });
        }
      });
      this.forms.submitMobilePrivate = 'Simpan';
    },
    onUpdateMobileBusiness()
    {
      this.errors = {};
      this.errorMessageMobileBusiness = '';
      if( this.vendors.mobile_business === '' )
      {
        this.forms.error = true;
        this.errors.mobile_business = 'Nomor telepon bisnis wajib diisi';
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }

      this.forms.submitMobileBusiness = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/vendor/account/edit_mobilebusiness',
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          mobile_business: this.vendors.mobile_business
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errors = {};
        this.errorMessageMobileBusiness = '';
        setTimeout(function() { document.location=''; }, 3000);
      }).catch( err => {
        let status = err.response.status;
        if( status === 409 )
        {
          this.errorMessageMobileBusiness = err.response.data.statusText;
          swal({
            title: 'Terjadi kesalahan',
            text: err.response.data.statusText,
            icon: 'warning',
            timer: 5000,
            dangerMode: true
          });
        }
        else
        {
          this.errorMessageMobileBusiness = err.response.status + ' ' + err.response.statusText;
          swal({
            title: 'Terjadi kesalahan',
            text: err.response.status + ' ' + err.response.statusText,
            icon: 'error',
            timer: 5000,
            dangerMode: true
          });
        }
      });
      this.forms.submitMobileBusiness = 'Simpan';
    }
  }
}
</script>
