<template lang="html">
  <div class="uk-margin-top">
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog uk-modal-body">
        <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
        <form class="uk-form-action" @submit.prevent="onRenewalPremium">
          <div class="uk-margin">
            <label class="uk-form-label form-settinglabel">Pilih Bank</label>
            <div class="uk-form-controls">
              <select class="uk-select modal_premium_form" v-model="forms.bank">
                <option value="">-- Pilih Bank --</option>
                <option v-for="bank in bankcustomer" :value="bank.bank_id">{{ bank.bank_name }}</option>
              </select>
            </div>
            <div v-if="errors.bank" class="uk-text-small uk-text-danger">{{ errors.bank }}</div>
          </div>
          <div class="uk-margin">
            <button v-html="forms.submit" class="uk-button uk-button-default btn_settingaction">Simpan</button>
          </div>
        </form>
      </div>
    </div>
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Status Premium</h3>
      <div class="content_statuspremium">
        <div v-if="premium_account.expired">
          <div v-if="expiredDate > formatDate( premium_account.expired, 'YYYY-MM-DD' )">
            <a class="uk-button uk-button-default subsnow" :href="url + '/premium'">Berlangganan</a>
          </div>
          <div v-else>
            <div v-if="premium_account.statusPremium">
              <a class="uk-button uk-button-default subsnow" :href="url + '/premium'"><span uk-icon="check"></span> Aktif</a>
            </div>
            <div v-else>
              <a class="uk-button uk-button-default subsnow" :href="url + '/premium'">Belum Aktif</a>
            </div>
          </div>
        </div>
        <div v-else>
          <a class="uk-button uk-button-default subsnow" :href="url + '/premium'">Berlangganan</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url', 'vendors', 'bankcustomer'],
  data() {
    return {
      forms: {
        bank: '',
        price: 99000
      },
      premium_account: {
        is_expired: false,
        statusPremium: 'Y',
        expired: ''
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    getStatusPremium()
    {
      axios({
        method: 'get',
        url: this.url + '/vendor/account/getpremium'
      }).then( res => {
        let result = res.data;
        this.premium_account = {
          is_expired: result.result.is_expired,
          expired: result.result.date_expired,
          statusPremium: result.result.statusPremium
        };
        console.log( this.premium_account );
      }).catch( err => {
        console.log(err.response.statusText);
      })
    },
    onRenewalPremium()
    {
      this.errors = {};
      this.errorMessage = '';

      if( this.forms.bank === '' )
      {
        this.errors.bank = 'Silahkan pilih bank terlebih dahulu.';
        return false;
      }

      axios({
        method: 'post',
        url: this.url + '/premium_checkout/',
        params: {
          bank: this.forms.bank,
          price: this.forms.price
        }
      }).then( res => {
        var redirect = this.url + '/complete_payment_premium/' + res.data.order_id;
        setTimeout(function(){ document.location = redirect; }, 2000);
        console.log( res.data );
      }).catch( err => {
        let status = err.response.status;
        if( status === 400 || status === 401 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = err.response.statusText;
        }
      });
    },
    formatDate( str, format )
    {
      var res = moment( str ).locale('id').format(format);
      return res;
    }
  },
  mounted() {
    this.getStatusPremium();
  },
  computed: {
    expiredDate()
    {
      var res = moment( new Date() ).locale('id').format('YYYY-MM-DD');
      return res;
    }
  }
}
</script>
