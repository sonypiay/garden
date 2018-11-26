<template lang="html">
<div class="uk-margin-top">
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <div v-if="errors.error" class="uk-alert-danger uk-margin-bottom" uk-alert>
      {{ errors.error }}
    </div>
    <h3 class="content_headingsettingprofile">Edit Email</h3>
    <form class="uk-form-stacked" @submit.prevent="changeEmail">
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="email" class="uk-width-1-2 uk-input form-settingaction" v-model="forms.email" placeholder="Email">
        </div>
      </div>
      <div class="uk-margin">
        <button class="uk-button uk-button-default btn_settingaction" v-html="btnsave">Ubah Email</button>
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
        email: this.customers.customer_email
      },
      errors: {},
      btnsave: 'Ubah Email'
    }
  },
  methods: {
    changeEmail()
    {
      this.errors = {};
      if( this.forms.email === '' )
      {
        this.errors.error = 'Email wajib diisi';
      }
      else
      {
        this.btnsave = '<span uk-spinner></span>';
        axios({
          method: 'put',
          url: this.url + '/customers/account/edit_email',
          headers: { 'Content-Type': 'application/json' },
          params: {
            email: this.forms.email
          }
        }).then( res => {
          this.errors = {};
          swal({
            title: 'Berhasil',
            text: 'Email berhasil diubah',
            icon: 'success',
            timer: 5000
          });
        }).catch( err => {
          if( err.response.status === 409 )
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
  }
}
</script>
