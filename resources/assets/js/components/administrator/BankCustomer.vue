<template lang="html">
<div class="uk-margin-large-top uk-margin-large-bottom">
  <div id="addOrUpdate" uk-modal>
    <div class="uk-modal-dialog">
      <a class="uk-modal-close-default" uk-close></a>
      <div class="uk-modal-body">
        <h3>
          <span v-if="forms.edit">Ubah Bank</span>
          <span v-else>Tambah Bank</span>
        </h3>
        <form class="uk-form-stacked" @submit.prevent="addOrUpdateBank">
          <div class="uk-margin">
            <label class="uk-form-label">Nama Bank *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input form-action-custom-modal" v-model="forms.name">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Kode Bank *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input form-action-custom-modal" v-model="forms.code">
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Logo Bank *</label>
            <div class="uk-form-controls">
              <div uk-form-custom="target: true">
                <input type="file" id="selectedFile" @change="selectedFile">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
              </div>
              <div class="uk-text-small"><i>Upload format JPG atau PNG</i></div>
            </div>
          </div>
          <div class="uk-margin">
            <button v-html="submitBtn" class="uk-button uk-button-default button-action-modal"></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="uk-card uk-card-body uk-card-default">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <div class="uk-width-1-1 uk-inline">
          <a class="uk-form-icon" uk-icon="search" @click="getBankList( pagination.path + '?page=' + pagination.current )"></a>
          <input @keyup.enter="getBankList( pagination.path + '?page=' + pagination.current )" type="keywords" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Search...">
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <a class="uk-button button-custom-action" @click="addOrUpdateBtn()">Tambah</a>
      </div>
    </div>

    <div class="uk-overflow-auto uk-margin-top">
      <table class="uk-table uk-table-small uk-table-divider uk-table-middle table-rows">
        <thead>
          <tr>
            <th>#</th>
            <th>Kode Bank</th>
            <th>Nama Bank</th>
            <th>Logo Bank</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="bank in banklist.results">
            <td class="uk-width-small">
              <a @click="addOrUpdateBtn(bank)" uk-icon="pencil" class="uk-button uk-button-text" uk-tooltip title="Ubah" href="#"></a>
              <a @click="deleteBankList(bank.bank_id)" uk-icon="trash" class="uk-button uk-button-text" uk-tooltip title="Hapus" href="#"></a>
            </td>
            <td class="uk-width-small">{{ bank.bank_code }}</td>
            <td>{{ bank.bank_name }}</td>
            <td>
              <img class="uk-width-1-6" :src="url.replace('/cp/management', '') + '/images/bankcustomer/' + bank.bank_logo" :alt="bank.bank_name">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        id: '',
        name: '',
        code: '',
        logo: '',
        edit: false
      },
      submitBtn: 'Tambah',
      banklist: {
        total: 0,
        results: []
      },
      keywords: '',
      pagination: {
        current: 1,
        prev: '',
        next: '',
        last: '',
        path: this.url + '/bankcustomer'
      }
    }
  },
  methods: {
    addOrUpdateBtn(d) {
      if( d === undefined )
      {
        this.forms = {
          id: '',
          name: '',
          code: '',
          logo: '',
          edit: false
        };
        this.submitBtn = 'Tambah';
      }
      else
      {
        this.forms = {
          id: d.bank_id,
          name: d.bank_name,
          code: d.bank_code,
          logo: '',
          edit: true
        };
        this.submitBtn = 'Simpan';
      }
      $("#selectedFile").val('');
      UIkit.modal('#addOrUpdate').show();
    },
    addOrUpdateBank() {
      if( this.forms.name === '' )
      {
        swal({
          title: 'Warning',
          text: 'Silahkan masukkan nama bank',
          icon: 'warning',
          dangerMode: true
        });
      }
      else if( this.forms.code === '' )
      {
        swal({
          title: 'Warning',
          text: 'Silahkan masukkan kode bank',
          icon: 'warning',
          dangerMode: true
        });
      }
      else
      {
        if( this.forms.edit === false )
        {
          if( this.forms.logo === '' )
          {
            swal({
              title: 'Warning',
              text: 'Silahkan masukkan logo bank',
              icon: 'warning',
              dangerMode: true
            });
          }
          else
          {
            if( this.getFormatFile( this.forms.logo.name ) !== 'jpg' && this.getFormatFile( this.forms.logo.name ) !== 'png' )
            {
              swal({
                title: 'Warning',
                text: 'Format gambar hanya JPG atau PNG',
                icon: 'warning',
                dangerMode: true
              });
              return false;
            }
            const formfile = new FormData();
            formfile.append('bank_code', this.forms.code);
            formfile.append('bank_name', this.forms.name);
            formfile.append('bank_logo', this.forms.logo, this.forms.logo.name);
            axios.post( this.url + '/bankcustomer/add', formfile).then( res => {
              swal({
                title: 'Berhasil',
                text: res.data.statusText,
                icon: 'success'
              });
              this.getBankList();
              setTimeout(function(){ UIkit.modal('#addOrUpdate').hide(); }, 3000);
            }).catch( err => {
              if( err.response.status === 500 )
              {
                swal({
                  title: 'Whoops',
                  text: err.response.statusText,
                  icon: 'error',
                  dangerMode: true
                });
              }
              else
              {
                swal({
                  title: 'Whoops',
                  text: err.response.data.statusText,
                  icon: 'error',
                  dangerMode: true
                });
              }
            });
          }
        }
        else
        {
          if( this.forms.logo !== '' )
          {
            if( this.getFormatFile( this.forms.logo.name ) !== 'jpg' && this.getFormatFile( this.forms.logo.name ) !== 'png' )
            {
              swal({
                title: 'Warning',
                text: 'Format gambar hanya JPG atau PNG',
                icon: 'warning',
                dangerMode: true
              });
              return false;
            }
          }

          const formfile = new FormData();
          formfile.append('bank_code', this.forms.code);
          formfile.append('bank_name', this.forms.name);
          formfile.append('bank_logo', this.forms.logo, this.forms.logo.name);
          axios.post( this.url + '/bankcustomer/update/' + this.forms.id, formfile).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getBankList();
            setTimeout(function(){ UIkit.modal('#addOrUpdate').hide(); }, 3000);
          }).catch( err => {
            if( err.response.status === 500 )
            {
              swal({
                title: 'Whoops',
                text: err.response.statusText,
                icon: 'error',
                dangerMode: true
              });
            }
            else
            {
              swal({
                title: 'Whoops',
                text: err.response.data.statusText,
                icon: 'error',
                dangerMode: true
              });
            }
          });
        }
      }
    },
    deleteBankList(id) {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus bank ini?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: true,
          confirm: {
            text: 'Hapus',
            value: true
          }
        }
      }).then( res => {
        if( res )
        {
          axios({
            method: 'delete',
            url: this.url + '/bankcustomer/delete/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getBankList();
          }).catch( err => {
            if( err.response.status === 500 )
            {
              swal({
                title: 'Whoops',
                text: err.response.statusText,
                icon: 'error',
                dangerMode: true
              });
            }
            else
            {
              swal({
                title: 'Whoops',
                text: err.response.data.statusText,
                icon: 'error',
                dangerMode: true
              });
            }
          });
        }
      });
    },
    getBankList(pages) {
      var params = '&keywords=' + this.keywords + ''
      if( pages === undefined )
        pages = this.url + '/bankcustomer/banklist?page=' + this.pagination.current + params;
      else
        pages = pages + params;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let results = res.data;
        this.banklist = {
          total: results.total,
          results: results.data
        };
        this.pagination = {
          current: results.current_page,
          prev: results.prev_page_url,
          next: results.next_page_url,
          last: results.last_page,
          path: results.path
        };
      }).catch( err => {
        console.log(err.response.statusText);
      })
    },
    getFormatFile(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    selectedFile(event) {
      this.forms.logo = event.target.files[0];
    }
  },
  mounted() {
    this.getBankList();
  }
}
</script>
