<template>
  <div>
    <h1 style="display: flex; justify-content: center; margin-bottom: 40px;">Properties</h1>
    <div class="property-list">
      <Card
        v-for="property in properties"
        :key="property.id"
        style="width: 24rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); margin-right: 20px; margin-bottom: 20px;"
      >
        <template #header>
          <div class="image-container">
            <img v-if="property.image_url" :src="property.image_url" alt="property image" />
            <img v-else alt="default header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
          </div>
        </template>
        <template #title>{{ property.title }}</template>
        <template #subtitle>
          <div class="flex items-center gap-2">
            <i class="pi pi-map-marker"></i>
            <span>{{ property.municipality }}, {{ property.address_line }}</span>
          </div>
        </template>
        <template #content>
          <div class="flex items-center gap-2 mt-4">
            <i class="pi pi-home"></i>
            <span>{{ property.num_bedrooms }} Bedrooms</span>
            <i class="pi pi-chart-line"></i>
            <span>{{ property.square_meters }} sqm</span>
          </div>
        </template>
        <template #footer>
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <i class="pi pi-coins"></i>
              <span>{{ property.price }} €</span>
            </div>
          </div>
          <div class="buttons">
            <!-- Edit button -->
            <Button
              label="Edit"
              icon="pi pi-pencil"
              class="p-button-rounded p-button-primary"
              @click.prevent="showEditDialog(property)"
            />
            <!-- Delete button -->
            <Button
              label="Delete"
              icon="pi pi-trash"
              class="p-button-rounded p-button-danger"
              @click.prevent="deleteProperty(property.id)"
            />
          </div>
        </template>
      </Card>
    </div>

    <!-- Editing dialog -->
    <Dialog v-model:visible="displayEditDialog" header="Edit Property" :modal="true" :closable="false" :style="{ width: '60vw', maxWidth: '800px' }">
      <div>
        <!-- Edit form -->
        <form @submit.prevent="submitEditForm">
          <div class="field">
            <label for="title">Title</label>
            <input v-model="editForm.title" type="text" id="title" />
          </div>
          <div class="field">
            <label for="municipality">Municipality</label>
            <input v-model="editForm.municipality" type="text" id="municipality" />
          </div>
          <div class="field">
            <label for="address_line">Address Line</label>
            <input v-model="editForm.address_line" type="text" id="address_line" />
          </div>
          <div class="field">
            <label for="description">Description</label>
            <textarea v-model="editForm.description" id="description"></textarea>
          </div>
          <div class="field">
            <label for="status">Status</label>
            <select v-model="editForm.status" id="status">
              <option value="available">Available</option>
              <option value="sold">Sold</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          <div class="field">
            <label for="num_bedrooms">Number of Bedrooms</label>
            <input v-model="editForm.num_bedrooms" type="number" id="num_bedrooms" />
          </div>
          <div class="field">
            <label for="num_bathrooms">Number of Bathrooms</label>
            <input v-model="editForm.num_bathrooms" type="number" id="num_bathrooms" />
          </div>
          <div class="field">
            <label for="floor_number">Floor Number</label>
            <input v-model="editForm.floor_number" type="number" id="floor_number" />
          </div>
          <div class="field">
            <label for="square_meters">Square Meters</label>
            <input v-model.number="editForm.square_meters" type="number" id="square_meters" />
          </div>
          <div class="field">
            <label for="price">Price</label>
            <input v-model="editForm.price" type="number" id="price" />
          </div>
          <div class="checkbox-field">
            <label for="balcony">Balcony</label>
            <input v-model="editForm.balcony" type="checkbox" id="balcony" style="margin-left: 12px;"/>
          </div>
          <div class="checkbox-field">
            <label for="garden">Garden</label>
            <input v-model="editForm.garden" type="checkbox" id="garden" style="margin-left: 17px;"/>
          </div>
          <div class="checkbox-field">
            <label for="garage">Garage</label>
            <input v-model="editForm.garage" type="checkbox" id="garage" style="margin-left: 16px;"/>
          </div>
          <div class="checkbox-field">
            <label for="parking">Parking</label>
            <input v-model="editForm.parking" type="checkbox" id="parking" style="margin-left: 14px;"/>
          </div>
          <div class="checkbox-field">
            <label for="elevator">Elevator</label>
            <input v-model="editForm.elevator" type="checkbox" id="elevator" style="margin-left: 10px;"/>
          </div>
          <div class="buttons" style="justify-content: flex-end;">
            <Button label="Cancel" icon="pi pi-times" class="p-button-secondary" @click="displayEditDialog = false" />
            <Button label="Save" icon="pi pi-check" class="p-button-primary" type="submit" />
          </div>
        </form>
      </div>
    </Dialog>
  </div>
</template>

<script>
import { ref } from 'vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

export default {
  components: {
    Card,
    Button,
    Dialog,
  },
  setup() {
    const properties = ref([]);
    const displayEditDialog = ref(false);
    const editForm = ref({
      title: '',
      municipality: '',
      address_line: '',
      description: '',
      status: '',
      num_bedrooms: '',
      num_bathrooms: '',
      floor_number: '',
      square_meters: null,
      price: '',
      balcony: false,
      garden: false,
      garage: false,
      parking: false,
      elevator: false,
    });

    const showEditDialog = (property) => {
      editForm.value = { ...property };
      displayEditDialog.value = true;
    };

    const deleteProperty = async (id) => {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/properties/${id}`, {
          method: 'DELETE',
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        await getProperties();
      } catch (error) {
        console.error('Error deleting property:', error);
      }
    };

    const getProperties = async () => {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/properties');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        properties.value = data.map((item) => ({
          id: item.id,
          title: item.title,
          municipality: item.municipality,
          address_line: item.address_line,
          description: item.description,
          status: item.status,
          num_bedrooms: item.num_bedrooms,
          num_bathrooms: item.num_bathrooms,
          floor_number: item.floor_number,
          square_meters: item.square_meters,
          price: item.price,
          balcony: item.balcony,
          garden: item.garden,
          garage: item.garage,
          parking: item.parking,
          elevator: item.elevator,
          image_url: item.image_url,
        }));
      } catch (error) {
        console.error('Error fetching properties:', error);
      }
    };

    const submitEditForm = async () => {
      try {
        editForm.value.square_meters = parseInt(editForm.value.square_meters, 10);
        const response = await fetch(`http://127.0.0.1:8000/api/properties/${editForm.value.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(editForm.value),
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        displayEditDialog.value = false;
        await getProperties();
      } catch (error) {
        console.error('Error updating property:', error);
      }
    };
    getProperties();

    return {
      properties,
      displayEditDialog,
      editForm,
      showEditDialog,
      deleteProperty,
      submitEditForm,
    };
  },
};
</script>

<style scoped>
.property-list {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.image-container {
  width: 100%;
  height: 280px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.buttons {
  display: flex;
  justify-content: flex-end;
  margin-top: 10px;
  gap: 8px;
}

.field {
  margin-bottom: 1rem;
}

.field label {
  display: block;
  margin-bottom: 0.5rem;
}

.field input,
.field textarea,
.field select {
  width: 100%;
  padding: 0.5rem;
  box-sizing: border-box;
}

.checkbox-field{
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
</style> 