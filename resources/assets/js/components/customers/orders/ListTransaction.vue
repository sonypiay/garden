<template lang="html">
  <div class="uk-margin-large-top">
    <div class="uk-grid-small" uk-grid>
      <!--<div class="uk-width-1-6@xl uk-width-1-6@l">
        <div class="filter-statustransaction-label">Filter Status</div>
      </div>-->
      <div class="uk-width-expand">
        <div class="filter-statustransaction-list">
          <a v-for="(status, index) in $root.statusTransaction" @click="myTransaction( url + '/customers/data_orderlist?page=' + pagination.current, index  )" class="uk-button uk-button-default">{{ status }}</a>
        </div>
      </div>
    </div>
    <div class="uk-card uk-card-body uk-card-default uk-margin-top orderlist_content">
      <div v-if="isLoading" class="uk-text-center uk-margin-bottom">
        <span uk-spinner></span>
      </div>
      <div class="uk-grid-small" uk-grid="masonry: true">
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-2@s" v-for="result in transaction.results">
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
              <div class="dash_sum-transaction-orderdate">{{ formatDate( result.schedule_date ) }}</div>
              <a v-if="result.last_status_transaction === 'approval' || result.last_status_transaction === 'payment_waiting'" class="uk-display-block uk-margin-top dash_sum-transaction-view" :href="url + '/customers/main_orders/' + result.transaction_id">Lihat rincian</a>
              <a v-else class="uk-display-block uk-margin-top dash_sum-transaction-view" :href="url + '/customers/summary_order/' + result.transaction_id">Konfirmasi</a>
            </div>
          </div>
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
      isLoading: false,
      transaction: {
        total: 0,
        results: []
      },
      pagination: {
        prev: '',
        next: '',
        last: '',
        current: '',
        path: this.url + '/customers/data_orderlist'
      }
    }
  },
  methods: {
    formatDate(str) {
      return moment(str).locale('id').format('DD MMMM YYYY');
    },
    myTransaction(pages, status) {
      var param = '&rows=12&status=' + status;
      if( pages === undefined || pages === '' )
        pages = this.url + '/customers/data_orderlist?page=1' + param;
      else
        pages = pages + param;

      this.isLoading = true;
      axios({
        method: 'get',
        url: pages
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
        this.isLoading = false;
      }).catch( err => {
        console.log(err.response.statusText);
      });
    }
  },
  mounted() {
    this.myTransaction('', 'all');
  }
}
</script>
