<template>
    <StaffNavbar />
    <h1 style="padding-top: 110px; padding-bottom: 20px; display: flex; justify-content: center; color: #010633;">Messages</h1>
    <div class="card">
        <DataTable :value="applications" paginator :rows="10" tableStyle="min-width: 50rem">
            <Column field="id" header="ID" style="width: 4%"></Column>
            <Column field="name" header="Name" style="width: 8%"></Column>
            <Column field="email" header="Email" style="width: 8%"></Column>
            <Column field="contact" header="Contact" style="width: 7%"></Column>
            <Column field="address" header="Address" style="width: 8%"></Column>
            <Column field="message" header="Message" style="width: 20%"></Column>
        </DataTable>
    </div>

    <StaffFooter />
</template>

<script setup>
import StaffNavbar from '@/components/staffComponents/StaffNavbar.vue';
import StaffFooter from '@/components/staffComponents/StaffFooter.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, onMounted } from 'vue';

const applications = ref([]);

onMounted(async () => {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/applications');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Fetched applications:', data);
        applications.value = data;
    } catch (error) {
        console.error('Error fetching applications:', error);
    }
});
</script>



