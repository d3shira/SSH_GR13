<template>
    <div>
     <AdminNavbar />
     <br><br><br>
     <br><br><br>
     <EditPropertyCard/>
     <AdminFooter />
   </div>
</template>
<script>
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
import EditPropertyCard from '../../components/staffComponents/EditPropertyCard.vue'
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
//import JobApplications from '../../components/staffComponents/JobApplications.vue';

export default {
 components: {
   AdminFooter,
   AdminNavbar,
   //JobApplications,
   EditPropertyCard,
 },
};
</script>