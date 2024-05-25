<template>
  <div>
    <h1>Job Applications</h1>
    <InputText v-model="filters.global.value" placeholder="Global Search" class="mb-3" />

    <DataTable
      :value="applications"
      :paginator="true"
      :rows="10"
      responsiveLayout="scroll"
      :filters="filters"
      :filterDelay="300"
      :globalFilterFields="globalFilterFields"
    >
      <Column field="name" header="Name" sortable></Column>
      <Column field="surname" header="Surname" sortable></Column>
      <Column field="birthday" header="Birthday" sortable></Column>
      <Column field="nationality" header="Nationality" sortable></Column>
      <Column field="personal_number" header="Personal Number" sortable></Column>
      <Column field="email" header="Email" sortable></Column>
      <Column field="created_at" header="Submitted On" sortable></Column>
      <Column header="Resume" sortable>
        <template #body="{ data }">
          <a :href="data.resume" target="_blank">Download Resume</a>
        </template>
      </Column>
      <Column header="Actions">
        <template #body="{ data }">
          <Button
            v-if="!data.status || data.status === 'pending'"
            label="Approve"
            @click="approveApplication(data)"
            icon="pi pi-check"
            class="p-button-rounded p-button-success"
          ></Button>
          <Button
            v-if="!data.status || data.status === 'pending'"
            label="Reject"
            @click="rejectApplication(data)"
            icon="pi pi-times"
            class="p-button-rounded p-button-danger"
          ></Button>
          <Button
            v-if="data.status === 'approved' || data.status === 'rejected'"
            label="Undo"
            @click="undoApplicationStatus(data)"
            icon="pi pi-undo"
            class="p-button-rounded p-button-warning"
          ></Button>
        </template>
      </Column>
      <Column field="status" header="Status"></Column>
    </DataTable>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

export default {
  components: {
    DataTable,
    Column,
    Button,
    InputText
  },
  setup() {
    const applications = ref([]);
    const filters = ref({ global: { value: null, matchMode: 'contains' } });
    const globalFilterFields = ref(['name', 'surname', 'birthday', 'nationality', 'personal_number', 'email', 'created_at', 'status']);

    const getJobApplications = async () => {
      try {
        console.log('Fetching job applications...');
        const response = await fetch('http://127.0.0.1:8000/api/careers');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Fetched job applications:', data);

        // Normalize data keys
        const normalizedData = data.map((item) => ({
          id: item.id,
          name: item.Name,
          surname: item.Surname,
          birthday: item.Birthday,
          nationality: item.Nationality,
          personal_number: item.Personal_Number,
          email: item.Email,
          message: item.message,
          resume: item.resume,
          created_at: new Date(item.created_at).toLocaleString(),
          updated_at: item.updated_at,
          status: item.status, // Add status field
          previousStatus: null, // Add previousStatus field for undo
          nextStatus: null // Add nextStatus field for redo
        }));

        applications.value = normalizedData;
      } catch (error) {
        console.error('Error fetching job applications:', error);
      }
    };

    onMounted(() => {
      getJobApplications();
    });

    const approveApplication = async (application) => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/careers/${application.id}/approve`, {
            method: 'PUT',
        });
        if (!response.ok) {
            throw new Error('Failed to approve application.');
        }
        // Update local data after successful approval
        application.status = 'approved';
        application.previousStatus = 'pending';
        // Notify user or perform other actions
    } catch (error) {
        console.error('Error approving application:', error);
    }
};

const rejectApplication = async (application) => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/careers/${application.id}/reject`, {
            method: 'PUT',
        });
        if (!response.ok) {
            throw new Error('Failed to reject application.');
        }
        // Update local data after successful rejection
        application.status = 'rejected';
        application.previousStatus = 'pending';
        // Notify user or perform other actions
    } catch (error) {
        console.error('Error rejecting application:', error);
    }
};


const undoApplicationStatus = async (application) => {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/careers/${application.id}/undo`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ status: 'pending' }) // Send the new status to the backend
        });
        if (!response.ok) {
          throw new Error('Failed to undo application status.');
        }
        // Update local data after successful undo
        application.status = 'pending';
        application.previousStatus = null;
        // Notify user or perform other actions
      } catch (error) {
        console.error('Error undoing application status:', error);
      }
    };

    const redoStatus = (application) => {
      application.previousStatus = application.status;
      application.status = application.nextStatus;
      application.nextStatus = null;
      // Save changes to backend or update local storage
    };

    return {
      applications,
      filters,
      globalFilterFields,
      approveApplication,
      rejectApplication,
      undoApplicationStatus
    };
  }
};
</script>

<style>
/* Add any necessary styles here */
</style>






  