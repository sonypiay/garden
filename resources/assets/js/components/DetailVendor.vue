<template lang="html">
  <div>
    <div id="viewportfolio" class="uk-modal-full" uk-modal>
      <div class="uk-modal-dialog">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-body modal_view_portfolio uk-height-viewport">
          <div class="uk-container">
            <h3 class="modal_view_portfolio_heading">{{ portfolio_image.portfolio.name }}</h3>
            <div v-if="portfolio_image.errorMessage" class="uk-alert-danger" uk-alert>{{ portfolio_image.errorMessage }}</div>
            <div class="modal_view_portfolio_content uk-height-large uk-overflow-auto">
              <div class="uk-grid-small" uk-grid="masonry: true" uk-lightbox="animation: slide">
                <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s" v-for="images in portfolio_image.results">
                  <a :href="url + '/images/vendor/portfolios/' + images.images_name">
                    <img :src="url + '/images/vendor/portfolios/' + images.images_name" :alt="images.images_name">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="modalchat" uk-modal>
      <div class="uk-modal-dialog uk-modal-body modal_chatcontainer">
        <h3 class="modal_chatheading">Kirim Pesan</h3>
        <form class="uk-form-stacked" @submit.prevent="onSendMessage">
          <div class="uk-margin">
            <label class="uk-form-label modal_chatlabel">Kepada</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input modal_chatform" :disabled="true" :value="vendors.vendor_name">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label modal_chatlabel">Pesan</label>
            <div class="uk-form-controls">
              <textarea class="uk-textarea modal_chatform uk-height-small" v-model="message.type" placeholder="Ketik pesan Anda disini"></textarea>
            </div>
            <div v-if="message.errors.type" class="uk-text-small uk-text-danger">{{ message.errors.type }}</div>
          </div>
          <div class="uk-margin">
            <button class="uk-button uk-button-default modal_chatbutton">Kirim Pesan</button>
          </div>
        </form>
      </div>
    </div>
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
          <div class="uk-card uk-card-body uk-card-small uk-card-default pb-badge-action" v-if="session.hasLoginCustomers">
            <div class="uk-margin-small">
              <button uk-toggle="target: #modalchat" class="uk-width-1-1 uk-button uk-button-default pb-btnaction"><span class="uk-margin-small-right"><i class="far fa-comment-alt"></i></span> Kirim Pesan</button>
            </div>
            <div class="uk-margin-small">
              <a :href="url + '/booking/' + vendors.vendor_slug_name" class="uk-width-1-1 uk-button uk-button-default pb-btnaction"><span class="uk-margin-small-right"><i class="far fa-bell"></i></span> Pesan</a>
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
        <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
        <div class="uk-card uk-card-body uk-card-small uk-card-default portfolio-vendor">
          <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-expand">
              Menampilkan halaman <strong>{{ pagination.current }}</strong> dari <strong>{{ pagination.last }}</strong>
            </div>
            <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
              <select class="uk-select pv-formperrow" v-model="selectedRows" @change="showPortfolio( pagination.path + '?page=' + pagination.current )">
                <option value="9">9 ditampilkan</option>
                <option value="18">18 ditampilkan</option>
                <option value="27">27 ditampilkan</option>
              </select>
            </div>
          </div>
          <div class="uk-grid-medium" uk-grid>
            <div v-if="portfolios.total === 0" class="uk-width-1-1">
              <div class="uk-width-1-1 uk-alert-warning" uk-alert>Belum ada portfolio</div>
            </div>
            <div v-else class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s" v-for="portfolio in portfolios.results">
              <div class="uk-card uk-card-default pv-thumbnail">
                <div class="uk-card-media-top pv-mediathumbnail">
                  <div v-if="portfolio.portfolio_thumbnail">
                    <div class="uk-inline uk-transition-toggle" tabindex="0">
                      <img :src="url + '/images/vendor/portfolios/' + portfolio.portfolio_thumbnail" alt="">
                      <a @click="viewPortfolioList(portfolio)" class="uk-overlay uk-overlay-primary uk-position-cover uk-light uk-transition-fade pv-iconoverlay">
                        <div class="uk-position-center">
                          <span uk-icon="icon: search; ratio: 2"></span>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div v-else>
                    <div class="uk-tile uk-tile-default pv-nothumbnail">
                      <div class="uk-position-center">
                        <a @click="viewPortfolioList(portfolio)" uk-icon="icon: image; ratio: 4"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-card-body uk-card-small pv-cardbody">
                  <div class="uk-card-title pv-title">{{ portfolio.portfolio_name }}</div>
                  <div class="pv-createdat">
                    {{ formatDate( portfolio.created_at, 'MMM DD, YYYY' ) }}
                  </div>
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
  props: ['url', 'vendors', 'session'],
  data() {
    return {
      selectedRows: 9,
      portfolios: {
        total: 0,
        results: []
      },
      portfolio_image: {
        total: 0,
        results: [],
        errorMessage: '',
        portfolio: {
          name: '',
          id: 0
        }
      },
      message: {
        type: '',
        errors: {}
      },
      pagination: {
        prev: '',
        next: '',
        last: '',
        current: '',
        path: ''
      },
      errorMessage: ''
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    viewPortfolioList(pf)
    {
      axios({
        method: 'get',
        url: this.url + '/discovery/vendor/portfolio_image/' + pf.portfolio_id
      }).then( res => {
        let result = res.data;
        this.portfolio_image = {
          total: result.total,
          results: result.results,
          portfolio: {
            name: pf.portfolio_name,
            id: pf.portfolio_id
          }
        };
        console.log( this.portfolio_image );
      }).catch( err => {
        this.portfolio_image.errorMessage = err.response.statusText;
      });
      UIkit.modal('#viewportfolio').show();
    },
    showPortfolio(pages)
    {
      var param = 'rows=' + this.selectedRows;
      if( pages === undefined )
        pages = this.url + '/discovery/vendor/portfolio/' + this.vendors.vendor_slug_name + '?page=' + this.pagination.current;
      else
        pages = pages + '&' + param;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.portfolios.total = result.total;
        this.portfolios.results = result.data;
        this.pagination = {
          prev: result.prev_page_url,
          next: result.next_page_url,
          last: result.last_page,
          current: result.current_page,
          path: result.path
        };
      }).catch( err => {
        this.errorMessage = err.response.statusText;
        console.log(err.response.statusText);
      });
    },
    onSendMessage() {
      if( this.message.type === null || this.message.type === '' )
      {
        this.message.errors.type = 'Pesan tidak boleh kosong';
      }
      else
      {
        axios({
          method: 'post',
          url: this.url + '/sendmessage',
          params: {
            vendor: this.vendors.vendor_id,
            customer: this.session.customer_id,
            message: this.message.type
          }
        }).then( res => {
          swal({
            title: 'Berhasil',
            text: 'Pesan terkirim',
            icon: 'success',
            timer: 3000
          });
        }).catch( err => {
          swal({
            title: 'Terjadi Kesalahan',
            text: err.response.statusText,
            icon: 'error',
            dangerMode: true,
            timer: 3000
          });
        });
      }
    }
  },
  mounted() {
    this.showPortfolio();
  }
}
</script>
