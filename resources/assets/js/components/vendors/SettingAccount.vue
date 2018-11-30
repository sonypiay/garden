<template lang="html">
<div v-if="pages === 'editprofile'">
  <editaccount :url="url" :vendors="vendors" />
</div>
<div v-else-if="pages === 'changepassword'">
  <changepassword :url="url" :vendors="vendors" />
</div>
<div v-else-if="pages === 'editemail'">
  <editemail :url="url" :vendors="vendors" />
</div>
<div v-else-if="pages === 'edittelepon'">
  <edittelepon :url="url" :vendors="vendors" />
</div>
<div v-else-if="pages === 'rekeningpencairan'">
  <rekeningpencairan :url="url" :vendors="vendors" :bankcustomer="bankcustomer" />
</div>
<div v-else>
  no components
</div>
</template>

<script>
import editaccount from '../vendors/settingaccount/EditAccount.vue';
import changepassword from '../vendors/settingaccount/ChangePassword.vue';
import editemail from '../vendors/settingaccount/EditEmail.vue';
import edittelepon from '../vendors/settingaccount/EditTelepon.vue';
import rekeningpencairan from '../vendors/settingaccount/RekeningPencairan.vue';

export default {
  props: ['url', 'pages', 'bankcustomer'],
  components: {
    editaccount,
    changepassword,
    editemail,
    edittelepon,
    rekeningpencairan
  },
  data() {
    return {
      vendors: {
        name: '',
        ownername: '',
        username: '',
        region: '',
        district: '',
        subdistrict: '',
        address: '',
        zipcode: '',
        slugname: '',
        email: '',
        mobile_private: '',
        mobile_business: '',
        id: 0
      },
    }
  },
  methods: {
    getAccount() {
      axios({
        method: 'get',
        url: this.url + '/vendor/account/datavendor'
      }).then( res => {
        let result = res.data;
        this.vendors = {
          name: result.vendor_name,
          ownername: result.vendor_ownername,
          username: result.vendor_username,
          region: result.vendor_region,
          district: result.vendor_district,
          subdistrict: result.vendor_subdistrict,
          address: result.vendor_address,
          zipcode: result.vendor_zipcode,
          slugname: result.vendor_slug_name,
          email: result.vendor_email_business,
          mobile_private: result.vendor_mobile_private,
          mobile_business: result.vendor_mobile_business,
          id: result.vendor_id
        };
      }).catch( err => {
        console.log(err.response.statusText);
      });
    }
  },
  mounted() {
    this.getAccount();
  }
}
</script>
