<template lang="html">
  <div>
    <div id="modalsubscribe" uk-modal>
      <div class="uk-modal-dialog">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-header">Rincian Pesanan</div>
        <div class="uk-modal-body modal_premium">
          <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
          <div class="uk-margin">
            <select class="uk-select modal_premium_form" v-model="forms.bank">
              <option value="">-- Pilih Bank --</option>
              <option v-for="bank in bankpayment" :value="bank.bank_id">{{ bank.bank_name }}</option>
            </select>
            <div v-if="errors.bank" class="uk-text-small uk-text-danger">{{ errors.bank }}</div>
          </div>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-5@m uk-width-1-1@s">
              <div class="modal_premium_text">Jumlah</div>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-right">
                <span class="modal_premium_price">Rp. 99,000</span>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-modal-footer">
          <a @click="subscribeNow()" class="uk-button uk-button-default pro-subsbutton">Bayar</a>
        </div>
      </div>
    </div>
    <div class="uk-tile uk-tile-default bgpro">
      <div class="uk-container">
        <div class="pro-container-content">
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-expand">
              <div class="uk-card uk-card-body">
                <h3 class="uk-display-inline pro-container-heading">Garden Buana <span>Premium</span></h3>
                <div class="pro-container-text">Tingkatkan akun untuk mendapatkan fitur EKSTRA</div>
              </div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <div class="uk-card uk-card-body uk-card-default pro-container-box">
                <div class="pro-container-price">Rp. 99.000</div>
                <div class="pro-container-billed">per bulan</div>
                <div class="pro-container-for">
                  Fitur ini hanya untuk pemilik jasa taman hias
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-card uk-card-body">
      <div class="uk-container">
        <div class="uk-margin-large-top pro-benefits-heading">Yang Kamu Dapatkan</div>
        <div class="uk-margin-top uk-grid-medium uk-grid-match uk-flex uk-flex-center" uk-grid>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body pro-benefits-box">
              <div class="pro-benefits-icon">
                <span uk-icon="icon: album; ratio: 4"></span>
              </div>
              <div class="pro-benefits-text">
                Draft Portfolio Tak Terbatas
              </div>
            </div>
          </div>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body pro-benefits-box">
              <div class="pro-benefits-icon">
                <span uk-icon="icon: image; ratio: 4"></span>
              </div>
              <div class="pro-benefits-text">
                Kapasitas Upload Portfolio <br>Tak Terbatas
              </div>
            </div>
          </div>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body pro-benefits-box">
              <div class="pro-benefits-icon">
                <span uk-icon="icon: check; ratio: 4"></span>
              </div>
              <div class="pro-benefits-text">
                Tag Premium
              </div>
            </div>
          </div>
        </div>
        <div class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
          <a uk-toggle="target: #modalsubscribe" class="uk-button uk-button-default uk-button-large pro-subsbutton">Berlangganan</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url', 'bankpayment'],
  data() {
    return {
      forms: {
        bank: '',
        price: 99000
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    subscribeNow()
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
        setTimeout(function(){ document.location = redirect; },2000);
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
    }
  }
}
</script>
