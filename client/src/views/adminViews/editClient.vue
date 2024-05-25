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
        :globalFilterFields="['first_name', 'last_name', 'email', 'username', 'phone']"
      >
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
        <template #empty> No users found. </template>
        <template #loading> Loading users data. Please wait. </template>
        <Column field="first_name" header="First Name" style="min-width: 12rem">
          <template #body="{ data }">{{ data.first_name }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by first name" />
          </template>
        </Column>
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
        <Column field="phone" header="Phone" style="min-width: 12rem">
          <template #body="{ data }">{{ data.phone }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by phone" />
          </template>
        </Column>
        <Column header="Actions" style="min-width: 10rem">
          <template #body="{ data }">
            <Button label="Edit" icon="pi pi-pencil" class="p-button-rounded p-button-success" @click="editUser(data)" />
          </template>
        </Column>
      </DataTable>
    </div>
    <AdminFooter />
    <Dialog v-model:visible="editDialogVisible" header="Edit User" width="30%" @hide="resetEditUser">
      <div>
        <div class="p-fluid">
          <div class="p-field">
            <label for="first_name">First Name</label>
            <InputText id="first_name" v-model="editedUser.first_name" />
          </div>
          <div class="p-field">
            <label for="last_name">Last Name</label>
            <InputText id="last_name" v-model="editedUser.last_name" />
          </div>
          <div class="p-field">
            <label for="email">Email</label>
            <InputText id="email" v-model="editedUser.email" />
          </div>
          <div class="p-field">
            <label for="username">Username</label>
            <InputText id="username" v-model="editedUser.username" />
          </div>
          <div class="p-field">
            <label for="phone">Phone</label>
            <InputText id="phone" v-model="editedUser.phone" />
          </div>
        </div>
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
    const response = await fetch('http://127.0.0.1:8000/api/users');
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
    phone: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] }
  };
};

// Clear filters
const clearFilter = () => {
  initFilters();
};

const editUser = (user) => {
  editDialogVisible.value = true;
  editedUser.value = { ...user };
};

// Reset editedUser object and hide the dialog
const resetEditUser = () => {
  editedUser.value = {};
  editDialogVisible.value = false;
};

const saveUser = async () => {
    console.log('Edited User ID:', editedUser.value.id); // Log the edited user ID for debugging
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/users/${editedUser.value.id}`, {
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
        const index = users.value.findIndex(u => u.id === updatedUser.user.id);
        if (index !== -1) {
            users.value.splice(index, 1, updatedUser.user);
        }

        resetEditUser();
    } catch (error) {
        console.error('Error updating user:', error);
    }
};

// Start polling function
const startPolling = () => {
  pollingInterval = setInterval(fetchUsers, 2000);
};

// Stop polling function
const stopPolling = () => {
  clearInterval(pollingInterval);
};

// Fetch users and initialize filters when component is mounted
onMounted(() => {
  fetchUsers();
  startPolling();
  initFilters();
});

// Stop polling when component is destroyed
onUnmounted(() => {
  stopPolling();
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
