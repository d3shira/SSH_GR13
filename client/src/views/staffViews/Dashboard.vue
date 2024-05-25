<template>
    <div>
      <StaffNavbar />
      <br><br><br>
      <br><br><br>
      <StaffFooter />
    </div>
  </template>
  
  <script>
  import StaffFooter from '../../components/staffComponents/StaffFooter.vue';
  import StaffNavbar from '../../components/staffComponents/StaffNavbar.vue';
  //import JobApplications from '../../components/staffComponents/JobApplications.vue';
  
  export default {
    components: {
      StaffNavbar,
      StaffFooter,
      //JobApplications,
    },
  };
  </script>
  