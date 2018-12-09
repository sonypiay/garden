<template lang="html">
  <div class="uk-margin-large-top">
    <div id="viewTransaction" uk-modal>
      <div class="uk-modal-dialog view-transaction">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-header">
          <div class="view-transaction-header">Rincian Pesanan</div>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>
          <div class="uk-margin">
            <div class="view-transaction-heading">Nomor Transaksi</div>
            <div class="view-transaction-value">{{ orders.transaction_id }}</div>
          </div>
          <div class="uk-margin">
            <div class="view-transaction-heading">Status Pesanan</div>
            <div class="view-transaction-value">{{ $root.statusTransaction[orders.last_status_transaction] }}</div>
          </div>
          <div class="uk-margin">
            <div class="view-transaction-heading">Vendor</div>
            <div class="view-transaction-value">{{ orders.vendor_name }}</div>
          </div>
          <div class="uk-margin">
            <div class="view-transaction-heading">Tanggal Pesan</div>
            <div class="view-transaction-value">{{ formatDate( orders.created_at, 'DD MMMM YYYY HH:mm' ) }}</div>
          </div>
          <hr>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="uk-margin" v-if="orders.isPremium === 'Y'">
                <div class="view-transaction-heading">Pemesan Premium</div>
                <div class="view-transaction-value">+ Rp. 5.000</div>
              </div>
              <div class="uk-margin" v-if="orders.bank_code === '014'">
                <div class="view-transaction-heading">Biaya transfer BCA</div>
                <div class="view-transaction-value">+ Rp. 4.000</div>
              </div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Total Pembayaran</div>
              <div class="view-transaction-value">Rp. {{ formatCurrency( orders.payment_amount ) }}</div>
            </div>
          </div>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Nama Pemesan</div>
              <div class="view-transaction-value">{{ orders.customer_name }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Nomor Telepon</div>
              <div class="view-transaction-value">{{ orders.mobile_number }}</div>
            </div>
          </div>
          <hr>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-1">
              <div class="view-transaction-heading">Alamat</div>
              <div class="view-transaction-value">{{ orders.address }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Provinsi</div>
              <div class="view-transaction-value">{{ region }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Kota</div>
              <div class="view-transaction-value">{{ district }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Kecamatan</div>
              <div class="view-transaction-value">{{ subdistrict }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view-transaction-heading">Kode Pos</div>
              <div class="view-transaction-value">{{ orders.zipcode }}</div>
            </div>
          </div>
        </div>
        <div class="uk-modal-footer">
          <button class="uk-button uk-button-primary" name="button">Pembayaran Diterima</button>
          <button class="uk-button uk-button-danger" name="button">Batalkan Pesanan</button>
        </div>
      </div>
    </div>

    <h3 class="">Daftar Transaksi</h3>
    <div class="uk-card uk-card-body uk-card-default">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
          <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input @keyup.enter="getOrderList()" type="text" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Cari...">
          </div>
        </div>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
          <select class="uk-select form-select" v-model="selectedRows" @change="getOrderList()">
            <option value="10">10 ditampilkan</option>
            <option value="20">20 ditampilkan</option>
            <option value="30">30 ditampilkan</option>
            <option value="50">50 ditampilkan</option>
          </select>
        </div>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
          <select class="uk-select form-select" v-model="status_transaction" @change="getOrderList()">
            <option value="all">-- Semua Status --</option>
            <option v-for="(val,key) in $root.statusTransaction" :value="key">{{ val }}</option>
          </select>
        </div>
      </div>

      <div class="uk-margin-top">
        <div class="uk-label">{{ orderlist.total }} Transaksi</div>
        <div class="uk-overflow-auto uk-margin-top">
          <table class="uk-table uk-table-small uk-table-divider uk-table-middle uk-table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>ID Transaksi</th>
                <th>Customer</th>
                <th>Vendor</th>
                <th>Status</th>
                <th>Tanggal Pesan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orderlist.results">
                <td>
                  <button @click="onViewTransaction(order)" class="uk-button uk-button-text" uk-icon="cog" uk-tooltip="title: Lihat Rincian; pos: right"></button>
                </td>
                <td>{{ order.transaction_id }}</td>
                <td class="uk-text-truncate">{{ order.customer_name }}</td>
                <td>{{ order.vendor_name }}</td>
                <td>{{ $root.statusTransaction[order.last_status_transaction] }}</td>
                <td>{{ formatDate( order.created_at, 'MMM DD, YYYY HH:mm' ) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      keywords: '',
      status_transaction: 'all',
      selectedRows: 10,
      isLoading: {
        value: false,
        text: ''
      },
      orderlist: {
        total: 0,
        results: []
      },
      orders: {},
      logstatus: {
        total: 0,
        results: []
      },
      region: '',
      district: '',
      subdistrict: '',
      pagination: {
        current: 1,
        next: '',
        prev: '',
        last: '',
        path: this.url + '/transaction/data_orderlist'
      }
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
    getOrderList(pages)
    {
      var param = '&keywords=' + this.keywords + '&rows=' + this.selectedRows + '&status=' + this.status_transaction;
      if( pages === undefined || pages === null || pages === '' )
        pages = this.url + '/transaction/data_orderlist?page=1' + param;
      else
        pages = pages + param;
      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.orderlist.total = result.total;
        this.orderlist.results = result.data;
        this.pagination = {
          current: result.current_page,
          next: result.next_page_url,
          prev: result.prev_page_url,
          last: result.last_page,
          path: result.path
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    onViewTransaction(order) {
      this.orders = order;

      axios({
        method: 'get',
        url: this.url + '/transaction/view_transaction/' + order.transaction_id
      }).then( res => {
        let result = res.data;
        this.logstatus.total = result.total;
        this.logstatus.results = result.results;
        this.region = result.location.provinsi;
        this.district = result.location.kabupaten;
        this.subdistrict = result.location.kecamatan;
      }).catch( err => {
        console.log( err.response.statusText );
      });
      UIkit.modal('#viewTransaction').show();
    }
  },
  mounted() {
    this.getOrderList();
  }
}
</script>
