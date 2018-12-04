<template lang="html">
  <div>
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog uk-modal-body">
        <a class="uk-modal-close-default" uk-close></a>
        <h3>
          <span v-if="forms.edit">Sunting Portfolio</span>
          <span v-else>Tambah Portfolio</span>
        </h3>
        <form class="uk-form-stacked" @submit.prevent="addOrUpdatePortfolio">
          <div class="uk-margin">
            <label class="uk-form-label form-settinglabel">Nama Portfolio</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.namaportfolio">
            </div>
          </div>
          <div class="uk-margin">
            <button class="uk-button uk-button-default btn_settingaction" v-html="forms.submit">Tambah</button>
          </div>
        </form>
      </div>
    </div>
    <div class="uk-margin">
      <h2>Portfolio</h2>
    </div>
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
        <div class="uk-width-1-1 uk-inline">
          <span class="uk-form-icon" uk-icon="search"></span>
          <input type="search" class="uk-width-1-1 uk-input form-settingaction" placeholder="Cari nama portfolio">
        </div>
      </div>
      <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-6@m uk-width-1-1@s">
        <select class="uk-select form-settingaction" v-model="forms.selectedRows">
          <option value="9">9 ditampilkan</option>
          <option value="18">18 ditampilkan</option>
          <option value="27">27 ditampilkan</option>
        </select>
      </div>
      <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@s uk-width-1-1@s">
        <button @click="addOrUpdateModal()" class="uk-button uk-button-default buttonaction" v-html="forms.submit">Tambah Portfolio</button>
      </div>
    </div>
    <div class="uk-grid-small uk-grid-match" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s" v-for="portfolio in portfolios.results">
        <div class="uk-card uk-card-default portfoliogrid_box">
          <div class="uk-card-media-top">
            <div v-if="portfolio.portfolio_thumbnail">
              <img :src="url + '/images/vendor/portfolios/' + portfolio.portfolio_thumbnail" alt="">
            </div>
            <div v-else>
              <img src="https://getuikit.com/assets/uikit/tests/images/photo.jpg" alt="">
            </div>
          </div>
          <div class="uk-card-body uk-card-small">
            <h3 class="uk-card-title portfoliogrid_heading">{{ portfolio.portfolio_name }}</h3>
            <div class="portfoliogrid_action">
              <div class="uk-grid-collapse" uk-grid>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="viewPortfolio( portfolio.portfolio_slug_name )" class="uk-button uk-button-default uk-button-small portfoliogrid_btnaction" uk-tooltip="title: Lihat">
                    <span uk-icon="grid"></span>
                    <div>Lihat</div>
                  </button>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="addOrUpdateModal(portfolio)" class="uk-button uk-button-default uk-button-small portfoliogrid_btnaction" uk-tooltip="title: Sunting">
                    <span uk-icon="pencil"></span>
                    <div>Sunting</div>
                  </button>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="deletePortfolio(portfolio.portfolio_id, portfolio.portfolio_name)" class="uk-text-center uk-button uk-button-default uk-button-small portfoliogrid_btnaction" uk-tooltip="title: Hapus">
                    <span uk-icon="trash"></span>
                    <div>Hapus</div>
                  </button>
                </div>
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
      keywords: '',
      forms: {
        selectedRows: 9,
        id: 0,
        namaportfolio: '',
        submit: 'Tambah',
        error: false,
        edit: false
      },
      errorMessage: '',
      errors: {},
      portfolios: {
        total: 0,
        results: []
      },
      pagination: {
        prev: '',
        next: '',
        last: '',
        current: '',
        path: this.url + '/vendor/portfolio/list'
      }
    }
  },
  methods: {
    addOrUpdateModal(portfolio) {
      if( portfolio === undefined )
      {
        this.forms.id = '';
        this.forms.namaportfolio = '';
        this.forms.submit = 'Tambah';
        this.forms.error = false;
        this.forms.edit = false;
      }
      else
      {
        this.forms.id = portfolio.portfolio_id;
        this.forms.namaportfolio = portfolio.portfolio_name;
        this.forms.submit = 'Simpan';
        this.forms.error = true;
        this.forms.edit = true;
      }
      this.errorMessage = '';
      this.errors = {};
      UIkit.modal('#modal').show();
    },
    showPortfolio(pages) {
      var url;
      var param = '&keywords=' + this.keywords + '&rows=' + this.forms.selectedRows;
      if( pages === undefined )
      {
        url = this.url + '/vendor/portfolio/list?page=1' + param;
      }
      else
      {
        url = pages + param;
      }

      axios({
        method: 'get',
        url: url
      }).then( res => {
        let result = res.data;
        this.portfolios.results = result.data;
        this.portfolios.total = result.total;
        this.pagination = {
          prev: result.prev_page_url,
          next: result.next_page_url,
          last: result.last_page,
          current: result.current_page,
          path: result.path
        };
      }).catch( err => {
        console.log(err.response.statusText);
      });
    },
    addOrUpdatePortfolio() {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.namaportfolio === '' )
      {
        this.errors.namaportfolio = 'Nama portfolio wajib diisi.';
        this.forms.error = true;
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      var method, url;
      if( this.forms.edit === true )
      {
        method = 'put';
        url = this.url + '/vendor/portfolio/update/' + this.forms.id;
      }
      else
      {
        method = 'post';
        url = this.url + '/vendor/portfolio/add';
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: method,
        url: url,
        params: {
          namaportfolio: this.forms.namaportfolio
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errors = {};
        this.errorMessage = '';
        setTimeout(function() {
          UIkit.modal('#modal').hide();
        }, 3000);
        this.showPortfolio();
      }).catch( err => {
        this.errorMessage = err.response.statusText;
        swal({
          title: 'Terjadi kesalahan',
          text: this.errorMessage,
          icon: 'error',
          dangerMode: true,
          timer: 5000
        });
        this.forms.submit = 'Tambah';
        if( this.forms.edit === true ) this.forms.submit = 'Simpan';
      });
    },
    deletePortfolio(id, val) {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus portfolio ' + val + '?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: 'Batal',
          confirm: { value: true, text: 'Hapus' }
        }
      }).then( value => {
        if( value )
        {
          axios({
            method: 'delete',
            url: this.url + '/vendor/portfolio/delete/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: val + ' berhasil dihapus',
              icon: 'success',
              timer: 5000
            });
            this.showPortfolio();
          }).catch( err => {
            swal({
              title: 'Terjadi kesalahan',
              text: err.response.statusText,
              icon: 'error',
              dangerMode: true
            });
          });
        }
      });
    },
    viewPortfolio(portfolio)
    {
      var redirect = this.url + '/vendor/portfolio/view/' + portfolio;
      document.location = redirect;
    }
  },
  mounted() {
    this.showPortfolio();
  }
}
</script>
