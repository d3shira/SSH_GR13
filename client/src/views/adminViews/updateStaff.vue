<template>
    <div>
      <AdminNavbar />
      <div class="spacer"></div>
      <div class="card">
        <DataTable
          v-model:filters="filters"
          :value="users"
          paginator
          showGridlines
          :rows="10"
          dataKey="id"
          filterDisplay="menu"
          :loading="loading"
          :globalFilterFields="['first_name', 'last_name', 'email', 'username', 'job_position']"
        >
          <!-- DataTable Header -->
          <template #header>
            <div class="flex justify-content-between">
              <Button type="button" icon="pi pi-filter-slash" label="Clear" outlined @click="clearFilter()" />
              <IconField iconPosition="left">
                <InputIcon>
                  <i class="pi pi-search" />
                </InputIcon>
                <InputText v-if="filters['global']" v-model="filters['global'].value" placeholder="Keyword Search" />
              </IconField>
            </div>
          </template>
          <!-- DataTable Empty State -->
          <template #empty> No users found. </template>
          <!-- DataTable Loading State -->
          <template #loading> Loading users data. Please wait. </template>
          <!-- DataTable Columns -->
          <Column field="first_name" header="First Name" style="min-width: 12rem">
            <!-- Column Body Template -->
            <template #body="{ data }">{{ data.first_name }}</template>
            <!-- Column Filter Template -->
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by first name" />
            </template>
          </Column>
          <!-- Repeat Column definition for other fields: last_name, email, username, job_position, phone -->
          <Column field="last_name" header="Last Name" style="min-width: 12rem">
            <template #body="{ data }">{{ data.last_name }}</template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by last name" />
            </template>
          </Column>
          <Column field="email" header="Email" style="min-width: 20rem">
            <template #body="{ data }">{{ data.email }}</template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by email" />
            </template>
          </Column>
          <Column field="username" header="Username" style="min-width: 12rem">
            <template #body="{ data }">{{ data.username }}</template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by username" />
            </template>
          </Column>
          <Column field="job_position" header="Job Position" style="min-width: 12rem">
            <template #body="{ data }">{{ data.job_position }}</template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by job position" />
            </template>
          </Column>
          <Column field="phone" header="Phone" style="min-width: 12rem">
            <template #body="{ data }">{{ data.phone }}</template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by phone" />
            </template>
          </Column>
          <!-- Actions Column -->
          <Column header="Actions" style="min-width: 10rem">
            <template #body="{ data }">
              <!-- Edit Button -->
              <Button label="Edit" icon="pi pi-pencil" class="p-button-rounded p-button-success" @click="editUser(data)" />
            </template>
          </Column>
        </DataTable>
      </div>
      <AdminFooter />
      <!-- Edit User Modal -->
      <Dialog v-model="editDialogVisible" header="Edit User" :visible="editDialogVisible" width="30%" @hide="resetEditUser">
        <div>
          <!-- Form Inputs for Editing User -->
          <InputText v-model="editedUser.first_name" label="First Name" />
          <InputText v-model="editedUser.last_name" label="Last Name" />
          <InputText v-model="editedUser.email" label="Email" />
          <InputText v-model="editedUser.username" label="Username" />
          <InputText v-model="editedUser.job_position" label="Job Position" />
          <InputText v-model="editedUser.phone" label="Phone" />
          <!-- Save Button -->
          <Button label="Save" icon="pi pi-check" @click="saveUser" />
        </div>
      </Dialog>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  import { FilterMatchMode, FilterOperator } from 'primevue/api';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import Button from 'primevue/button';
  import Dialog from 'primevue/dialog';
  import InputText from 'primevue/inputtext';
  
  // Import components
  import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
  import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
  
  // Setup references
  const users = ref([]);
  const filters = ref({});
  const loading = ref(true);
  const editDialogVisible = ref(false);
  const editedUser = ref({});
  let pollingInterval;
  
  // Fetch users function using fetch API
  const fetchUsers = async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/agents'); // Change the URL to match your backend route
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      users.value = data;
    } catch (error) {
      console.error('Error fetching users:', error);
    } finally {
      loading.value = false;
    }
  };
  
  // Initialize filters
  const initFilters = () => {
    filters.value = {
      global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      first_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
      last_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
      email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
      username: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
      job_position: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
      phone: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] }
    };
  };
  
  // Clear filters
  const clearFilter = () => {
    initFilters();
  };
  
  const editUser = (user) => {
    // Open the edit dialog and set the editedUser object
    editDialogVisible.value = true;
    // Ensure that the 'id' property is included in the user object
    editedUser.value = { ...user, id: user.id }; // Include id property
  };
  
  // Reset editedUser object and hide the dialog
  const resetEditUser = () => {
    editedUser.value = {};
    editDialogVisible.value = false;
  };
  
  const saveUser = async () => {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/editStaff/${editedUser.value.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(editedUser.value),
      });
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const updatedUser = await response.json();
      // Update the user in the users array
      const index = users.value.findIndex(u => u.id === updatedUser.id);
      if (index !== -1) {
        users.value.splice(index, 1, updatedUser);
      }
      // Reset editedUser object and hide the dialog
      resetEditUser();
    } catch (error) {
      console.error('Error updating user:', error);
    }
  };
  
  // Start polling function
  const startPolling = () => {
    pollingInterval = setInterval(fetchUsers, 2000); // Poll every 2 seconds
  };
  
  // Stop polling function
  const stopPolling = () => {
    clearInterval(pollingInterval);
  };
  
  // Fetch users and initialize filters when component is mounted
  onMounted(() => {
    fetchUsers();
    startPolling(); // Start polling when component is mounted
    initFilters();
  });
  
  // Stop polling when component is destroyed
  onUnmounted(() => {
    stopPolling(); // Stop polling when component is destroyed
  });
  </script>
  
  <script>
  export default {
    components: {
      AdminNavbar,
      AdminFooter,
      DataTable,
      Column,
      Button,
      Dialog,
      InputText
    }
  };
  </script>
  
  <style>
  .spacer {
    margin-top: 10rem;
  }
  </style>
  