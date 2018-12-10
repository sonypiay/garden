<template lang="html">
  <div>
    <div class="content_mainorders_header">
      <div class="uk-container">
        <div class="uk-card uk-card-body content_mainorders_heading">
          <div class="summary_headertitle">Rincian Pesanan</div>
          <div class="summary_subtitle">{{ formatDate( orders.created_at, 'DD MMMM YYYY, HH:mm' ) }} - #{{ orders.transaction_id }}</div>
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
                <div class="summaryorder_subtitle">{{ orders.nama_kab }}</div>
              </div>
              <div class="uk-padding-small content_summaryorder_detail">
                <div class="summarydetail-orderdate-title">Tanggal Pengerjaan</div>
                <div class="summarydetail-orderdate-value">{{ formatDate( orders.schedule_date, 'DD MMMM YYYY' ) }}</div>
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
              <div class="uk-padding-small content_summaryorder_detail">
                <div class="summarydetail-report-title">Status Transaksi</div>
                <div class="summarydetail-report-value">
                  <div class="uk-margin" v-for="log in logstatus.results">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s">
                        <div class="uk-text-right view-transaction-value">{{ formatDate( log.log_date, 'DD MMM YYYY HH:mm:ss' ) }}</div>
                      </div>
                      <div class="uk-width-expand">
                        <div class="view-transaction-heading">{{ $root.statusTransaction[log.status_transaction] }}</div>
                        <div class="view-transaction-value">
                          {{ log.status_description }}
                          <div v-if="log.status_transaction === 'report'">
                            <a class="uk-button uk-button-default summarydetail_download" href="#">
                              Unduh Report
                            </a>
                            <a class="uk-button uk-button-default summarydetail_download" href="#">
                              Konfirmasi
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                </div>
              </div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-widht-1-2@s">
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_header">
                <div class="sidebar_summaryorder_title">Harga Deal</div>
                <div class="sidebar_summaryorder_subtitle">Rp. {{ formatCurrency( orders.price_deal ) }}</div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-totaltransaction-title">Total Transaksi</div>
                <div class="side_summarydetail-totaltransaction-value">
                  <div class="uk-grid-small" uk-grid v-if="orders.bank_code === '014'">
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      Biaya transfer BCA
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      <div class="uk-text-right">
                        + Rp. 4.000
                      </div>
                    </div>
                  </div>
                  <div class="uk-grid-small" uk-grid v-if="orders.isPremium === 'Y'">
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
                      Total pembayaran
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-1@m uk-width-1-1@s">
                      <div class="uk-text-right">
                        Rp. {{ formatCurrency( grandTotalPrice ) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-metodepembayaran-title">Metode Pembayaran</div>
                <div class="side_summarydetail-metodepembayaran-value">
                  {{ orders.payment_method }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-bankpembayaran-title">Bank</div>
                <div class="side_summarydetail-bankpembayaran-value">
                  {{ orders.bank_name }} <br> {{ orders.account_number }}
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <a :href="url + '/customers/account'" class="uk-width-1-1 uk-button uk-button-large uk-button-default side_summarydetail-checkout">Kembali</a>
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
  props: ['url', 'orders'],
  data() {
    return {
      bcaCharge: 4000,
      premiumOrder: this.orders.isPremium,
      logstatus: {
        total: 0,
        results: []
      },
      reports: ''
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    formatCurrency(price) {
      var getprice = Number( price );
      var numberformat = new Intl.NumberFormat('en-ID').format( getprice );
      return numberformat;
    },
    getFormatFile: function(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    viewLogAndReport()
    {
      axios({
        method: 'get',
        url: this.url + '/customers/view_summaryorder/' + this.orders.transaction_id
      }).then( res => {
        let result = res.data;
        this.logstatus.total = result.logstatus.total;
        this.logstatus.results = result.logstatus.result;
        this.reports = result.report;
        console.log( this.reports );
      });
    }
  },
  computed: {
    grandTotalPrice()
    {
      var total = 0;
      if( this.orders.isPremium === 'Y' )
      {
        total = this.orders.price_deal + 5000;
        if( this.orders.bank_code === '014' )
        {
          total = this.orders.price_deal + 5000 + 4000;
        }
      }
      else
      {
        total = this.orders.price_deal;
        if( this.orders.bank_code === '014' )
        {
          total = this.orders.price_deal + 4000;
        }
      }
      return total;
    },
    formatFile()
    {
      var length_str_file = this.orders.layout_design.length;
      var getIndex = this.orders.layout_design.lastIndexOf(".");
      var getformatfile = this.orders.layout_design.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    }
  },
  mounted() {
    this.viewLogAndReport();
  }
}
</script>
