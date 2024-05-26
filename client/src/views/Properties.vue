<template>
  <div class="page-container">
    <Navbar />

    <div class="properties">
      <h1 style="color: white; display: flex; justify-content: center;">Properties</h1>
      <div class="property-container">
        <PropertyCard v-for="(property, index) in paginatedProperties" :key="index" :property="property" style="margin: 10px;" />
      </div>
      <Paginator 
        :rows="rowsPerPage" 
        :totalRecords="totalProperties" 
        :first="first" 
        @page="onPageChange" 
      />
    </div>

    <form class="extended-search" @submit.prevent="filterProperties">
      <h2 style="color: white;">Extended Search</h2>

      <div class="form-group">
        <label for="category" style="color: white;">Category</label>
        <select id="category" v-model="category">
          <option value="residential">Residential</option>
          <option value="business">Business</option>
        </select>
      </div>

      <div class="form-group">
        <label for="status" style="color: white;">Status</label>
        <select id="status" v-model="status">
          <option value=""></option>
          <option value="rent">For Rent</option>
          <option value="sale">For Sale</option>
        </select>
      </div>

      <div class="form-group">
        <label for="type" style="color: white;">Types</label>
        <select id="type" v-model="type">
          <option value=""></option>
          <option value="apartment">Apartment</option>
          <option value="house">House</option>
          <option value="business">Business</option>
        </select>
      </div>

      <div class="form-group">
        <label for="city" style="color: white;">City</label>
        <select id="city" v-model="city">
          <option v-for="(city, index) in cities" :key="index" :value="city">{{ city }}</option>
        </select>
      </div>

      <button type="submit">Search</button>
    </form>
  </div>
  <Footer />
</template>

<script>
import PropertyCard from '@/components/PropertyCard.vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import Paginator from 'primevue/paginator';

export default {
  components: {
    PropertyCard,
    Navbar,
    Footer,
    Paginator,
  },
  data() {
    return {
      properties: [],
      category: '',
      status: '',
      type: '',
      city: '',
      cities: [],
      first: 0,
      rowsPerPage: 6, // Change to 4 properties per page for testing
      totalProperties: 0,
    };
  },
  computed: {
    paginatedProperties() {
      const start = this.first;
      const end = this.first + this.rowsPerPage;
      return this.properties.slice(start, end);
    },
  },
  mounted() {
    this.getProperties();
    this.getCities();
  },
  methods: {
    async filterProperties() {
      this.first = 0; // Reset pagination to the first page when filtering
      await this.fetchProperties();
    },
    async getCities() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/cities'); // Adjust the endpoint according to your Laravel routes
        if (!response.ok) {
          throw new Error('Failed to fetch cities');
        }
        const data = await response.json();
        this.cities = data; // Set the fetched cities to the cities array
      } catch (error) {
        console.error('Error fetching cities:', error);
      }
    },
    async fetchProperties() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/properties/filter', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            category: this.category,
            status: this.status,
            type: this.type,
            city: this.city,
          }),
        });

        if (!response.ok) {
          throw new Error('Failed to fetch properties');
        }

        const data = await response.json();
        this.properties = data;
        this.totalProperties = data.length; // Update the total number of properties
        this.clearFilters();
      } catch (error) {
        console.error('Error fetching properties:', error);
      }
    },
    clearFilters() {
      this.category = '';
      this.status = '';
      this.type = '';
      this.city = '';
    },
    async getProperties() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/properties');
        if (!response.ok) {
          throw new Error('Failed to fetch properties');
        }
        const data = await response.json();
        this.properties = data;
        this.totalProperties = data.length; // Update the total number of properties
      } catch (error) {
        console.error('Error fetching properties:', error);
      }
    },
    onPageChange(event) {
      this.first = event.first;
    },
  },
};
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-top: 20px;
}
.pagination button {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
.page-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-top: 20px;
  margin-left: 100px;
  margin-right: 100px;
}

.hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}

.properties {
  padding-top: 100px;
  width: calc(66.66% - 20px);
}

.property-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0; /* You can add a gap if you want space between the containers */
}

.property-container > * {
  flex: 0 1 45.33%; /* Each item takes up 45.33% of the width */
  box-sizing: border-box;
}

.property {
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 20px;
  margin-bottom: 20px;
}

.property h3 {
  margin-top: 0;
}

.property p {
  margin-bottom: 10px;
}

.search-forms-container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: calc(33.33% - 20px);
}

.extended-search {
  width: 28%;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-top: 190px;
}

.form-group {
  margin-bottom: 20px;
}

.extended-search label {
  display: block;
  margin-bottom: 10px; /* Adjust spacing between labels */
  cursor: pointer;
}

.extended-search input[type="number"],
.extended-search input[type="text"],
.extended-search select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px; /* Add margin for spacing */
}

.extended-search button {
  width: 100%; /* Make the button the same width as the input fields */
  margin-top: 20px; /* Add margin for spacing */
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.extended-search button:hover {
  background-color: #0056b3;
}

.surface-group {
  display: flex;
  flex-direction: column;
}

.surface-label {
  margin-bottom: 5px;
}

.surface-inputs {
  display: flex;
}

.half-input {
  flex: 1; /* Each input takes half of the available space */
  margin-right: 10px; /* Add spacing between inputs */
}

.half-input:last-child {
  margin-right: 0; /* Remove margin from the last input */
}

.price-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.price-group label {
  margin-bottom: 5px;
}

.price-inputs {
  display: flex;
}

.price-inputs .half-input {
  flex: 1;
  margin-right: 10px;
}

.price-inputs .half-input:last-child {
  margin-right: 0;
}

.room-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.room-group label {
  margin-bottom: 5px;
}

.room-inputs {
  display: flex;
}

.room-inputs .half-input {
  flex: 1;
  margin-right: 10px;
}

.room-inputs .half-input:last-child {
  margin-right: 0;
}

.extended-search button {
  width: 50%; /* Make the button the same width as the input fields */
  margin-top: 20px; /* Add margin for spacing */
  padding: 10px 20px;
  background-color: #1434A4; /* Set the background color to red */
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
