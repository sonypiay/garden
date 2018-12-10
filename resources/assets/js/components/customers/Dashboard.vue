<template lang="html">
  <div class="dashb_customer">
    <div class="uk-container">
      <div class="dash_customername">{{ customers.customer_name }}</div>
      <div class="dash_customerhistory">
        <span class="dash_historytransaction">{{ transaction.total }} Transaksi</span>
        <span class="dash_vendorpilihan">
          {{ transaction.statusTransaction.approved }} Diterima &nbsp;
          {{ transaction.statusTransaction.payment_waiting }} Menunggu Pembayaran &nbsp;
          {{ transaction.statusTransaction.rejected }} Ditolak &nbsp;
        </span>
      </div>
      <!--<div class="uk-grid-small" uk-grid>
      <div class="dash_customername">{{ customers.customer_name }}</div>
      <div class="dash_customerhistory">
      <span class="dash_historytransaction">5 Transaksi</span>
      <span class="dash_vendorpilihan">3 Vendor Pilihan</span>
    </div>
        <div class="uk-width-3-4@xl uk-width-3-4@xl uk-width-2-3@m uk-width-1-2@s">
        </div>
        <div class="uk-width-expand">
          <div class="uk-float-right dash_customercredit">
            <div class="dash_customercredit_text">Saldo Anda</div>
            <div class="dash_customercredit_balance">
              Rp. 10.350.000
            </div>
          </div>
        </div>
      </div>
    -->
    </div>

    <div class="board_bookingvendor">
      <div class="uk-card uk-card-body uk-card-default board_listbookingvendor">
        <div class="uk-width-1-3 uk-align-center" v-if="transaction.total === 0">
          <div class="board_neverbooking_icon">
            <span class="fas fa-leaf"></span>
          </div>
          <div class="board_neverbooking_text">Anda belum pernah memesan vendor disini</div>
          <div class="uk-text-center">
            <a :href="url + '/discovery'" class="uk-button uk-button-default uk-button-large board_bookbutton">Pesan sekarang juga</a>
          </div>
        </div>
        <div class="uk-grid-small" uk-grid="masonry: true">
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s" v-for="result in transaction.results">
            <div class="uk-card uk-card-default dashboard_summary-transaction">
              <div class="uk-card-media-top">
                <div v-if="result.vendor_logo">
                  <img :src="url + '/images/vendor/logobrand/' + result.vendor_logo" :alt="result.vendor_name">
                </div>
                <div class="uk-tile uk-tile-default dash_sum-transaction-banner" v-else>
                  <span uk-icon="icon: image; ratio: 4"></span>
                </div>
              </div>
              <div class="uk-card-body uk-card-small">
                <div class="uk-badge dash_sum-transaction-status">{{ $root.statusTransaction[result.last_status_transaction] }}</div>
                <div class="dash_sum-transaction-title">{{ result.vendor_name }}</div>
                <div class="dash_sum-transaction-orderdate">{{ formatDate( result.created_at ) }}</div>
                <a v-if="result.last_status_transaction === 'approval' || result.last_status_transaction === 'payment_waiting'" class="uk-display-block uk-margin-top dash_sum-transaction-view" :href="url + '/customers/main_orders/' + result.transaction_id">Lihat rincian</a>
                <a v-else class="uk-display-block uk-margin-top dash_sum-transaction-view" :href="url + '/customers/summary_order/' + result.transaction_id">Lihat Rincian</a>
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
  props: ['url', 'customers'],
  data() {
    return {
      transaction: {
        total: 0,
        results: [],
        statusTransaction: {
          approved: 0,
          payment_waiting: 0,
          rejected: 0
        }
      },
      pagination: {
        prev: '',
        next: '',
        last: '',
        current: '',
        path: this.url + '/customers/summary_transaction'
      }
    }
  },
  methods: {
    formatDate(str) {
      return moment(str).locale('id').format('DD MMMM YYYY');
    },
    summaryTransaction(pages)
    {
      if( pages === undefined )
        pages = this.url + '/customers/summary_transaction?page=1&rows=8';
      else pages = pages + '&rows=8';

      axios({
        method: 'get',
        url: pages,
        headers: { 'content-type': 'application/json' }
      }).then( res => {
        var result = res.data;
        this.transaction.total = result.data.transaction.total;
        this.transaction.results = result.data.transaction.data;
        this.transaction.statusTransaction = {
          approved: result.data.status_transaction.approved,
          payment_waiting: result.data.status_transaction.payment_waiting,
          rejected: result.data.status_transaction.rejected
        };
        this.pagination = {
          prev: result.data.transaction.prev_page_url,
          next: result.data.transaction.next_page_url,
          last: result.data.transaction.last_page,
          current: result.data.transaction.current_page,
          path: result.data.transaction.path
        };
        console.log(result);
      }).catch( err => {
        console.log(err.response.statusText);
      });
    }
  },
  mounted() {
    this.summaryTransaction();
  }
}
</script>
