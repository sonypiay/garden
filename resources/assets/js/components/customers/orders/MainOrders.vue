<template lang="html">
  <div>
    <div class="content_mainorders_header">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_mainorders_heading">
          <div class="summary_headertitle">Pembayaran - #{{ orders.transaction_id }}</div>
          <div class="summary_subtitle">Silahkan lakukan pembayaran pesanan Anda</div>
        </div>
      </div>
    </div>
    <div class="content_mainorder_body">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_summaryorder">
          <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-expand">
              <div class="uk-padding content_summaryorder_header">
                <div class="summaryorder_title">{{ orders.vendor_name }}</div>
                <div class="summaryorder_subtitle">{{ vendors.nama_kab }}</div>
              </div>
              <div class="uk-padding-small content_summaryorder_detail">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                    <div class="summarydetail-orderdate-title">Tanggal Pengerjaan</div>
                    <div class="summarydetail-orderdate-value">{{ formatDate( orders.schedule_date, 'DD MMMM YYYY' ) }}</div>
                  </div>
                  <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                    <div class="uk-text-right">
                      <a href="#" class="uk-button uk-button-default summarydetail-editorder">Ubah Pesanan</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-padding-small content_summaryorder_detail">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                    <div class="summarydetail-mobilenumber-title">Nomor Telepon</div>
                    <div class="summarydetail-mobilenumber-value">{{ orders.mobile_number }}</div>
                  </div>
                  <div class="uk-width-expand">
                    <div class="summarydetail-note-title">Catatan</div>
                    <div class="summarydetail-note-value">{{ orders.additional_info }}</div>
                  </div>
                </div>
              </div>
              <div class="uk-padding content_summaryorder_detail">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                    <div class="summarydetail-address-title">Alamat</div>
                    <div class="summarydetail-address-value">{{ orders.address }}</div>
                  </div>
                  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                    <div class="summarydetail-address-title">Provinsi</div>
                    <div class="summarydetail-address-value">
                      {{ orders.nama_provinsi }}
                    </div>
                  </div>
                  <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                    <div class="summarydetail-address-title">Kota</div>
                    <div class="summarydetail-address-value">
                      {{ orders.nama_kab }} <br> {{ orders.nama_kec }} <br> {{ orders.zipcode }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-padding-small content_summaryorder_detail">
                <div class="summarydetail-layoutdesign-title">Layout Design</div>
                <div class="summarydetail-layoutdesign-value">
                  <div v-if="orders.layout_design">
                    <img v-if="formatFile === 'jpeg' || formatFile === 'jpg'" :src="url + '/images/customer/layout_design/' + orders.layout_design" alt="">
                    <div v-else>
                      <a class="uk-button uk-button-default summarydetail_download" href="#">
                        <span uk-icon="cloud-download"></span> Unggah
                      </a>
                    </div>
                  </div>
                  <div v-else>
                    Layout tidak dilampirkan
                  </div>
                </div>
              </div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-widht-1-2@s">
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_header">
                <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
                <div class="sidebar_summaryorder_title">Harga Deal</div>
                <div class="sidebar_summaryorder_subtitle">Rp. {{ formatCurrency( orders.price_deal ) }}</div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-totaltransaction-title">Total Transaksi</div>
                <div class="side_summarydetail-totaltransaction-value">
                  <div class="uk-grid-small" uk-grid v-if="forms.selectedBank.code === '014'">
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      Biaya transfer BCA
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      <div class="uk-text-right">
                        + Rp. 4.000
                      </div>
                    </div>
                  </div>
                  <div class="uk-grid-small" uk-grid v-if="forms.premium === 'Y'">
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      Pemesan Premium
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      <div class="uk-text-right">
                        + Rp. 5.000
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      Total yang harus dibayar
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      <div class="uk-text-right">
                        Rp. {{ formatCurrency( forms.subtotal.total ) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-statustransaction-title">Status Transaksi</div>
                <div class="side_summarydetail-statustransaction-value">
                  {{ $root.statusTransaction[orders.last_status_transaction] }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-kodepembayaran-title">Kode Pembayaran</div>
                <div class="side_summarydetail-kodepembayaran-value">
                  <div>#{{ orders.payment_id }}</div>
                  <div class="uk-text-small">
                    <i>Masukkan berita acara untuk mempercepat proses verifikasi</i>
                  </div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-metodepembayaran-title">Metode Pembayaran</div>
                <div class="side_summarydetail-metodepembayaran-value">
                  <select class="uk-select summarydetail-formselect" v-model="forms.payment_method">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="TRANSFER">Transfer Bank</option>
                  </select>
                  <div v-if="errors.payment_method" class="uk-text-small uk-text-danger">{{ errors.payment_method }}</div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-bankpembayaran-title">Bank</div>
                <div class="side_summarydetail-bankpembayaran-value">
                  <div class="uk-width-1-1 uk-inline">
                    <button class="uk-width-1-1 uk-button uk-button-default side_summarydetail-dropdownbank" v-html="forms.selectedBank.name">Pilih Bank <span class="fas fa-chevron-down"></span></button>
                    <div class="uk-width-1-1 summarydetail_dropdownbank-container" uk-dropdown="mode: click; pos: top">
                      <ul class="uk-nav uk-dropdown-nav">
                        <li v-for="bank in bankpayment"><a @click="onSelectedBank( bank )">{{ bank.bank_name }}</a></li>
                      </ul>
                    </div>
                  </div>
                  <div v-if="errors.bank" class="uk-text-small uk-text-danger">{{ errors.bank }}</div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail" v-if="forms.bank">
                <div class="side_summarydetail-bankpembayaran-title">
                  <span v-if="forms.bank !== ''">{{ forms.selectedBank.name }}</span>
                </div>
                <div class="side_summarydetail-bankpembayaran-value">
                  {{ forms.selectedBank.account_number }} <br>
                  {{ forms.selectedBank.code }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-layananpremium-title">
                  Tambahkan Layanan Premium
                </div>
                <div class="side_summarydetail-layananpremium-value">
                  <select class="uk-select summarydetail-formselect" @change="onPremiumOrder()" v-model="forms.premium">
                    <option value="N">Tidak</option>
                    <option value="Y">Ya</option>
                  </select>
                  <div class="uk-text-small uk-text-muted side_summarydetail-subvalue">
                    Dengan menjadi Pemesan Premium kamu akan mendapatkan prioritas layanan dari tim layanan pengguna kami untuk menambahkan kenyamanan dalam bertransaksi.
                  </div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div v-if="orders.last_status_transaction === 'approval'">
                  <button @click="onCheckoutOrder" v-html="forms.submit" :disabled="true" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-checkout">Checkout</button>
                </div>
                <div v-else>
                  <button @click="onCheckoutOrder" v-html="forms.submit" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-checkout">Checkout</button>
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
export default {
  props: ['url', 'orders', 'vendors', 'bankpayment'],
  data() {
    return {
      errorMessage: '',
      errors: {},
      props: {
        url: this.url,
        orders: this.orders,
        vendors: this.vendors
      },
      forms: {
        error: false,
        submit: 'Checkout',
        payment_method: this.orders.payment_method === null ? '' : this.orders.payment_method,
        bank:  this.orders.payment_to === null ? '' : this.orders.payment_to,
        payment_id: this.orders.payment_id,
        premium: this.orders.isPremium,
        premiumCharge: 5000,
        subtotal: {
          total: this.orders.price_deal
        },
        selectedBank: {
          id: this.orders.bank_id === null ? '' : this.orders.bank_id,
          name: this.orders.bank_name === null ? 'Pilih bank <span class="fas fa-chevron-down"></span>' : this.orders.bank_name,
          account_number: this.orders.account_number === null ? '' : this.orders.account_number,
          code: this.orders.bank_code === null ? '' : this.orders.bank_code
        }
      },
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    formatCurrency(price) {
      price = Number( price );
      var numberformat = new Intl.NumberFormat('en-ID').format( price );
      return numberformat;
    },
    getFormatFile: function(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    onSelectedBank(bank) {
      this.forms.bank = bank.bank_id;
      this.forms.selectedBank.name = bank.bank_name;
      this.forms.selectedBank.account_number = bank.account_number;
      this.forms.selectedBank.code = bank.bank_code;
      var total = this.forms.subtotal.total;
      if( this.forms.selectedBank.code === '014' )
      {
        if( this.forms.premium === 'N' )
        {
          total = this.orders.price_deal + 4000;
        }
        else
        {
          total = this.orders.price_deal + 4000 + this.forms.premiumCharge;
        }
      }
      else
      {
        total = this.orders.price_deal;
        if( this.forms.premium === 'Y' )
        {
          total = this.orders.price_deal + this.forms.premiumCharge;
        }
      }
      this.forms.subtotal.total = total;
    },
    onPremiumOrder() {
      var total = this.orders.price_deal;
      if( this.forms.selectedBank.code === '014' )
      {
        if( this.forms.premium === 'N' )
        {
          total = this.orders.price_deal + 4000;
        }
        else
        {
          total = this.orders.price_deal + 4000 + this.forms.premiumCharge;
        }
      }
      else
      {
        total = this.orders.price_deal;
        if( this.forms.premium === 'Y' )
        {
          total = this.orders.price_deal + this.forms.premiumCharge;
        }
      }
      this.forms.subtotal.total = total;
    },
    onCheckoutOrder() {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.payment_method === '' )
      {
        this.forms.error = true;
        this.errors.payment_method = 'Metode pembayaran wajib diisi';
      }
      if( this.forms.bank === '' )
      {
        this.forms.error = true;
        this.errors.bank = 'Silahkan pilih bank yang tersedia.';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }
      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/booking_checkout/' + this.orders.transaction_id,
        headers: { 'Content-Type': 'application/json' },
        params: {
          payment_id: this.forms.payment_id,
          payment_method: this.forms.payment_method,
          bank: this.forms.bank,
          payment_amount: this.forms.subtotal.total,
          premium: this.forms.isPremium
        }
      }).then( res => {
        let result = res.data;
        var redirect = this.url + '/customers/transaction_success/' + this.orders.transaction_id;
        setTimeout(function(){ document.location = redirect; }, 3000);
        console.log( result );
      }).catch( err => {
        this.forms.submit = 'Checkout';
        this.errorMessage = err.response.status + ' ' + err.response.statusText;
        swal({
          title: 'Terjadi kesalahan',
          text: err.response.statusText,
          icon: 'warning',
          dangerMode: true,
          timer: 5000
        });
      });
    }
  },
  computed: {
    formatFile() {
      var length_str_file = this.orders.layout_design.length;
      var getIndex = this.orders.layout_design.lastIndexOf(".");
      var getformatfile = this.orders.layout_design.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    }
  },
  mounted() {
  }
}
</script>
