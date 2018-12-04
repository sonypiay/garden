<template lang="html">
  <div>
    <div class="booking_container">
      <div class="booking_header">
        <div class="uk-container">
          <div class="uk-card uk-card-body">
            <div class="uk-card-title booking_heading">
              Pesan Vendor - {{ vendors.vendor_name }}
            </div>
            <div class="booking_subheading">
              {{ getDate }}
            </div>
          </div>
        </div>
      </div>
      <div class="uk-card uk-card-body uk-card-default booking_formcontent">
        <div class="uk-container uk-card uk-card-body booking_bodyform">
          <form @submit.prevent="">
            <div class="uk-grid-large uk-grid-match" uk-grid>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
                <div class="uk-card uk-card-default booking_gridbox">
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Tanggal Pengerjaan</div>
                    <v-date-picker mode="single" v-model="datepicker.selectedDate" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles"></v-date-picker>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Nomor Telepon</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.notelepon" placeholder="+62">
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Harga Deal</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.price_deal" placeholder="Rp. ">
                  </div>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
                <div class="uk-card uk-card-default booking_gridbox">
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Provinsi</div>
                    <select class="uk-width-1-1 uk-select booking_formaction" v-model="forms.region" @change="getKabupaten()">
                      <option value="" selected>-- Pilih Provinsi --</option>
                      <option v-for="prov in provinsi" :value="prov.id">{{ prov.nama }}</option>
                    </select>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kabupaten/Kota</div>
                    <select class="uk-width-1-1 uk-select booking_formaction" v-model="forms.district" @change="getKecamatan()">
                      <option value="" selected>-- Pilih Kabupaten --</option>
                      <option v-for="kab in kabupaten" :value="kab.id">{{ kab.kabupaten }}</option>
                    </select>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kabupaten/Kota</div>
                    <select class="uk-width-1-1 uk-select booking_formaction" v-model="forms.subdistrict">
                      <option value="" selected>-- Pilih Kecamatan --</option>
                      <option v-for="kec in kecamatan" :value="kec.id">{{ kec.kecamatan }}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
                <div class="uk-card uk-card-body uk-card-default booking_gridbox">
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Address</div>
                    <textarea class="uk-textarea booking_formaction" v-model="forms.address"></textarea>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kode Pos</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.zipcode">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';

export default {
  props: ['url', 'customers', 'vendors'],
  components: {
    VCalendar
  },
  data() {
    return {
      provinsi: [],
      kabupaten: [],
      kecamatan: [],
      errors: {},
      errorMessage: '',
      forms: {
        submit: 'Pesan',
        schedule_date: '',
        schedule_time: '',
        region: '',
        district: '',
        subdistrict: '',
        address: '',
        zipcode: '',
        notelepon: '',
        price_deal: '',
        layout_design: ''
      },
      datepicker: {
        selectedDate: new Date(),
        props: {
          class: "uk-width-1-1 uk-input booking_formaction",
          placeholder: "Masukkan tanggal pengerjaan",
          readonly: true
        },
        attributes: {
          highlight: {
            backgroundColor: '#f6a192',     // Red background
            borderColor: '#f6a192',
            borderWidth: '2px',
            borderStyle: 'solid',
          }
        },
        themeStyles: {
          wrapper: {
            background: '#ffffff',
            color: '#ffffff',
            border: '0',
            borderRadius: '5px',
            boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.14), 0 6px 20px 0 rgba(0, 0, 0, 0.13)'
          }
        }
      }
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    getProvinsi() {
      axios({
        method: 'get',
        url: this.url + '/api/provinsi/all'
      }).then( res => {
        let result = res.data;
        this.provinsi = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getKabupaten(val)
    {
      var url;
      if( val === undefined )
        url = this.url + '/api/kabupaten/provinsi/' + this.vendors.region;
      else
        url = this.url + '/api/kabupaten/all';

      axios({
        method: 'get',
        url: url
      }).then( res => {
        let result = res.data;
        this.kabupaten = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getKecamatan(val)
    {
      var url;
      if( val === undefined )
        url = this.url + '/api/kecamatan/kabupaten/' + this.vendors.district;
      else
        url = this.url + '/api/kecamatan/all';

      axios({
        method: 'get',
        url: url
      }).then( res => {
        let result = res.data;
        this.kecamatan = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  computed: {
    getDate() {
      return moment().locale('id').format('dddd, DD MMMM YYYY');
    }
  },
  mounted() {
    this.getProvinsi('all'); this.getKabupaten('all'); this.getKecamatan('all');
  }
}
</script>
