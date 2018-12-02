<template lang="html">
  <div>
    <div class="uk-grid-small uk-margin-large-top" uk-grid>
      <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-1@s">
        <div class="profile-badge-container">
          <div class="uk-card uk-card-body uk-card-small uk-card-default pb-badge-header">
            <div v-if="vendors.vendor_logo" class="uk-align-center">
              <img :src="url + '/images/vendor/logobrand/' + vendors.vendor_logo" alt="">
            </div>
            <div v-else class="uk-text-center uk-align-center">
              <span uk-icon="icon: image; ratio: 4"></span>
            </div>
            <div class="uk-margin">
              <div class="pb-badge-vendorname">
                <a :href="url + '/discovery/vendor/' + vendors.vendor_slug_name">{{ vendors.vendor_name }}</a>
              </div>
              <div class="pb-badge-vendorlocation">{{ vendors.nama_kab }}</div>
            </div>
          </div>
          <div class="uk-card uk-card-body uk-card-small uk-card-default pb-badge-action">
            <div class="uk-margin-small">
              <button class="uk-width-1-1 uk-button uk-button-default pb-btnaction"><span class="uk-margin-small-right"><i class="far fa-comment-alt"></i></span> Kirim Pesan</button>
            </div>
            <div class="uk-margin-small">
              <button class="uk-width-1-1 uk-button uk-button-default pb-btnaction"><span class="uk-margin-small-right"><i class="far fa-bell"></i></span> Pesan</button>
            </div>
          </div>
          <div class="uk-card uk-card-body uk-card-small uk-card-default pb-badge-info">
            <ul class="uk-list pb-listinfo">
              <li>
                <span class="uk-margin-small-right" uk-icon="mail"></span>
                {{ vendors.vendor_email_business }}
              </li>
              <li>
                <span class="uk-margin-small-right" uk-icon="receiver"></span>
                +{{ vendors.vendor_mobile_business }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-card uk-card-body uk-card-small uk-card-default portfolio-vendor">
          <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s" v-for="i in 12">
              <div class="uk-card uk-card-default pv-images">
                <img src="https://getuikit.com/assets/uikit/tests/images/photo.jpg" alt="">
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
  props: ['url', 'vendors'],
  data() {
    return {

    }
  },
  methods: {},
  mounted() {}
}
</script>
