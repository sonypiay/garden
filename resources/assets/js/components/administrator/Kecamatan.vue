<template lang="html">
<div class="uk-margin-large-top uk-margin-large-bottom">
  <div id="modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <a class="uk-modal-close-default" uk-close></a>
      <h3>
        <span v-if="forms.edit">Ubah Kecamatan</span>
        <span v-else>Tambah Kecamatan</span>
      </h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-stacked" @submit.prevent="addOrUpdateKecamatan">
        <div class="uk-margin">
          <label class="uk-form-label">Kode Kecamatan</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.kode">
          </div>
          <div v-if="forms.errors.kode" class="uk-text-small uk-text-danger">{{ forms.errors.kode }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label">Nama Kecamatan</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.nama">
          </div>
          <div v-if="forms.errors.nama" class="uk-text-small uk-text-danger">{{ forms.errors.nama }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label">Kabupaten</label>
          <div class="uk-form-controls">
            <select class="uk-width-1-1 uk-select form-action-select-modal" v-model="forms.kabupaten">
              <option value="" selected>-- Pilih Kabupaten --</option>
              <option v-for="kab in kabupaten" :value="kab.id_kab">{{ kab.nama_kab }}</option>
            </select>
          </div>
          <div v-if="forms.errors.kabupaten" class="uk-text-small uk-text-danger">{{ forms.errors.kabupaten }}</div>
        </div>
        <div class="uk-margin">
          <button class="uk-button uk-button-default button-action-modal" v-html="forms.submit"></button>
        </div>
      </form>
    </div>
  </div>

  <div class="uk-card uk-card-body uk-card-default">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <div class="uk-width-1-1 uk-inline">
          <a class="uk-form-icon" uk-icon="search" @click="getKecamatanList( pagination.path + '?page=' + pagination.current )"></a>
          <input @keyup.enter="getKecamatanList( pagination.path + '?page=' + pagination.current )" type="keywords" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Search...">
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <a class="uk-button button-custom-action" @click="addOrUpdateModal()">Tambah</a>
      </div>
    </div>

    <div class="uk-overflow-auto uk-margin-top">
      <table class="uk-table uk-table-small uk-table-divider uk-table-middle table-rows">
        <thead>
          <tr>
            <th>#</th>
            <th>Kode Kecamatan</th>
            <th>Nama Kecamatan</th>
            <th>Kabupaten</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="kec in kecamatan.results">
            <td class="uk-width-small">
              <a @click="addOrUpdateModal(kec)" uk-icon="pencil" class="uk-button uk-button-text" uk-tooltip title="Ubah" href="#"></a>
              <a @click="deleteKecamatan(kec.id_kec, kec.nama_kec)" uk-icon="trash" class="uk-button uk-button-text" uk-tooltip title="Hapus" href="#"></a>
            </td>
            <td class="uk-width-small">{{ kec.kode_kec }}</td>
            <td>{{ kec.nama_kec }}</td>
            <td>{{ kec.nama_kab }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'kabupaten'],
  data() {
    return {
      keywords: '',
      pagination: {
        current: 1,
        prev: '',
        next: '',
        last: '',
        path: this.url + '/kecamatan/data_kecamatan'
      },
      kecamatan: {
        total: 0,
        results: []
      },
      forms: {
        id: 0,
        kode: '',
        nama: '',
        kabupaten: '',
        edit: false,
        errors: {},
        submit: 'Tambah'
      },
      errorMessage: ''
    }
  },
  methods: {
    addOrUpdateModal(kec)
    {
      if( kec === undefined || kec === '' )
      {
        this.forms.id = 0;
        this.forms.kode = '';
        this.forms.nama = '';
        this.forms.kabupaten = '';
        this.forms.edit = false;
        this.forms.errors = {};
        this.forms.submit = 'Tambah';
      }
      else
      {
        this.forms.id = kec.id_kec;
        this.forms.kode = kec.kode_kec;
        this.forms.nama = kec.nama_kec;
        this.forms.kabupaten = kec.id_kab;
        this.forms.edit = true;
        this.forms.errors = {};
        this.forms.submit = 'Simpan';
      }
      this.errorMessage = '';
      UIkit.modal('#modal').show();
    },
    getKecamatanList(pages)
    {
      var params = '&keywords=' + this.keywords;
      if( pages === undefined )
        pages = this.url + '/kecamatan/data_kecamatan?page=' + this.pagination.current + params;
      else
        pages = pages + params;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.kecamatan.total = result.total;
        this.kecamatan.results = result.data;
      }).catch( err => {
        console.log(err.response.status);
      })
    },
    addOrUpdateKecamatan()
    {
      this.forms.errors = {};
      if( this.forms.kode === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.kode = 'Kode kecamatan wajib diisi.';
      }
      if( this.forms.nama === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.nama = 'Nama kecamatan wajib diisi.';
      }
      if( this.forms.kabupaten === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.kabupaten = 'Kabupaten wajib diisi.';
      }
      if( this.forms.errors.error === true )
      {
        this.forms.errors.error = false;
        return false;
      }

      var method, url;
      if( this.forms.edit === false )
      {
        method = 'post'; url = this.url + '/kecamatan/add';
      }
      else
      {
        method = 'put'; url = this.url + '/kecamatan/update/' + this.forms.id;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: method,
        url: url,
        params: {
          kode_kec: this.forms.kode,
          nama_kecamatan: this.forms.nama,
          kabupaten: this.forms.kabupaten
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errorMessage = '';
        this.getKecamatanList();
        setTimeout(function(){ UIkit.modal('#modal').hide(); }, 3000);
      }).catch( err => {
        let status = err.response.status;
        if( status === 409 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = err.response.statusText;
        }
        swal({
          title: 'Terjadi kesalahan',
          text: this.errorMessage,
          icon: 'warning',
          dangerMode: true
        });
      });

      if( this.forms.edit === true ) this.forms.submit = 'Simpan';
    },
    deleteKecamatan(id, val)
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus kecamatan ' + val + '?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: true,
          confirm: { text: 'Hapus', value: true }
        }
      }).then( value => {
        if( value )
        {
          axios({
            method: 'delete',
            url: this.url + '/kecamatan/delete/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getKecamatanList();
          }).catch( err => {
            swal({
              title: 'Terjadi kesalahan',
              text: err.response.statusText,
              icon: 'warning',
              dangerMode: true
            });
          });
        }
      });
    }
  },
  mounted() {
    this.getKecamatanList();
  }
}
</script>
