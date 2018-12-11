<template lang="html">
  <div class="uk-container uk-margin-large-bottom uk-margin-large-top">
    <div class="uk-margin-bottom dashboard-welcome-screen">
      <div class="dashboard-hello">Selamat Datang, John Doe</div>
    </div>
    <!--<div class="uk-grid-medium uk-grid-match" uk-grid>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-default dashboard_alluser_grid">
              <div class="uk-card-title dashboard_alluser_value">{{ allusers.customers.total_customer }}</div>
              <div class="dashboard_alluser_title">Pelanggan</div>
            </div>
          </div>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-default dashboard_alluser_grid">
              <div class="uk-card-title dashboard_alluser_value">{{ allusers.customers.registered }}</div>
              <div class="dashboard_alluser_title">Registrasi per Hari Ini</div>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-default dashboard_alluser_grid">
              <div class="uk-card-title dashboard_alluser_value">{{ allusers.vendor.total_vendor }}</div>
              <div class="dashboard_alluser_title">Vendor</div>
            </div>
          </div>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-default dashboard_alluser_grid">
              <div class="uk-card-title dashboard_alluser_value">{{ allusers.vendor.registered }}</div>
              <div class="dashboard_alluser_title">Registrasi per Hari Ini</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  -->
    <div class="uk-grid-small uk-grid-match uk-margin-top" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.payment_waiting }}</div>
          <div class="dash_statustransaction_title">Menunggu Pembayaran</div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.payment_verify }}</div>
          <div class="dash_statustransaction_title">Verifikasi Pembayaran</div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.paid }}</div>
          <div class="dash_statustransaction_title">Dibayar</div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.onprogress }}</div>
          <div class="dash_statustransaction_title">Sedang Dikerjakan</div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.report }}</div>
          <div class="dash_statustransaction_title">Laporan Pekerjaan</div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-3@s">
        <div class="uk-card uk-card-body uk-card-default dashboard_grid_statustransaction">
          <div class="uk-card-title dash_statustransaction_value">{{ total_transaction.done }}</div>
          <div class="dash_statustransaction_title">Pekerjaan Selesai</div>
        </div>
      </div>
    </div>

    <div class="uk-card uk-card-body uk-card-small uk-card-default uk-margin-top">
      <h3 class="dashboard_transaction_heading">Transaksi</h3>
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select dashboard_filter_action" v-model="forms.filter_rows" @change="getActivityTransaction( pagination.path + '?page=' + pagination.path )">
            <option value="10">10 ditampilkan</option>
            <option value="20">20 ditampilkan</option>
            <option value="30">30 ditampilkan</option>
            <option value="50">50 ditampilkan</option>
            <option value="100">100 ditampilkan</option>
          </select>
        </div>
        <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select dashboard_filter_action" v-model="forms.filter_day" @change="getActivityTransaction( pagination.path + '?page=' + pagination.path )">
            <option value="today">Hari ini</option>
            <option value="7day">7 hari terakhir</option>
            <option value="14day">14 hari terakhir</option>
            <option value="28day">28 hari terakhir</option>
            <option value="last_month">1 bulan terakhir</option>
            <option value="this_month">Bulan ini</option>
          </select>
        </div>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@s uk-width-1-3@s">
          <div class="uk-width-1-1 uk-inline">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input class="uk-width-1-1 uk-input dashboard_filter_action" type="search" placeholder="Cari..." v-model="forms.keywords" @keyup.enter="getActivityTransaction( pagination.path + '?page=' + pagination.path )">
          </div>
        </div>
        <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select dashboard_filter_action" v-model="forms.premium" @change="getActivityTransaction( pagination.path + '?page=' + pagination.path )">
            <option value="all">Premium / Non Premium</option>
            <option value="Y">Premium</option>
            <option value="N">Non Premium</option>
          </select>
        </div>
        <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select dashboard_filter_action" v-model="forms.status" @change="getActivityTransaction( pagination.path + '?page=' + pagination.path )">
            <option value="all">-- Semua Status --</option>
            <option v-for="(val, key) in $root.statusTransaction" :value="key">{{ val }}</option>
          </select>
        </div>
      </div>
      <div class="uk-overflow-auto uk-margin-top">
        <table class="uk-table uk-table-small uk-table-hover uk-table-divider uk-table-hover uk-table-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>No. Transaksi</th>
              <th>Vendor</th>
              <th>Pelanggan</th>
              <th>Kota</th>
              <th>Status</th>
              <th>Tanggal Pesan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="tr in activity_transaction.results">
              <td>
                <button class="uk-button uk-button-text" uk-icon="cog" uk-tooltip="title: Lihat Rincian; pos: right"></button>
              </td>
              <td>{{ tr.transaction_id }}</td>
              <td>{{ tr.vendor_name }}</td>
              <td>{{ tr.customer_name }}</td>
              <td>{{ tr.nama_kab }}</td>
              <td>{{ $root.statusTransaction[tr.last_status_transaction] }}</td>
              <td>{{ formatDate( tr.created_at, 'MMM DD, YYYY HH:mm' ) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        filter_rows: 10,
        filter_day: 'today',
        keywords: '',
        status: 'all',
        premium: 'all'
      },
      pagination: {
        current: 1,
        next: null,
        prev: null,
        last: 1,
        path: this.url + '/analytic/activity_transaction'
      },
      activity_transaction: {
        selectedDate: 'today',
        total: 0,
        results: []
      },
      total_transaction: {
        payment_waiting: 0,
        payment_verify: 0,
        paid: 0,
        onprogress: 0,
        report: 0,
        done: 0
      },
      allusers: {
        vendor: {
          total_vendor: 0,
          registered: 0,
        },
        customers: {
          total_customer: 0,
          registered: 0,
        }
      }
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    getTotalTransaction()
    {
      axios({
        method: 'get',
        url: this.url + '/analytic/total_transaction'
      }).then( res => {
        let result = res.data;
        this.total_transaction = {
          payment_waiting: result.results.payment_waiting,
          payment_verify: result.results.payment_verify,
          paid: result.results.paid,
          onprogress: result.results.onprogress,
          report: result.results.report,
          done: result.results.done
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getActivityTransaction(pages)
    {
      var param = '&keywords=' + this.forms.keywords + '&rows=' + this.forms.filter_rows + '&filter_day=' + this.forms.filter_day + '&status=' + this.forms.status + '&premium=' + this.forms.premium;
      if( pages === undefined || pages === null || pages === '' )
      {
        pages = this.url + '/analytic/activity_transaction?page=' + this.pagination.current + param;
      }
      else
      {
        pages = pages + param;
      }

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.activity_transaction.total = result.results.total;
        this.activity_transaction.results = result.results.data;
        console.log( result.results );
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getAllUsers()
    {
      axios({
        method: 'get',
        url: this.url + '/analytic/allusers'
      }).then( res => {
        let result = res.data;
        this.allusers.vendor = {
          total_vendor: result.vendor.total_vendor,
          registered: result.vendor.registered
        };
        this.allusers.customers = {
          total_customer: result.customers.total_customer,
          registered: result.customers.registered
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted()
  {
    this.getTotalTransaction();
    this.getActivityTransaction();
    this.getAllUsers();
  }
}
</script>

<style lang="css">
</style>
