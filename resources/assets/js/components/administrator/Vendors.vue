<template lang="html">
  <div class="uk-margin-large-top">
    <h3 class="">Vendor</h3>
    <div class="uk-card uk-card-body uk-card-default">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
          <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input @keyup.enter="getVendors( pagination.path + '?page=' + pagination.current )" type="text" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Cari...">
          </div>
        </div>
        <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select form-select" v-model="selectedRows" @change="getVendors( pagination.path + '?page=' + pagination.current )">
            <option value="10">10 ditampilkan</option>
            <option value="20">20 ditampilkan</option>
            <option value="30">30 ditampilkan</option>
            <option value="50">50 ditampilkan</option>
            <option value="100">100 ditampilkan</option>
          </select>
        </div>
        <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@s uk-width-1-3@s">
          <select class="uk-select form-select" v-model="selectKabupaten" @change="getVendors( pagination.path + '?page=' + pagination.current )">
            <option value="all">-- Semua Kota --</option>
            <option v-for="kab in kabupaten" :value="kab.id_kab">{{ kab.nama_kab }}</option>
          </select>
        </div>
      </div>

      <div class="uk-margin-top">
        <div class="uk-label">{{ vendors.total }} Vendor</div>
        <div class="uk-overflow-auto uk-margin-top">
          <table class="uk-table uk-table-small uk-table-divider uk-table-middle uk-table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>ID</th>
                <th>Nama Vendor</th>
                <th>Pemilik</th>
                <th>No Telepon</th>
                <th>Email</th>
                <th>Kota</th>
                <th>Tanggal Bergabung</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="vendor in vendors.results">
                <td>
                  <button class="uk-button uk-button-text" uk-icon="cog" uk-tooltip="title: Lihat Detail; pos: right"></button>
                </td>
                <td>{{ vendor.vendor_id }}</td>
                <td>{{ vendor.vendor_name }}</td>
                <td>{{ vendor.vendor_ownername }}</td>
                <td>{{ vendor.vendor_mobile_private }}</td>
                <td>{{ vendor.vendor_email_business }}</td>
                <td>{{ vendor.nama_kab }}</td>
                <td>{{ formatDate( vendor.vendor_registered ) }}</td>
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
  props: ['url','kabupaten'],
  data() {
    return {
      vendors: {
        total: 0,
        results: []
      },
      pagination: {
        current: 1,
        next: '',
        prev: '',
        last: 1,
        path: this.url + '/vendor/list'
      },
      keywords: '',
      selectedRows: 10,
      selectKabupaten: 'all'
    }
  },
  methods: {
    formatDate(str) {
      return moment(str).locale('id').format('MMM DD, YYYY HH:mm');
    },
    getVendors(pages)
    {
      var param = '&keywords=' + this.keywords + '&rows=' + this.selectedRows + '&kabupaten=' + this.selectKabupaten;
      if( pages === undefined )
        pages = this.url + '/vendor/list?page=' + this.pagination.current + param;
      else
        pages = pages + param;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.vendors.total = result.total;
        this.vendors.results = result.data;
        console.log( result );
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getVendors();
  }
}
</script>
