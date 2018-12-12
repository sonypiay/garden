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
          <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
          <form class="uk-form-stacked" @submit.prevent="onBooking">
            <div class="uk-grid-medium" uk-grid>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
                <div class="uk-card uk-card-default booking_gridbox">
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Tanggal Pengerjaan</div>
                    <v-date-picker :formats="datepicker.formats" mode="single" v-model="forms.schedule_date" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles"></v-date-picker>
                    <div v-if="errors.schedule_date" class="uk-text-small uk-text-danger">{{ errors.schedule_date }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Nomor Telepon</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.notelepon" placeholder="+62">
                    <div v-if="errors.notelepon" class="uk-text-small uk-text-danger">{{ errors.notelepon }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Harga Deal</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.price_deal" @keyup="formatPrice()" @focus="isInputActive = true" @blur="isInputActive = false" placeholder="Rp. ">
                    <div v-if="errors.price_deal" class="uk-text-small uk-text-danger">{{ errors.price_deal }}</div>
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
                    <div v-if="errors.region" class="uk-text-small uk-text-danger">{{ errors.region }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kabupaten/Kota</div>
                    <select class="uk-width-1-1 uk-select booking_formaction" v-model="forms.district" @change="getKecamatan()">
                      <option value="" selected>-- Pilih Kabupaten --</option>
                      <option v-for="kab in kabupaten" :value="kab.id">{{ kab.kabupaten }}</option>
                    </select>
                    <div v-if="errors.district" class="uk-text-small uk-text-danger">{{ errors.district }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kabupaten/Kota</div>
                    <select class="uk-width-1-1 uk-select booking_formaction" v-model="forms.subdistrict">
                      <option value="" selected>-- Pilih Kecamatan --</option>
                      <option v-for="kec in kecamatan" :value="kec.id">{{ kec.kecamatan }}</option>
                    </select>
                    <div v-if="errors.subdistrict" class="uk-text-small uk-text-danger">{{ errors.subdistrict }}</div>
                  </div>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
                <div class="uk-card uk-card-default booking_gridbox">
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Address</div>
                    <textarea class="uk-textarea booking_formaction" v-model="forms.address"></textarea>
                    <div v-if="errors.address" class="uk-text-small uk-text-danger">{{ errors.address }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Kode Pos</div>
                    <input type="text" class="uk-width-1-1 uk-input booking_formaction" v-model="forms.zipcode">
                    <div v-if="errors.zipcode" class="uk-text-small uk-text-danger">{{ errors.zipcode }}</div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-card-title booking_gridbox_heading">Layout Design (optional)</div>
                    <div uk-form-custom="target: true">
                      <input type="file" @change="selectedFile">
                      <input class="uk-input uk-form-width-medium" type="text" id="selectedFile" placeholder="Select file" disabled>
                      <div class="uk-text-small"><i>Max 2 MB (pdf/doc/jpg)</i></div>
                    </div>
                    <div v-if="errors.layout_design" class="uk-text-small uk-text-danger">{{ errors.layout_design }}</div>
                  </div>
                </div>
              </div>
              <div class="uk-width-1-1">
                <div class="uk-card uk-card-default booking_gridbox">
                  <div class="uk-card-title booking_gridbox_heading">Catatan</div>
                  <textarea class="uk-width-1-1 uk-textarea uk-height-small booking_formaction" v-model="forms.note"></textarea>
                </div>
              </div>
            </div>
            <div class="uk-margin">
              <button class="uk-button uk-button-default booking_btnaction" v-html="forms.submit"></button>
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
      isInputActive: false,
      forms: {
        error: false,
        submit: 'Pesan',
        schedule_date: new Date(),
        region: '',
        district: '',
        subdistrict: '',
        address: '',
        zipcode: '',
        notelepon: '',
        price_deal: 0,
        layout_design: '',
        note: ''
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
        },
        formats: {
          title: 'MMMM YYYY',
          weekdays: 'W',
          navMonths: 'MMM',
          input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
          dayPopover: 'L', // Only for `v-date-picker`
          data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
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
        url = this.url + '/api/kabupaten/provinsi/' + this.forms.region;
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
        url = this.url + '/api/kecamatan/kabupaten/' + this.forms.district;
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
    },
    getFormatFile(files) {
      var length_str_file = files.length;
      var getIndex = files.lastIndexOf(".");
      var getformatfile = files.substring( length_str_file, getIndex + 1 ).toLowerCase();
      return getformatfile;
    },
    selectedFile(event) {
      if( this.getObjectSize( this.errors ) === 0 ) this.errors = {};
      this.forms.layout_design = event.target.files[0];
      if( this.getFormatFile( this.forms.layout_design.name ) !== 'jpg'
        && this.getFormatFile( this.forms.layout_design.name ) !== 'jpeg'
        && this.getFormatFile( this.forms.layout_design.name ) !== 'pdf'
        && this.getFormatFile( this.forms.layout_design.name ) !== 'doc'
        && this.getFormatFile( this.forms.layout_design.name ) !== 'docx'
      )
      {
        this.errors.layout_design = 'Format file tidak valid.';
        swal({
          title: 'Whoops',
          text: this.errors.layout_design,
          icon: 'warning',
          dangerMode: true,
          timer: 5000
        });
      }
      else
      {
        if( this.forms.layout_design.size > 2048000 )
        {
          this.errors.layout_design = 'Ukuran file terlalu besar. Maksimal 2 MB.';
          swal({
            title: 'Whoops',
            text: this.errors.layout_design,
            icon: 'warning',
            dangerMode: true,
            timer: 5000
          });
        }
      }
    },
    getObjectSize: function(obj) {
      var size = 0;
      var key;
      for( key in obj )
      {
        if( obj.hasOwnProperty(key) )
          size++;
      }
      return size;
    },
    onBooking() {
      this.errors = {};
      this.errorMessage = '';
      var price_deal = this.forms.price_deal;
      if( price_deal !== 0 || price_deal === '' )
        price_deal = Number( this.forms.price_deal.replace(/[^0-9.-]+/g, ""));

      if( this.forms.schedule_date === '' )
      {
        this.errors.schedule_date = 'Silahkan masukkan tanggal pengerjaan.';
        this.forms.error = true;
      }
      if( this.forms.notelepon === '' )
      {
        this.errors.notelepon = 'Nomor telepon wajib diisi';
        this.forms.error = true;
      }
      if( this.forms.price_deal === '' )
      {
        this.errors.price_deal = 'Silahkan isi nominal harga deal dengan vendor Anda';
        this.forms.error = true;
      }
      if( isNaN( price_deal ) )
      {
        this.errors.price_deal = 'Harga deal tidak valid.';
        this.forms.error = true;
      }
      if( this.forms.region === '' )
      {
        this.errors.region = 'Silahkan pilih provinsi';
        this.forms.error = true;
      }
      if( this.forms.district === '' )
      {
        this.errors.district = 'Silahkan pilih kabupaten/kota';
        this.forms.error = true;
      }
      if( this.forms.subdistrict === '' )
      {
        this.errors.subdistrict = 'Silahkan pilih kecamatan';
        this.forms.error = true;
      }
      if( this.forms.address === '' )
      {
        this.errors.address = 'Alamat wajib diisi';
        this.forms.error = true;
      }
      if( this.forms.zipcode === '' )
      {
        this.errors.zipcode = 'Kode Pos wajib diisi';
        this.forms.error = true;
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      if( this.forms.layout_design !== '' )
      {
        if( this.getFormatFile( this.forms.layout_design.name ) !== 'jpg'
          && this.getFormatFile( this.forms.layout_design.name ) !== 'jpeg'
          && this.getFormatFile( this.forms.layout_design.name ) !== 'pdf'
          && this.getFormatFile( this.forms.layout_design.name ) !== 'doc'
          && this.getFormatFile( this.forms.layout_design.name ) !== 'docx'
        )
        {
          this.errors.layout_design = 'Format file tidak valid.';
          swal({
            title: 'Whoops',
            text: this.errors.layout_design,
            icon: 'warning',
            dangerMode: true,
            timer: 5000
          });
          return false;
        }

        if( this.forms.layout_design.size > 2048000 )
        {
          this.errors.layout_design = 'Ukuran file terlalu besar. Maksimal 2 MB.';
          swal({
            title: 'Whoops',
            text: this.errors.layout_design,
            icon: 'warning',
            dangerMode: true,
            timer: 5000
          });
          return false;
        }
      }

      var formdata = new FormData();
      formdata.append('schedule_date', this.formatDate( this.forms.schedule_date, 'YYYY-MM-DD' ));
      formdata.append('mobile_number', this.forms.notelepon);
      formdata.append('region', this.forms.region);
      formdata.append('district', this.forms.district);
      formdata.append('subdistrict', this.forms.subdistrict);
      formdata.append('address', this.forms.address);
      formdata.append('zipcode', this.forms.zipcode);
      formdata.append('price_deal', price_deal);
      formdata.append('layout_design', this.forms.layout_design);
      formdata.append('additional_info', this.forms.note);
      formdata.append('customer', this.customers.customer_id);
      formdata.append('vendor', this.vendors.vendor_id);
      this.forms.submit = '<span uk-spinner></span>';
      axios.post( this.url + '/booking_process', formdata ).then( res => {
        let result = res.data;
        var redirect = this.url + '/customers/main_orders/' + result.transaction_id;
        setTimeout(function(){ document.location = redirect; },3000);
      }).catch( err => {
        this.errorMessage = err.response.statusText;
        swal({
          title: 'Terjadi kesalahan',
          text: this.errorMessage,
          icon: 'error',
          dangerMode: true,
          timer: 5000
        });
        this.forms.submit = 'Pesan';
      });
    },
    formatPrice() {
      var number = this.forms.price_deal;
      if( isNaN( number ) )
      {
        number = Number(number.replace(/[^0-9.-]+/g, ""));
      }
      var numberformat = new Intl.NumberFormat('en-ID').format(number);
      this.forms.price_deal = numberformat;
    }
  },
  computed: {
    getDate() {
      return moment().locale('id').format('dddd, DD MMMM YYYY');
    },
    formatCurrency() {
      var numberformat = Intl.NumberFormat('en-ID').format(this.forms.price_deal);
      return numberformat;
    },
    displayCurrency: {
      get: function() {
        if( this.isInputActive === false )
        {
          var number = this.value;
          if( number === undefined || number === 0 )
            number = 0;

          var numberformat = Intl.NumberFormat('en-ID', { maximumSignificantDigits: 3 }).format(number);
          this.forms.price_deal = Number(numberformat.replace(/[^0-9.-]+/g,""));
          return numberformat;
        }
        else
        {
          return this.value;
        }
      },
      set: function(val) {
        if( val === undefined || val === 0 )
          val = 0;
        this.value = val;
      }
    }
  },
  mounted() {
    this.getProvinsi('all'); this.getKabupaten('all'); this.getKecamatan('all');
  }
}
</script>
