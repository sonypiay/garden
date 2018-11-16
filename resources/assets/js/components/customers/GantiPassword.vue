<template lang="html">
<div>
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <h3 class="content_headingsettingprofile">Edit Profil</h3>
    <form class="uk-form-stacked" @submit.prevent="changePassword">
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="password" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.password" placeholder="Password Baru">
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-controls">
          <input type="password" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.confirmpassword" placeholder="Konfirmasi Password">
        </div>
      </div>
      <div class="uk-margin">
        <button class="uk-button uk-button-default btn_settingaction" v-html="btnsave">Ubah Password</button>
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
      btnsave: 'Ubah Password'
    }
  },
  methods: {
    changePassword()
    {

    }
  }
}
</script>
