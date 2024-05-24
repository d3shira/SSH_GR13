<template>
    <div>
      <StaffNavbar />
      <br><br><br>
      <StaffFooter />
    </div>
  </template>
  
  <script>
  import StaffFooter from '../../components/staffComponents/StaffFooter.vue';
  import StaffNavbar from '../../components/staffComponents/StaffNavbar.vue';
  
  export default {
    components: {
      StaffNavbar,
      StaffFooter,
    },
  };
  </script>
  