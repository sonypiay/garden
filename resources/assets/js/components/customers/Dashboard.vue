<template lang="html">
  <div class="dashb_customer">
    <div class="uk-container">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-3-4@xl uk-width-3-4@xl uk-width-2-3@m uk-width-1-2@s">
          <div class="dash_customername">{{ customers.customer_name }}</div>
          <div class="dash_customerhistory">
            <span class="dash_historytransaction">5 Transaksi</span>
            <span class="dash_vendorpilihan">3 Vendor Pilihan</span>
          </div>
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
    </div>

    <div class="board_bookingvendor">
      <div class="uk-card uk-card-body uk-card-default board_listbookingvendor">
        <div class="uk-width-1-3 uk-align-center">
          <div class="board_neverbooking_icon">
            <span class="fas fa-leaf"></span>
          </div>
          <div class="board_neverbooking_text">Anda belum pernah memesan vendor disini</div>
          <div class="uk-text-center">
            <button class="uk-button board_bookbutton">Pesan sekarang juga</button>
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

    }
  },
  methods: {},
  mounted() {

  }
}
</script>
