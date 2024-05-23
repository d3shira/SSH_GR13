<template>
    <div>
      <AdminNavbar />
      <br><br><br>
      <AdminFooter />
    </div>
  </template>
  
  <script>
  import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
  import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
  
  export default {
    components: {
      AdminNavbar,
      AdminFooter,
    },
  };
  </script>
  