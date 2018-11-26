<template lang="html">
<div class="uk-margin-top">
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <div v-if="errors.error" class="uk-alert-danger uk-margin-bottom" uk-alert>
      {{ errors.error }}
    </div>
    <h3 class="content_headingsettingprofile">Edit Nomor Telepon</h3>
    <form class="uk-form-stacked" @submit.prevent="changePhone">
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="text" class="uk-width-1-2 uk-input form-settingaction" v-model="forms.phone" placeholder="Nomor Telepon">
        </div>
      </div>
      <div class="uk-margin">
        <button class="uk-button uk-button-default btn_settingaction" v-html="btnsave">Ubah Telepon</button>
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
        phone: '0' + this.customers.customer_mobile_phone
      },
      errors: {},
      btnsave: 'Ubah Telepon'
    }
  },
  methods: {
    changePhone()
    {
      this.errors = {};
      if( this.forms.phone === '' )
      {
        this.errors.error = 'Nomor telepon wajib diisi';
      }
      else if( isNaN( this.forms.phone ) )
      {
        this.errors.error = 'Nomor telepon tidak valid.';
      }
      else
      {
        this.btnsave = '<span uk-spinner></span>';
        axios({
          method: 'put',
          url: this.url + '/customers/account/edit_notelepon',
          headers: { 'Content-Type': 'application/json' },
          params: {
            notelepon: this.forms.phone
          }
        }).then( res => {
          this.errors = {};
          swal({
            title: 'Berhasil',
            text: 'Nomor Telepon berhasil diubah',
            icon: 'success',
            timer: 5000
          });
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
        this.btnsave = 'Ubah Telepon';
      }
    }
  }
}
</script>
