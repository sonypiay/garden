<template lang="html">
<div v-if="page === 'editprofile'">
  <editprofile :url="url" :customers="customers" />
</div>
<div v-else-if="page === 'changepassword'">
  <changepassword :url="url" :customers="customers" />
</div>
<div v-else-if="page === 'editemail'">
  <editemail :url="url" :customers="customers" />
</div>
<div v-else-if="page === 'edittelepon'">
  <edittelepon :url="url" :customers="customers" />
</div>
<div v-else>
  <rekeningbank :url="url" :customers="customers" :bankcustomer="bankcustomer" />
</div>
</template>

<script>
import editprofile from '../customers/settingaccount/EditProfile.vue';
import changepassword from '../customers/settingaccount/GantiPassword.vue';
import editemail from '../customers/settingaccount/EditEmail.vue';
import edittelepon from '../customers/settingaccount/EditTelepon.vue';
import rekeningbank from '../customers/settingaccount/RekeningBank.vue';
export default {
  props: ['url', 'page', 'customers', 'bankcustomer'],
  components: { editprofile, changepassword, editemail, edittelepon, rekeningbank }
}
</script>
