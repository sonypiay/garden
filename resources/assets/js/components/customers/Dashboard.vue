<template lang="html">
  <div class="dashb_customer">
    <div class="uk-container">
      <div class="dash_customername">{{ customers.customer_name }}</div>
      <div class="dash_customerhistory">
        <span class="dash_historytransaction">5 Transaksi</span>
        <span class="dash_vendorpilihan">3 Vendor Pilihan</span>
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
        <div class="uk-width-1-3 uk-align-center">
          <div class="board_neverbooking_icon">
            <span class="fas fa-leaf"></span>
          </div>
          <div class="board_neverbooking_text">Anda belum pernah memesan vendor disini</div>
          <div class="uk-text-center">
            <a :href="url + '/discovery'" class="uk-button uk-button-default uk-button-large board_bookbutton">Pesan sekarang juga</a>
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
        results: []
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
    summaryTransaction(pages)
    {
      if( pages === undefined )
        pages = this.url + '/customers/summary_transaction?page=1&rows=6';
      else pages = pages + '&rows=6';

      axios({
        method: 'get',
        url: pages,
        headers: { 'content-type': 'application/json' }
      }).then( res => {
        var result = res.data;
        this.transaction.total = result.total;
        this.transaction.results = result.data;
        this.pagination = {
          prev: result.prev_page_url,
          next: result.next_page_url,
          last: result.last_page,
          current: result.current_page,
          path: result.path
        };
        console.log(this.transaction);
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
