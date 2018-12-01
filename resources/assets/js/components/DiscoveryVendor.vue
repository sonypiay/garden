<template lang="html">
  <div class="discovery-container">
    <div class="discoverysearch">
      <div class="uk-width-1-1 uk-inline">
        <span class="uk-form-icon" uk-icon="search"></span>
        <input type="text" class="uk-width-1-1 uk-box-shadow-medium uk-input searchdiscovery" v-model="searchKeywords" placeholder="Temukan Vendor">
      </div>
    </div>

    <div class="uk-grid-medium uk-margin-large-top" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s" v-for="i in 10">
        <div class="uk-card uk-card-default">
          <div class="uk-card-media-top">
            <img src="https://getuikit.com/assets/uikit/tests/images/photo.jpg" alt="">
          </div>
          <div class="uk-card-body">
            <h3 class="uk-card-title">Media Top</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
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
      searchKeywords: '',
      vendorsList: {
        total: 0,
        results: []
      }
    }
  },
  mounted() {}
}
</script>

<style lang="css">
</style>
