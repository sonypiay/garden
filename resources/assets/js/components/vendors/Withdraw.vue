<template lang="html">
  <div class="uk-margin-large-top">
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-body modal-withdraw">
          <h3>Penarikan Dana</h3>
          <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
          <form class="uk-form-stacked" @submit.prevent="onWithdraw">
            <div class="uk-margin">
              <div class="withdraw_fyi">Demi kelancaran proses pencairan dana, mohon pastikan kembali nama dan nomor rekening yang dicantumkan sudah sesuai dengan yang tertera pada bukti tabungan Anda</div>
            </div>
            <div class="uk-margin">
              <label class="uk-form-label withdraw_formlabel">Jumlah Penarikan</label>
              <div class="uk-form-controls">
                <input type="text" class="uk-input withdraw_formtext" placeholder="0" v-model="forms.nominal" @keyup="formatPrice()">
              </div>
              <div v-if="errors.nominal" class="uk-text-small uk-text-danger">{{ errors.nominal }}</div>
            </div>
            <div class="uk-margin">
              <label class="uk-form-label withdraw_formlabel">Nomor Rekening</label>
              <div class="uk-form-controls">
                <a class="uk-button uk-button-default withdraw_selectdropdown" v-html="forms.rekening.selectedName"></a>
                <div class="withdraw_dropdown_content" uk-dropdown="mode: click">
                  <ul class="uk-nav uk-dropdown-nav">
                    <li v-for="bank in vendorbank"><a href="#" @click="onSelectedAccountNumber(bank)">{{ bank.bank_name }} a/n {{ bank.ownername }}</a></li>
                  </ul>
                </div>
                <div v-if="errors.rekening" class="uk-text-small uk-text-danger">{{ errors.rekening }}</div>
              </div>
            </div>
            <div class="uk-margin">
              <label class="uk-form-label withdraw_formlabel">Kata Sandi</label>
              <div class="uk-form-controls">
                <input type="password" class="uk-input withdraw_formtext" v-model="forms.password">
              </div>
              <div v-if="errors.password" class="uk-text-small uk-text-danger">{{ errors.password }}</div>
            </div>
            <div class="uk-margin">
              <a class="uk-button uk-button-default wihtdraw_cancel_btn uk-modal-close">Batal</a>
              <button class="uk-button uk-button-default withdraw_submit_btn" v-html="forms.submit"></button>
            </div>
          </form>
          <div class="withdraw_fyi">
            *) Penarikan dana akan diproses dalam 2x24 jam.<br>
            *) Minimum penarikan dana yang bisa dilakukan adalah Rp. 50.000<br>
            *) Maksimal penarikan dana yang bisa dilakukan adalah Rp. 10.000.000
          </div>
        </div>
      </div>
    </div>

    <div class="uk-grid-medium" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-4@m uk-visible@s">
        <div class="uk-card uk-card-body uk-card-default withdraw_balance_box">
          <div class="balance_title">Dana tersedia</div>
          <div class="balance_value">Rp. {{ formatCurrency( vendors.credits ) }}</div>
          <button class="uk-width-1-1 uk-button uk-button-default balance_withdraw_button" uk-toggle="target: #modal">Tarik Dana</button>
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-card uk-card-body uk-card-default withdraw_history_transaction">
          <div class="uk-card-title">Riwayat Transaksi</div>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <v-date-picker :formats="datepicker.formats" mode="range" v-model="datepicker.ranges" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles"></v-date-picker>
            </div>
            <div class="uk-width-expand">
              <div class="uk-inline">
                <button class="uk-button uk-button-default withdraw_selectdropdown" v-html="forms.statusText"></button>
                <div uk-dropdown="mode: click">
                  <ul class="uk-nav uk-dropdown-nav">
                    <li><a>Penerimaan</a></li>
                    <li><a>Penarikan</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';

