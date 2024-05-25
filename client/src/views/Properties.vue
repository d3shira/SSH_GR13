<template>
  <div class="page-container">
    <Navbar />

    <div class="properties">
      <h2>Properties</h2>
      <div class="property-container">
        <PropertyCard v-for="(property, index) in limitedProperties" :key="index" :property="property" style="margin: 10px;" />
      </div>
      <Paginator 
        :rows="rowsPerPage" 
        :totalRecords="totalAgents" 
        :first="first" 
        @page="onPageChange" 
      />
    </div>

    <form class="extended-search" @submit.prevent="filterProperties">
      <h2 style="color: white;">Kërkimi i zgjeruar</h2>

      <div class="form-group">
        <label for="category"  style="color: white;">Kategoria</label>
        <select id="category" v-model="category">
          <option value="residential">Residenciale</option>
          <option value="business">Biznes</option>
        </select>
      </div>

      <div class="form-group">
        <label for="status" style="color: white;">Statuset</label>
        <select id="status" v-model="status">
          <option value=""></option>
          <option value="rent">Për Qira</option>
          <option value="sale">Për Shitje</option>
        </select>
      </div>

      <div class="form-group">
        <label for="type" style="color: white;">Tipet</label>
        <select id="type" v-model="type">
          <option value=""></option>
          <option value="apartment">Apartment</option>
          <option value="house">House</option>
          <option value="business">Business</option>
        </select>
      </div>

      <div class="form-group">
        <label for="city" style="color: white;">Qytet</label>
        <select id="city" v-model="city">
          <option value=""></option>
          <option value="New York">New York</option>
          <option value="Toronto">Toronto</option>
          <option value="Gjakove">Gjakove</option>
          <option value="Gjilan">Gjilan</option>
          <option value="Kosove">Kosove</option>
          <option value="Lipjan">Lipjan</option>
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
      first: 0,
      rowsPerPage: 6,
    };
  },
  computed: {
    limitedProperties() {
      return this.properties.slice(0, 6
      );
      
    }
    
  },
  mounted() {
    this.getProperties();
  },
  methods: {
    async filterProperties() {
      console.log('Submitting search with the following parameters:');
      console.log({
        category: this.category,
        status: this.status,
        type: this.type,
        city: this.city
      });

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
            city: this.city
          }),
        });

        console.log('Response status:', response.status);

        if (!response.ok) {
          throw new Error('Failed to fetch properties');
        }

        const data = await response.json();
        console.log('Fetched properties:', data);

        this.properties = data;
      } catch (error) {
        console.error('Error fetching properties:', error);
      }
    },
    async getProperties() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/properties');
        if (!response.ok) {
          throw new Error('Failed to fetch properties');
        }
        const data = await response.json();
        this.properties = data;
      } catch (error) {
        console.error('Error fetching properties:', error);
      }
    }
  }
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
  width: calc(66.66% - 20px);
}

.property-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0; /* You can add a gap if you want space between the containers */
}

.property-container > * {
  flex: 0 1 45.33%; /* Each item takes up 33.33% of the width */
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
  margin-top: 80px;
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