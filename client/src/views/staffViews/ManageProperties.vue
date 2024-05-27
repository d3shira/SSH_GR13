<template>
  <div>
    <AdminNavbar />
    <div class="spacer"></div>
    <div class="card">
      <DataTable
        v-model:filters="filters"
        :value="properties"
        paginator
        showGridlines
        :rows="10"
        dataKey="id"
        filterDisplay="menu"
        :loading="loading"
        :globalFilterFields="['title', 'description', 'property_type_name', 'address_line', 'city_village', 'municipality', 'country', 'postal_code', 'owner_name', 'contact_info']"
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
        <template #empty> No properties found. </template>
        <!-- DataTable Loading State -->
        <template #loading> Loading properties data. Please wait. </template>
        <!-- DataTable Columns -->
        <Column field="title" header="Title" style="min-width: 12rem">
          <template #body="{ data }">{{ data.title }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by title" />
          </template>
        </Column>
        <Column field="description" header="Description" style="min-width: 20rem">
          <template #body="{ data }">{{ data.description }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by description" />
          </template>
        </Column>
        <Column field="status" header="Status" style="min-width: 12rem">
          <template #body="{ data }">{{ getStatusLabel(data.status) }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by status" />
          </template>
        </Column>
        <Column field="property_type_name" header="Property Type" style="min-width: 12rem">
          <template #body="{ data }">{{ data.property_type_name }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by property type" />
          </template>
        </Column>
        <Column field="address_line" header="Address" style="min-width: 20rem">
          <template #body="{ data }">{{ data.address_line }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by address" />
          </template>
        </Column>
        <Column field="city_village" header="City/Village" style="min-width: 12rem">
          <template #body="{ data }">{{ data.city_village }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by city/village" />
          </template>
        </Column>
        <Column field="municipality" header="Municipality" style="min-width: 12rem">
          <template #body="{ data }">{{ data.municipality }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by municipality" />
          </template>
        </Column>
        <Column field="country" header="Country" style="min-width: 12rem">
          <template #body="{ data }">{{ data.country }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by country" />
          </template>
        </Column>
        <Column field="postal_code" header="Postal Code" style="min-width: 12rem">
          <template #body="{ data }">{{ data.postal_code }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by postal code" />
          </template>
        </Column>
        <Column field="owner_name" header="Owner" style="min-width: 12rem">
          <template #body="{ data }">{{ data.owner_name }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by owner" />
          </template>
        </Column>
        <Column field="contact_info" header="Contact Info" style="min-width: 12rem">
          <template #body="{ data }">{{ data.contact_info }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by contact info" />
          </template>
        </Column>
        <Column field="num_bedrooms" header="Bedrooms" style="min-width: 12rem">
          <template #body="{ data }">{{ data.num_bedrooms }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by bedrooms" />
          </template>
        </Column>
        <Column field="num_bathrooms" header="Bathrooms" style="min-width: 12rem">
          <template #body="{ data }">{{ data.num_bathrooms }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by bathrooms" />
          </template>
        </Column>
        <Column field="square_meters" header="Square Meters" style="min-width: 12rem">
          <template #body="{ data }">{{ data.square_meters }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by square meters" />
          </template>
        </Column>
        <Column field="floor_number" header="Floor Number" style="min-width: 12rem">
          <template #body="{ data }">{{ data.floor_number }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by floor number" />
          </template>
        </Column>
        <!-- Checkboxes -->
        <Column field="has_balcony" header="Has Balcony" style="min-width: 12rem">
          <template #body="{ data }">
            <Checkbox v-model="data.has_balcony" :true-value="1" :false-value="0" />
          </template>
        </Column>
        <Column field="has_garden" header="Has Garden" style="min-width: 12rem">
          <template #body="{ data }">
            <Checkbox v-model="data.has_garden" :true-value="1" :false-value="0" />
          </template>
        </Column>
        <Column field="has_garage" header="Has Garage" style="min-width: 12rem">
          <template #body="{ data }">
            <Checkbox v-model="data.has_garage" :true-value="1" :false-value="0" />
          </template>
        </Column>
        <Column field="has_parking" header="Has Parking" style="min-width: 12rem">
          <template #body="{ data }">
            <Checkbox v-model="data.has_parking" :true-value="1" :false-value="0" />
          </template>
        </Column>
        <Column field="has_elevator" header="Has Elevator" style="min-width: 12rem">
          <template #body="{ data }">
            <Checkbox v-model="data.has_elevator" :true-value="1" :false-value="0" />
          </template>
        </Column>
        <Column field="price" header="Price" style="min-width: 12rem">
          <template #body="{ data }">{{ data.price }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by price" />
          </template>
        </Column>
        <Column field="agent_name" header="Sales Agent" style="min-width: 12rem">
          <template #body="{ data }">{{ data.agent_name }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by sales agent" />
          </template>
        </Column>
        <Column field="listed_date" header="Listed Date" style="min-width: 12rem">
          <template #body="{ data }">{{ data.listed_date }}</template>
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" type="date" class="p-column-filter" placeholder="Search by listed date" />
          </template>
        </Column>
        <!-- Actions Column -->
        <Column header="Actions" style="min-width: 10rem">
          <template #body="{ data }">
            <!-- Edit Button -->
            <Button label="Edit" icon="pi pi-pencil" class="p-button-rounded p-button-success" @click="editProperty(data)" />
          </template>
        </Column>
      </DataTable>
    </div>
    <AdminFooter />
    <!-- Edit Property Modal -->
    <Dialog v-model="editDialogVisible" header="Edit Property" :visible="editDialogVisible" width="30%" @hide="resetEditProperty">
      <div>
        <!-- Form Inputs for Editing Property -->
        <InputText v-model="editedProperty.title" label="Title" />
        <InputText v-model="editedProperty.description" label="Description" />
        <InputText v-model="editedProperty.status" label="Status" />
        <InputText v-model="editedProperty.property_type_name" label="Property Type" />
        <InputText v-model="editedProperty.address_line" label="Address Line" />
        <InputText v-model="editedProperty.city_village" label="City/Village" />
        <InputText v-model="editedProperty.municipality" label="Municipality" />
        <InputText v-model="editedProperty.country" label="Country" />
        <InputText v-model="editedProperty.postal_code" label="Postal Code" />
        <InputText v-model="editedProperty.owner_name" label="Owner Name" />
        <InputText v-model="editedProperty.contact_info" label="Contact Info" />
        <InputText v-model="editedProperty.num_bedrooms" label="Bedrooms" />
        <InputText v-model="editedProperty.num_bathrooms" label="Bathrooms" />
        <InputText v-model="editedProperty.square_meters" label="Square Meters" />
        <InputText v-model="editedProperty.floor_number" label="Floor Number" />
        <Checkbox v-model="editedProperty.has_balcony" label="Has Balcony" :true-value="1" :false-value="0" />
        <Checkbox v-model="editedProperty.has_garden" label="Has Garden" :true-value="1" :false-value="0" />
        <Checkbox v-model="editedProperty.has_garage" label="Has Garage" :true-value="1" :false-value="0" />
        <Checkbox v-model="editedProperty.has_parking" label="Has Parking" :true-value="1" :false-value="0" />
        <Checkbox v-model="editedProperty.has_elevator" label="Has Elevator" :true-value="1" :false-value="0" />
        <InputText v-model="editedProperty.price" label="Price" />
        <InputText v-model="editedProperty.agent_name" label="Sales Agent" />
        <InputText v-model="editedProperty.listed_date" label="Listed Date" />
        <div class="p-field">
          <label for="image">Choose a different image:</label>
          <input type="file" id="image" accept="image/*" @change="handleFileChange">
        </div>
        <!-- Save Button -->
        <Button label="Save" icon="pi pi-check" @click="saveProperty" />
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
import Checkbox from 'primevue/checkbox';

