<template lang="html">
  <div>
    <div class="content_mainorders_header">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_mainorders_heading">
          <div class="summary_headertitle">Pembayaran - #{{ orders.transaction_id }}</div>
          <div class="summary_subtitle">Silahkan konfirmasi pembayaran pesanan Anda</div>
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
                    <div class="summarydetail-orderdate-title">Tanggal Pesan</div>
                    <div class="summarydetail-orderdate-value">{{ formatDate( orders.created_at, 'DD MMMM YYYY' ) }}</div>
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
                <div class="sidebar_summaryorder_title">Harga Deal</div>
                <div class="sidebar_summaryorder_subtitle">Rp. {{ formatCurrency }}</div>
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
                  <select class="uk-select form-settingaction" v-model="forms.bank">
                    <option value="">-- Pilih Bank --</option>
                    <option v-for="bank in bankpayment" :value="bank.bank_id">{{ bank.bank_name }}</option>
                  </select>
                  <div v-if="errors.bank" class="uk-text-small uk-text-danger">{{ errors.bank }}</div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <button @click="onCheckoutOrder" v-html="forms.submit" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-checkout">Checkout</button>
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
        payment_method: this.orders.payment_method,
        bank: this.orders.payment_to,
        payment_id: this.orders.payment_id
      },
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    getFormatFile: function(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
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

      console.log(this.forms);

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }
    }
  },
  computed: {
    formatFile() {
      var length_str_file = this.orders.layout_design.length;
      var getIndex = this.orders.layout_design.lastIndexOf(".");
      var getformatfile = this.orders.layout_design.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    formatCurrency() {
      var price = Number( this.orders.price_deal );
      var numberformat = Intl.NumberFormat('en-ID', { maximumSignificantDigits: 3 }).format( price );
      return numberformat;
    }
  },
  mounted() {
  }
}
</script>
