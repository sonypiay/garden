<template lang="html">
  <div class="discovery-container">
    <div class="uk-grid-small uk-margin-large-top" uk-grid>
      <div class="uk-width-1-4">
        <h3 class="discovery_heading">Lokasi</h3>
        <div class="uk-width-1-1 uk-inline">
          <span class="uk-form-icon" uk-icon="search"></span>
          <input @keyup.enter="showKabupaten()" type="search" class="uk-width-1-1 uk-input uk-box-shadow-small searchkota" v-model="kabupaten.keywords" placeholder="Cari kota">
        </div>
        <nav class="uk-card uk-card-default uk-margin-small-top discoveryfilter">
          <ul class="uk-nav uk-nav-default" uk-nav>
            <li><a @click="showVendors( pagination.path + '?page=' + pagination.current + '&' )">Semua Kota</a></li>
            <li v-for="kab in kabupaten.results"><a @click="showVendors( pagination.path + '?page=' + pagination.current + '&', kab )">{{ kab.kabupaten }}</a></li>
          </ul>
        </nav>
      </div>
      <div class="uk-width-expand">
        <h3 class="discovery_heading">Vendor di {{ kabupaten.selectedName }}</h3>
        <div class="uk-margin-bottom discoverysearch">
          <div class="uk-width-1-2 uk-inline">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input @keyup.enter="showVendors( pagination.path + '?page=' + pagination.current + '&' )" type="text" class="uk-width-1-1 uk-box-shadow-medium uk-input searchdiscovery" v-model="searchKeywords" placeholder="Temukan Vendor">
          </div>
        </div>
        <div class="uk-grid-small uk-grid-match" uk-grid>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s" v-for="vendor in vendorsList.results">
            <div class="uk-card uk-card-default discoverygrid_box">
              <div class="uk-card-media-top discoverygrid_logo">
                <div v-if="vendor.vendor_logo">
                  <a :href="url + '/discovery/vendor/' + vendor.vendor_slug_name"><img :src="url + '/images/vendor/logobrand/' + vendor.vendor_logo" alt=""></a>
                </div>
                <div v-else>
                  <!--<img src="https://getuikit.com/assets/uikit/tests/images/photo.jpg" alt="">-->
                  <div class="uk-tile uk-tile-default discoverygrid_nologo">
                    <div class="uk-position-center">
                      <a :href="url + '/discovery/vendor/' + vendor.vendor_slug_name" uk-icon="icon: image; ratio: 4"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-card-body uk-card-small">
                <a :href="url + '/discovery/vendor/' + vendor.vendor_slug_name" class="uk-card-title discoverygrid_heading">{{ vendor.vendor_name }}</a>
                <div class="discoverygrid_subtext">{{ vendor.nama_kab }}</div>
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
  props: ['url'],
  data() {
    return {
      searchKeywords: '',
      kabupaten: {
        keywords: '',
        selectedValue: 'allcity',
        selectedName: 'Semua Kota',
        results: []
      },
      vendorsList: {
        total: 0,
        results: []
      },
      pagination: {
        prev: '',
        next: '',
        path: '',
        current: '',
        last_page: ''
      }
    }
  },
  methods: {
    showKabupaten() {
      var url;
      if( this.kabupaten.keywords === '' )
      {
        url = this.url + '/api/kabupaten/all';
      }
      else
      {
        url = this.url + '/api/kabupaten/search/' + this.kabupaten.keywords;
      }
      axios({
        method: 'get',
        url: url
      }).then( res => {
        let results = res.data;
        this.kabupaten.results = results.data;
      }).catch( err => {
        console.log(err.response.statusText);
      });
    },
    showVendors(pages, city) {
      if( city === undefined ) { this.kabupaten.selectedValue = 'allcity'; }
      else { this.kabupaten.selectedValue = city.kode; }

      var param = 'keywords=' + this.searchKeywords + '&city=' + this.kabupaten.selectedValue;
      if( pages === undefined )
        pages = this.url + '/discovery/vendors?page=1&' + param;
      else
        pages = pages + param;
      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.vendorsList.results = result.data;
        this.vendorsList.total = result.total;
        this.pagination = {
          prev: result.prev_page_url,
          next: result.next_page_url,
          last: result.last_page_url,
          path: result.path,
          current: result.current_page,
          last_page: result.last_page
        };

        if( this.kabupaten.selectedValue === 'allcity' )
        {
          this.kabupaten.selectedValue = 'allcity';
          this.kabupaten.selectedName = 'Semua Kota';
        }
        else
        {
          this.kabupaten.selectedValue = city.kode;
          this.kabupaten.selectedName = city.kabupaten;
        }
      }).catch( err => {
        console.log(err.response.statusText);
      });
    }
  },
  mounted() {
    this.showKabupaten();
    this.showVendors();
  }
}
</script>
