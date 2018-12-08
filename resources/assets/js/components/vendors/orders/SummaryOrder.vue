<template lang="html">
  <div>
    <div class="content_mainorders_header">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_mainorders_heading">
          <div class="summary_headertitle">Pesanan - #{{ orders.transaction_id }}</div>
        </div>
      </div>
    </div>
    <div class="content_mainorder_body">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_summaryorder">
          <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-expand">
              <div class="uk-padding content_summaryorder_header">
                <div class="summaryorder_title">{{ orders.customer_name }}</div>
                <div class="summaryorder_subtitle">{{ vendors.kabupaten }}</div>
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
                <div class="sidebar_summaryorder_title">Harga Deal</div>
                <div class="sidebar_summaryorder_subtitle">Rp. {{ formatCurrency }}</div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-statustransaction-title">Status Transaksi</div>
                <div class="side_summarydetail-statustransaction-value">
                  {{ $root.statusTransaction[orders.last_status_transaction] }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-metodepembayaran-title">Metode Pembayaran</div>
                <div class="side_summarydetail-metodepembayaran-value">
                  {{ orders.payment_method }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-layananpremium-title">Layanan Premium</div>
                <div class="side_summarydetail-layananpremium-value">
                  <span v-if="orders.isPremium === 'Y'">Ya</span>
                  <span v-else>Tidak</span>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div v-if="orders.last_status_transaction === 'approval'">
                  <button @click="onCheckoutOrder" v-html="forms.approved" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-approved">Approve</button>
                  <button @click="onCheckoutOrder" v-html="forms.rejected" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-reject">Reject</button>
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
  props: ['url', 'orders', 'vendors'],
  data() {
    return {
      errorMessage: '',
      forms: {
        error: false,
        submit: 'Checkout',
        approved: 'Approve',
        rejected: 'Reject',
        isApprove: ''
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
    onSelectedBank(bank) {
      this.forms.bank = bank.bank_id;
      this.forms.selectedBank.name = bank.bank_name;
      this.forms.selectedBank.account_number = bank.account_number;
      this.forms.selectedBank.code = bank.bank_code;
      console.log(this.forms.selectedBank);
    },
    onApproval(approval) {
      this.forms.isApprove = approval;
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
