<template>
    <div>
     <StaffNavbar />
     <br><br><br>
     <br><br><br>
     <EditPropertyCard/>
     <StaffFooter />
   </div>
</template>
<script>
import StaffNavbar from '@/components/staffComponents/StaffNavbar.vue';
import StaffFooter from '@/components/staffComponents/StaffFooter.vue';
import EditPropertyCard from '../../components/staffComponents/EditPropertyCard.vue'
//import JobApplications from '../../components/staffComponents/JobApplications.vue';

export default {
 components: {
   StaffFooter,
   StaffNavbar,
   //JobApplications,
   EditPropertyCard,
 },
};
</script>