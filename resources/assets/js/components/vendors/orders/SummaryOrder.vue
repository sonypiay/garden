<template lang="html">
  <div>
    <div id="createModal" uk-modal>
      <div class="uk-modal-dialog">
        <div class="uk-modal-body">
          <h3>Upload Hasil Pekerjaan</h3>
          <form class="uk-form-stacked" @submit.prevent="onCreateReport">
            <div class="uk-margin">
              <div class="uk-form-controls">
                <input type="file" id="selectedFile" @change="selectedFile">
                <div class="uk-text-small">zip/pdf. Max 2MB</div>
              </div>
            </div>
            <div class="uk-margin">
              <textarea class="uk-textarea uk-height-small form-settingaction" placeholder="Deskripsi" v-model="forms.deskripsi"></textarea>
            </div>
            <div class="uk-margin">
              <button class="uk-button uk-button-default">Upload</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
                    <div class="summarydetail-orderdate-title">Tanggal Pesan</div>
                    <div class="summarydetail-orderdate-value">{{ formatDate( orders.created_at, 'MMM DD, YYYY HH:mm' ) }}</div>
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
                <div class="sidebar_summaryorder_subtitle">Rp. {{ formatCurrency( orders.price_deal ) }}</div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div class="side_summarydetail-statustransaction-title">Status Transaksi</div>
                <div class="side_summarydetail-statustransaction-value">
                  {{ $root.statusTransaction[orders.last_status_transaction] }}
                </div>
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
                <div class="side_summarydetail-layananpremium-title">Layanan Premium</div>
                <div class="side_summarydetail-layananpremium-value">
                  <span v-if="orders.isPremium === 'Y'">Ya</span>
                  <span v-else>Tidak</span>
                </div>
              </div>
              <div class="uk-card uk-card-body uk-card-small sidebar_summaryorder_detail">
                <div v-if="orders.last_status_transaction === 'approval'">
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                      <button v-html="forms.approved" @click="onApproval('Y')" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-approved">Approve</button>
                    </div>
                    <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                      <button v-html="forms.rejected" @click="onApproval('N')" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-reject">Reject</button>
                    </div>
                  </div>
                </div>
                <div v-else-if="orders.last_status_transaction === 'paid'">
                  <button @click="onProcessOrder()" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-checkout">Proses Pesanan</button>
                </div>
                <div v-else-if="orders.last_status_transaction === 'process'">
                  <button @click="onProgressOrder()" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-checkout">Kerjakan</button>
                </div>
                <div v-else-if="orders.last_status_transaction === 'onprogress'">
                  <button @click="createReportModal()" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-checkout">Buat Laporan</button>
                </div>
                <div v-else>
                  <a :href="url + '/vendor/order_list'" class="uk-width-1-1 uk-button uk-button-default side_summarydetail-checkout">Kembali</a>
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
        approved: 'Terima',
        rejected: 'Tolak',
        isApprove: this.orders.isPremium === 'N' ? 'N' : 'Y',
        filereport: '',
        deskripsi: ''
      }
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
    selectedFile(event) {
      var files = event.target.files[0];
      var extension = this.getFormatFile( files.name );
      if( extension !== 'pdf' && extension !== 'zip' )
      {
        this.forms.filereport = '';
        swal({
          title: 'Format file tidak valid',
          text: 'Format hanya bisa berupa zip/pdf',
          icon: 'warning',
          dangerMode: true,
          timer: 5000
        });
      }
      else if( this.forms.filereport.size > 2048000 )
      {
        this.forms.filereport = '';
        swal({
          title: 'Format file tidak valid',
          text: 'Format hanya bisa berupa zip/pdf',
          icon: 'warning',
          dangerMode: true,
          timer: 5000
        });
      }
      else
      {
        this.forms.filereport = files;
      }
      console.log(this.forms);
    },
    getFormatFile: function(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    onApproval(approval) {
      this.forms.isApprove = approval;
      if( this.forms.isApprove === 'Y' )
      {
        this.forms.approved = '<span uk-spinner></span>';
      }
      else
      {
        this.forms.rejected = '<span uk-spinner></span>';
      }

      axios({
        method: 'put',
        url: this.url + '/vendor/order_approval/' + this.orders.transaction_id,
        headers: { 'Content-Type': 'application/json' },
        params: { approval: this.forms.isApprove }
      }).then( res => {
        if( this.forms.isApprove === 'Y' )
        {
          swal({
            title: 'Konfirmasi Approval',
            text: 'Nomor pesanan ' + this.orders.transaction_id + ' diterima',
            icon: 'success',
            timer: 5000
          });
          this.forms.approved = 'Terima';
        }
        else
        {
          swal({
            title: 'Konfirmasi Approval',
            text: 'Nomor pesanan ' + this.orders.transaction_id + ' ditolak',
            icon: 'success',
            timer: 5000
          });
          this.forms.rejected = 'Tolak';
        }
        var redirect = this.url + '/vendor/summary_order/' + this.orders.transaction_id;
        setTimeout(function(){ document.location = redirect; }, 3000);
      }).catch( err => {
        swal({
          title: 'Terjadi Kesalahan',
          text: err.response.statusText,
          icon: 'error',
          timer: 5000,
          dangerMode: true
        });
        if( this.forms.isApprove === 'Y' )
        {
          this.forms.approved = 'Terima';
        }
        else
        {
          this.forms.rejected = 'Tolak';
        }
      });
    },
    onProcessOrder()
    {
      axios({
        method: 'put',
        url: this.url + '/vendor/process_order/' + this.orders.transaction_id
      }).then( res => {
        swal({
          title: 'Update Berhasil',
          text: 'Pesanan sedang diproses.',
          icon: 'success',
          timer: 5000
        });
        var redirect = this.url + '/vendor/summary_order/' + this.orders.transaction_id;
        setTimeout(function(){ document.location = redirect; }, 2000);
      }).catch( err => {
        swal({
          title: 'Terjadi Kesalahan',
          text: err.response.statusText,
          icon: 'error',
          timer: 5000
        });
      });
    },
    onProgressOrder()
    {
      axios({
        method: 'put',
        url: this.url + '/vendor/progress_order/' + this.orders.transaction_id
      }).then( res => {
        swal({
          title: 'Update Berhasil',
          text: 'Pesanan sedang diproses.',
          icon: 'success',
          timer: 5000
        });
        var redirect = this.url + '/vendor/summary_order/' + this.orders.transaction_id;
        setTimeout(function(){ document.location = redirect; }, 2000);
      }).catch( err => {
        swal({
          title: 'Terjadi Kesalahan',
          text: err.response.statusText,
          icon: 'error',
          timer: 5000
        });
      });
    },
    createReportModal()
    {
      UIkit.modal('#createModal').show();
    },
    onCreateReport()
    {
      if( this.forms.filereport === '' || this.forms.filereport === null )
      {
        return false;
      }

      var formdata = new FormData();
      formdata.append('filereport', this.forms.filereport);
      formdata.append('deskripsi', this.forms.deskripsi);
      axios.post( this.url + '/vendor/createreport/' + this.orders.transaction_id, formdata, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      .then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000,
        });
        var redirect = this.url + '/vendor/summary_order/' + this.orders.transaction_id;
        setTimeout(function(){ document.location = redirect; }, 3000);
      }).catch( err => {
        swal({
          title: 'Terjadi Kesalahan',
          text: err.response.statusText,
          icon: 'error',
          timer: 5000
        });
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
    formatFile() {
      var length_str_file = this.orders.layout_design.length;
      var getIndex = this.orders.layout_design.lastIndexOf(".");
      var getformatfile = this.orders.layout_design.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    }
  }
}
</script>