export default {
  props: ['url', 'vendors', 'vendorbank'],
  data() {
    return {
      datepicker: {
        ranges: {
          start: new Date(),
          end: new Date()
        },
        props: {
          class: "uk-width-1-1 uk-input withdraw_history_form",
          placeholder: "Masukkan tanggal",
          readonly: true
        },
        attributes: {
          highlight: {
            backgroundColor: '#f6a192',     // Red background
            borderColor: '#f6a192',
            borderWidth: '2px',
            borderStyle: 'solid',
          }
        },
        themeStyles: {
          wrapper: {
            background: '#ffffff',
            color: '#ffffff',
            border: '0',
            borderRadius: '5px',
            boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.14), 0 6px 20px 0 rgba(0, 0, 0, 0.13)'
          }
        },
        formats: {
          title: 'MMMM YYYY',
          weekdays: 'W',
          navMonths: 'MMM',
          input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
          dayPopover: 'L', // Only for `v-date-picker`
          data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
        }
      },
      errors: {},
      errorMessage: null,
      forms: {
        error: false,
        submit: 'Tarik Dana',
        status: 'all',
        statusText: 'Semua Status <span uk-icon="chevron-down"></span>',
        nominal: 0,
        rekening: {
          selectedName: 'Pilih Rekening <span uk-icon="chevron-down"></span>',
          selectedValue: null
        },
        password: null
      }
    }
  },
  components: {
    VCalendar
  },
  methods: {
    formatDate(str, format)
    {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    formatCurrency(price)
    {
      var getprice = Number( price );
      var numberformat = new Intl.NumberFormat('en-ID').format( getprice );
      return numberformat;
    },
    formatPrice()
    {
      var number = this.forms.nominal;
      if( isNaN( number ) )
      {
        number = Number(number.replace(/[^0-9.-]+/g, ""));
      }
      var numberformat = new Intl.NumberFormat('en-ID').format(number);
      this.forms.nominal = numberformat;
    },
    onSelectedAccountNumber(bank)
    {
      this.forms.rekening.selectedName = bank.account_number + ' a/n ' + bank.ownername;
      this.forms.rekening.selectedValue = bank.bank_id;
      console.log(this.forms.rekening);
    },
    onWithdraw()
    {
      this.errors = {};
      this.errorMessage = null;
      var nominal = this.forms.nominal;

      if( nominal !== 0 || nominal === '' )
          nominal = Number( nominal.replace(/[^0-9.-]+/g, ""));

      if( nominal === 0 )
      {
        this.forms.error = true;
        this.errors.nominal = 'Masukkan nominal angka yang ingin dicairkan.';
      }
      if( this.forms.rekening.selectedValue === null )
      {
        this.forms.error = true;
        this.errors.rekening = 'Silahkan pilih rekening Anda.';
      }
      if( this.forms.password === null )
      {
        this.forms.error = true;
        this.errors.password = 'Masukkan kata sandi Anda.';
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      if( this.vendors.credits_balance === 0 )
      {
        this.errorMessage = 'Dana Anda saat ini Rp. 0';
      }
      else if( nominal < 50000 )
      {
        this.errorMessage = 'Minimum penarikan dana yang bisa dilakukan adalah Rp. 50.000';
      }
      else if( nominal > 10000000 )
      {
        this.errorMessage = 'Maksimal penarikan dana yang bisa dilakukan adalah Rp. 10.000.000';
      }
      else
      {
        axios({
          method: 'post',
          url: this.url + '/vendor/account/withdraw',
          headers: { 'Content-Type': 'application/json' },
          params: {
            nominal: nominal,
            password: this.forms.password,
            rekening: this.forms.rekening.selectedValue
          }
        }).then( res => {
          swal({
            title: 'Berhasil',
            text: res.data.statusText,
            icon: 'success',
            timer: 3000
          });
          var redirect = this.url + '/vendor/account/withdraw';
          setTimeout(function(){ document.location = redirect; }, 3000);
        }).catch( err => {
          let status = err.response.status;
          if( status === 401 || status === 400 )
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
}
</script>
