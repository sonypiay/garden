<template lang="html">
  <div class="uk-margin-top">
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Logo</h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-action" @submit.prevent="onUploadLogo">
        <div class="uk-margin">
          <div v-if="vendors.logo">
            <div v-if="forms.logo">
              <img class="uk-width-1-4" :src="forms.logoAsUrl" />
            </div>
            <div v-else>
              <img class="uk-width-1-4" :src="url + '/images/vendor/logobrand/' + vendors.logo" :alt="vendors.logo">
            </div>
          </div>
          <div v-else>
            <div v-if="forms.logo">
              <img class="uk-width-1-4" :src="forms.logoAsUrl" />
            </div>
            <div v-else>
              <div class="uk-width-1-5 uk-tile uk-tile-default logobrand-container">
                <div class="uk-position-center uk-text-center">
                  JPG / PNG <br /> 2 MB
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-margin">
          <div class="uk-form-controls">
            <div uk-form-custom="target: true">
              <input type="file" id="selectedFile" @change="selectedFile">
              <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
            </div>
          </div>
          <div v-if="errors.logo" class="uk-text-danger uk-text-small">{{ errors.logo }}</div>
        </div>
        <div class="uk-margin">
          <button v-html="forms.submit" class="uk-button uk-button-default btn_settingaction">Ganti Logo</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url','vendors'],
  data() {
    return {
      errors: {},
      errorMessage: '',
      forms: {
        logo: '',
        logoAsUrl: '',
        error: false,
        submit: 'Ganti Logo'
      }
    }
  },
  methods: {
    onUploadLogo() {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.logo === '' )
      {
        this.errorMessage = 'Silahkan masukkan gambar terlebih dahulu.';
      }
      else
      {
        const formdata = new FormData();
        formdata.append('logo', this.forms.logo);
        axios.post( this.url + '/vendor/account/brandinglogo', formdata ).then( res => {
          swal({
            title: 'Berhasil',
            text: res.data.statusText,
            icon: 'success',
            timer: 5000
          });
          this.forms.logo = '';
          this.forms.logoAsUrl = this.vendors.logo;
          formdata.delete('logo');
          setTimeout(function(){ document.location = ''; }, 3000);
        }).catch( err => {
          let status = err.response.status;
          if( status === 413 )
          {
            this.errorMessage = err.response.data.statusText;
            swal({
              title: 'Terjadi kesalahan',
              text: this.errorMessage,
              icon: 'warning',
              timer: 5000,
              dangerMode: true
            });
          }
          else
          {
            this.errorMessage = err.response.statusText;
            swal({
              title: 'Terjadi kesalahan',
              text: this.errorMessage,
              icon: 'error',
              timer: 5000,
              dangerMode: true,
            });
          }
        });
      }
    },
    getFormatFile(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    selectedFile(event) {
      this.forms.logo = event.target.files[0];
      if( this.getFormatFile( this.forms.logo.name ) !== 'png' && this.getFormatFile( this.forms.logo.name ) !== 'jpg' )
      {
        this.forms.logo = '';
        this.errorMessage = 'Format file hanya JPG/PNG';
      }
      else
      {
        this.forms.logoAsUrl = URL.createObjectURL(this.forms.logo);
        console.log(this.forms);
      }
    }
  },
  mounted() {

  }
}
</script>

<style lang="css">
</style>
