<template lang="html" v-if="page === 'editprofile'">
<editprofile :url="url" :customers="customers"></editprofile>
</template>

<template lang="html" v-if="page === 'editprofile'">
<changepassword :url="url" :customers="customers"></changepassword>
</template>

<script>
import editprofile from './EditProfile.vue';
import changepassword from './GantiPassword.vue';

export default {
  props: ['url', 'page', 'customers'],
  components: { editprofile, changepassword }
}
</script>