// Import components
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';

// Setup references
const properties = ref([]);
const filters = ref({});
const loading = ref(true);
const editDialogVisible = ref(false);
const editedProperty = ref({});
let pollingInterval;

const handleFileChange = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('image', file);

  try {
    const response = await fetch('http://127.0.0.1:8000/api/propertyImage', {
      method: 'POST',
      body: formData,
    });

    if (!response.ok) {
      throw new Error('Image upload failed');
    }

    const result = await response.json();
    editedProperty.value.image = result.imagePath; // Assuming the API returns the new image path in the 'imagePath' field
  } catch (error) {
    console.error('Error uploading image:', error);
  }
};

// Fetch properties function using fetch API
const fetchProperties = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/properties'); // Change the URL to match your backend route
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    properties.value = data;
  } catch (error) {
    console.error('Error fetching properties:', error);
  } finally {
    loading.value = false;
  }
};

// Initialize filters
const initFilters = () => {
  filters.value = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
    description: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    property_type_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    address_line: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    city_village: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    municipality: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    country: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    postal_code: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    owner_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    contact_info: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] }
  };
};

// Clear filters
const clearFilter = () => {
  initFilters();
};

const getStatusLabel = (status) => {
  const statusLabels = {
    active: 'Active',
    inactive: 'Inactive',
    pending: 'Pending',
    sold: 'Sold'
  };
  return statusLabels[status] || 'Unknown';
};

const editProperty = (property) => {
  // Open the edit dialog and set the editedProperty object
  editDialogVisible.value = true;
  // Ensure that the 'id' property is included in the property object
  editedProperty.value = { ...property, id: property.id }; // Include id property
};

// Reset editedProperty object and hide the dialog
const resetEditProperty = () => {
  editedProperty.value = {};
  editDialogVisible.value = false;
};

const saveProperty = async () => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/properties/${editedProperty.value.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(editedProperty.value),
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const updatedProperty = await response.json();
    // Update the property in the properties array
    const index = properties.value.findIndex(p => p.id === updatedProperty.id);
    if (index !== -1) {
      properties.value.splice(index, 1, updatedProperty);
    }
    // Reset editedProperty object and hide the dialog
    resetEditProperty();
  } catch (error) {
    console.error('Error updating property:', error);
  }
};

// Start polling function
const startPolling = () => {
  pollingInterval = setInterval(fetchProperties, 2000); // Poll every 2 seconds
};

// Stop polling function
const stopPolling = () => {
  clearInterval(pollingInterval);
};

// Fetch properties and initialize filters when component is mounted
onMounted(() => {
  fetchProperties();
  startPolling(); // Start polling when component is mounted
  initFilters();
});

// Stop polling when component is destroyed
onUnmounted(() => {
  stopPolling(); // Stop polling when component is destroyed
});
</script>

<style>
.spacer {
  margin-top: 10rem;
}
</style>