<template lang="html">
<div class="uk-margin-top">
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <div class="uk-grid-medium" uk-grid>
      <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-1@s">
        <div class="uk-tile uk-tile-muted content_profilepicture">
          <div class="uk-position-center">Image Profile</div>
        </div>
        <button class="uk-width-1-1 uk-margin-top uk-button uk-button-default btn_uploadphoto">Upload Foto</button>
      </div>
      <div class="uk-width-expand">
        <div v-if="errors.error" class="uk-margin-bottom uk-alert-danger" uk-alert>{{ errors.error }}</div>
        <h3 class="content_headingsettingprofile">Edit Profil</h3>
        <form class="uk-form-stacked" @submit.prevent="editProfile">
          <div class="uk-margin">
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.fullname" placeholder="Nama Lengkap">
            </div>
            <div v-if="errors.fullname" class="uk-text-small uk-text-danger">{{ errors.fullname }}</div>
          </div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.username" placeholder="Username">
            </div>
          </div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <select class="uk-select form-settingaction" v-model="forms.gender">
                <option value="male">Pria</option>
                <option value="female">Wanita</option>
              </select>
            </div>
          </div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                  <select class="uk-width-1-1 uk-select form-settingaction" v-model="forms.day">
                    <option v-for="day in 31" :text="day" :value="day">{{ day }}</option>
                  </select>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                  <select class="uk-width-1-1 uk-select form-settingaction" v-model="forms.month">
                    <option v-for="month in listMonth" :text="month" :value="month">{{ month }}</option>
                  </select>
                </div>
                <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
                  <select class="uk-width-1-1 uk-select form-settingaction" v-model="forms.year">
                    <option v-for="year in years" :text="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <button v-html="btnupdate" class="uk-button uk-button-default btn_settingaction">Simpan</button>
          </div>
        </form>
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
      listMonth: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      forms: {
        fullname: this.customers.customer_name,
        username: this.customers.customer_username,
        gender: this.customers.customer_gender,
        profile_picture: this.customers.customre_profile_picture,
        day: this.getDayBirthday(),
        month: this.getMonthBirthday(),
        year: this.getYearBirthday(),
        error: false
      },
      btnupdate: 'Simpan',
      errors: {}
    }
  },
  computed: {
    years() {
      const year = new Date().getFullYear();
      return Array.from({ length: year - 1959 }, (value, index) => 1960 + index);
    }
  },
  mounted() {

  },
  methods: {
    getMonthBirthday() {
      var month = '2000-01-01';
      if( this.customers.customer_birthday !== null )
      {
        month = this.customers.customer_birthday;
      }
      return moment(month).locale('id').format("MMMM");
    },
    getDayBirthday() {
      var month = '2000-01-01';
      if( this.customers.customer_birthday !== null )
      {
        month = this.customers.customer_birthday;
      }
      return moment(month).format("D");
    },
    getYearBirthday() {
      var month = '2000-01-01';
      if( this.customers.customer_birthday !== null )
      {
        month = this.customers.customer_birthday;
      }
      return moment(month).format("YYYY");
    },
    editProfile() {
      this.errors = {};
      if( this.forms.fullname === '' )
      {
        this.errors.fullname = 'Nama lengkap wajib diisi.';
      }
      else
      {
        this.btnupdate = '<span uk-spinner></span>';
        this.forms.month = moment().month( this.forms.month ).format("MM");
        axios({
          method: 'put',
          url: this.url + '/customers/account/edit_profile',
          headers: { 'Content-Type': 'application/json' },
          params: {
            fullname: this.forms.fullname,
            username: this.forms.username,
            gender: this.forms.gender,
            birthday: this.forms.year + '-' + this.forms.month + '-' + this.forms.day
          }
        }).then( res => {
          this.errors = {};
          swal({
            title: 'Berhasil',
            text: res.data.statusText,
            icon: 'success',
            timer: 4000
          })
          this.btnupdate = 'Simpan';
        }).catch( err => {
          if( err.response.status === 422 )
          {
            this.errors.error = err.response.data.statusText;
          }
          else
          {
            this.errors.error = err.response.statusText;
          }
          this.btnupdate = 'Simpan';
        });
        this.forms.month = moment( this.forms.month ).locale('id').format("MMMM");
      }
    }
  }
}
</script>
