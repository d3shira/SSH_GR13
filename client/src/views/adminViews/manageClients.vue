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
        :globalFilterFields="['first_name', 'last_name', 'email', 'phone']"
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
          <template #body="{ data }">
            {{ data.first_name }}
          </template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by first name" />
          </template>
        </Column>
        <Column field="last_name" header="Last Name" style="min-width: 12rem">
          <template #body="{ data }">
            {{ data.last_name }}
          </template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by last name" />
          </template>
        </Column>
        <Column field="email" header="Email" style="min-width: 20rem">
          <template #body="{ data }">
            {{ data.email }}
          </template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by email" />
          </template>
        </Column>
        <Column field="phone" header="Phone" style="min-width: 12rem">
          <template #body="{ data }">
            {{ data.phone }}
          </template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by phone" />
          </template>
        </Column>
        <Column header="Actions" style="min-width: 10rem">
          <template #body="{ data }">
            <Button label="Delete" icon="pi pi-trash" class="p-button-rounded p-button-danger" @click="deleteUser(data.id)" />
          </template>
        </Column>
      </DataTable>
    </div>
    <AdminFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

// Import components
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';

// Setup references
const users = ref([]);
const filters = ref({});
const loading = ref(true);

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

// Delete user function using fetch API
const deleteUser = async (id) => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/users/${id}`, {
      method: 'DELETE'
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    fetchUsers(); // Refresh users after deletion
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};

// Initialize filters
const initFilters = () => {
  filters.value = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    first_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
    last_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
    email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    phone: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] }
  };
};

// Clear filters
const clearFilter = () => {
  initFilters();
};

onMounted(() => {
  fetchUsers();
  initFilters();
});
</script>

<script>
export default {
  components: {
    AdminNavbar,
    AdminFooter,
    DataTable,
    Column
  }
};
</script>

<style>
.spacer {
  margin-top: 10rem;
}
</style>
