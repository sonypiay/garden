<template lang="html">
  <div>
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog uk-modal-body">
        <a class="uk-modal-close-default" uk-close></a>
        <h3>
          <span v-if="forms.edit">Ubah Gambar</span>
          <span v-else>Tambah Gambar</span>
        </h3>
        <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
        <form class="uk-form-action" @submit.prevent="addOrUpdateImages">
          <div class="uk-margin">
            <div v-if="forms.filename">
              <div v-if="forms.formdata">
                <img class="uk-width-1-3" :src="forms.filename" />
              </div>
              <div v-else>
                <img class="uk-width-1-3" :src="url + '/images/vendor/portfolios/' + forms.filename" :alt="portfolio.portfolio_slug_name">
              </div>
            </div>
            <div v-else>
              <div v-if="forms.formdata">
                <img class="uk-width-1-3" :src="forms.filename" />
              </div>
              <div v-else>
                <div class="uk-width-1-3 uk-tile uk-tile-muted">
                  <div class="uk-position-center uk-text-center">
                    JPG / PNG <br /> 2 MB
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <div uk-form-custom="target: true">
                <input type="file" id="selectedFile" @change="selectedFile">
                <input class="uk-input" type="text" placeholder="Select file" disabled>
              </div>
            </div>
            <div v-if="errors.filename" class="uk-text-danger uk-text-small">{{ errors.filename }}</div>
          </div>
          <div class="uk-margin">
            <label v-if="forms.thumbnail === 'Y' && forms.thumbnail !== ''"><input class="uk-checkbox uk-margin-small-right" type="checkbox" value="Y" v-model="forms.thumbnail" checked /> Tandai sebagai thumbnail</label>
            <label v-else><input class="uk-checkbox uk-margin-small-right" type="checkbox" value="Y" v-model="forms.thumbnail" /> Tandai sebagai thumbnail</label>
          </div>
          <div class="uk-margin">
            <button v-html="forms.submit" class="uk-button uk-button-default btn_settingaction">Tambah</button>
          </div>
        </form>
      </div>
    </div>
    <div class="uk-margin">
      <h2>Foto</h2>
    </div>
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
        <select class="uk-width-1-1 uk-select form-settingaction" v-model="selectedRows" @change="showPortfolio( pagination.path + '?page=' + pagination.current )">
          <option value="9">9 ditampilkan</option>
          <option value="18">18 ditampilkan</option>
          <option value="27">27 ditampilkan</option>
        </select>
      </div>
      <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-4@m uk-width-1-2@s">
        <button @click="addOrUpdateModal()" class="uk-width-1-1 uk-button uk-button-default btn_settingaction">Tambah</button>
      </div>
    </div>
    <div class="uk-grid-small" uk-grid="masonry: true">
      <div class="uk-width-1-4@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-2@s" v-for="img in portfolioimage.results">
        <div class="uk-card uk-card-default plbox">
          <div class="uk-card-media-top plbox-media">
            <img :src="url + '/images/vendor/portfolios/' + img.images_name" :alt="portfolio.portfolio_name">
          </div>
          <div class="uk-card-body uk-card-small">
            <div class="plbox_action">
              <div class="uk-grid-collapse" uk-grid>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="" class="uk-button uk-button-default uk-button-small plgrid_btnaction" uk-tooltip="title: Lihat">
                    <span uk-icon="grid"></span>
                    <div>Lihat</div>
                  </button>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="addOrUpdateModal(img)" class="uk-button uk-button-default uk-button-small plgrid_btnaction" uk-tooltip="title: Sunting">
                    <span uk-icon="pencil"></span>
                    <div>Sunting</div>
                  </button>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-text-center">
                  <button @click="" class="uk-text-center uk-button uk-button-default uk-button-small plgrid_btnaction" uk-tooltip="title: Hapus">
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
  props: ['url', 'portfolio'],
  data() {
    return {
      selectedRows: 9,
      portfolioimage: {
        total: 0,
        results: []
      },
      pagination: {
        prev: '',
        next: '',
        last: '',
        current: '',
        path: this.url + '/vendor/portfolio/view/' + this.portfolio.portfolio_slug_name
      },
      forms: {
        submit: 'Tambah',
        error: false,
        edit: false,
        id: '',
        filename: '',
        formdata: '',
        thumbnail: ''
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    showPortfolio(pages) {
      if( pages === undefined )
      {
        pages = this.url + '/vendor/portfolio/view/' + this.portfolio.portfolio_slug_name + '/list?page=1';
      }
      else
      {
        pages = pages + '&rows=' + this.selectedRows;
      }

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.portfolioimage.total = result.total;
        this.portfolioimage.results = result.data;
        this.pagination = {
          prev: result.prev_page_url,
          next: result.next_page_url,
          last: result.last_page,
          current: result.current_page,
          path: result.path
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    addOrUpdateModal(images) {
      if( images === undefined )
      {
        this.forms.submit = 'Tambah';
        this.forms.id = '';
        this.forms.filename = '';
        this.forms.thumbnail = '';
        this.forms.edit = false;
      }
      else
      {
        this.forms.submit = 'Ubah';
        this.forms.id = images.images_id;
        this.forms.filename = images.images_name;
        if( images.thumbnail === 'N' )
        {
          this.forms.thumbnail = false;
        }
        else
        {
          this.forms.thumbnail = true;
        }
        this.forms.edit = true;
      }

      this.forms.formdata = '';
      this.forms.error = false;
      this.errorMessage = '';
      this.errors = {};
      UIkit.modal('#modal').show();
      console.log(this.forms);
    },
    addOrUpdateImages() {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.filename === '' )
      {
        this.errors.filename = 'Silahkan masukkan gambar terlebih dahulu.';
        this.forms.error = true;
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      var url;
      if( this.forms.edit === true )
      {
        url = this.url + '/vendor/portfolio/update/image/' + this.forms.id;
      }
      else
      {
        url = this.url + '/vendor/portfolio/add/image';
      }

      var formdata = new FormData();
      formdata.append('filename', this.forms.formdata);
      formdata.append('portfolio_id', this.portfolio.portfolio_id);
      formdata.append('thumbnail', this.forms.thumbnail);
      this.forms.submit = '<span uk-spinner></span>';

      axios.post( url, formdata ).then( res => {
        let result = res.data;
        swal({
          title: 'Berhasil',
          text: result.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errorMessage = '';
        this.errors = {};
        this.showPortfolio();
        setTimeout(function(){ UIkit.modal('#modal').hide(); }, 3000);
      }).catch( err => {
        this.forms.submit = 'Tambah';
        if( this.forms.edit === true ) this.forms.submit = 'Simpan';
        this.errorMessage = err.response.status + ' ' + err.response.statusText;
      });
    },
    getFormatFile(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    selectedFile(event) {
      this.errorMessage = '';
      this.forms.formdata = event.target.files[0];
      if( this.getFormatFile( this.forms.formdata.name ) !== 'png' && this.getFormatFile( this.forms.formdata.name ) !== 'jpg' && this.getFormatFile( this.forms.formdata.name ) !== 'jpeg' )
      {
        this.forms.formdata = '';
        this.errorMessage = 'Format file hanya JPG/PNG';
      }
      else
      {
        this.forms.filename = URL.createObjectURL(this.forms.formdata);
        console.log(this.forms);
      }
    }
  },
  mounted() {
    this.showPortfolio();
  }
}
</script>
