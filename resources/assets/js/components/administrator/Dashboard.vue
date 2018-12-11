<template lang="html">
  <div class="uk-container uk-margin-large-top">
    <div class="dashboard-welcome-screen">
      <div class="dashboard-hello">Selamat Datang, John Doe</div>
    </div>
    <div class="uk-grid-small uk-margin-top" uk-grid>
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
    <div class="uk-grid-small" uk-grid>

    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
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
    getActivityTransaction()
    {
      axios({
        method: 'get',
        url: this.url + '/analytic/activity_transaction'
      }).then( res => {
        let result = res.data;
        this.activity_transaction.total = result.results.total;
        this.activity_transaction.results = result.results.result;
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
