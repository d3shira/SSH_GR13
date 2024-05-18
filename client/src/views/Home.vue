<template>
  <div class="home">
    <!-- Navbar -->
    <Navbar />

    <!-- Home Content -->
    <div class="home-content">
      <!-- Background Image -->
      <div class="background-image">
        <!-- Text and Buttons -->
        <div class="content">
          <h1>Welcome to Kosova Estate</h1>
          <p>Find your dream home with us</p>
          <div class="buttons">
            <Button label="Residential" class="p-button-lg p-button-primary" />
            <Button label="Business" class="p-button-lg p-button-primary" />
          </div>
          <!-- Search Bar and Radio Buttons -->
          <div class="search-container">
            <div class="radio-buttons p-field">
              <div class="p-formgrid p-grid">
                <div class="p-field-radiobutton p-col-6">
                  <RadioButton inputId="sale" name="propertyType" value="sale" class="p-mr-2" />
                  <label for="sale">For Sale</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                  <RadioButton inputId="rent" name="propertyType" value="rent" class="p-mr-2" />
                  <label for="rent">For Rent</label>
                </div>
              </div>
            </div>
            <div class="search-bar p-inputgroup p-col">
              <InputText placeholder="Search properties..." class="p-inputtext-lg" />
              <Button icon="pi pi-search" class="p-button-lg p-button-primary" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New Listings Section -->
    <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
      <h1 style="color: #010633;">New Listings</h1>
    </div>
  
    <div style="display: flex; justify-content: center; align-items: center;">
      <PropertyCard v-for="(property, index) in properties" :key="index" :property="property" />
    </div>

    <!-- Agents -->
    <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
      <h1 style="color: #010633;">Agents</h1>
    </div>

    <div style="display: flex; justify-content: center; align-items: center;">
    <Card style="width: 20rem; height: 25rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); padding: 10px;">
      <template #header>
        <img alt="agent photo" src="https://primefaces.org/cdn/primevue/images/usercard.png" style="width: 100%; height: 12rem; border-radius: 5px; margin-bottom: 10px;" />
      </template>
      <template #title>
        <div style="font-size: 1.2rem; font-weight: bold;">Agent Name Surname</div>
      </template>
      <template #subtitle>
        <div style="font-style: italic;">Real Estate Agent</div>
      </template>
      <template #content>
        <div style="background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
            <div>Email: agent@example.com</div>
            <div>Phone: +1 (123) 456-7890</div>
        </div>
      </template>
    </Card>
    </div>

    <Footer />

  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import RadioButton from 'primevue/radiobutton';
import Card from 'primevue/card';
import Footer from '@/components/Footer.vue';
import PropertyCard from '@/components/PropertyCard.vue';

export default {
  components: {
    Navbar,
    Button,
    InputText,
    RadioButton,
    Card,
    Footer,
    PropertyCard
  },
  data() {
    return {
      properties: []
    };
  },
  mounted() {
    this.getProperties();
  },
  methods: {
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
.home {
  height: 100vh;
}

.home-content {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.background-image {
  background-image: url('@/assets/images/photo.png');
  background-size: cover;
  background-position: center;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
}

.content {
  text-align: center;
  color: white;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
}

.buttons {
  margin-top: 20px;
}

.p-button-lg {
  padding: 10px 20px;
  margin: 0 10px;
  font-size: 1.2rem;
  background-color: #055190;
  border: #303B98;
}

.search-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-bar {
  margin-top: 20px;
  margin-left: 10px;
  width: 600px; 
}

.radio-buttons {
  margin-top: 20px;
  margin-right: 10px; 
}

</style>
