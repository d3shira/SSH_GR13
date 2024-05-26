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
            <Button label="Residential" 
                    class="residential-button p-button-lg p-button-primary" 
                    :class="{ 'selected': selectedPropertyCategory === 'residential' }" 
                    @click="setPropertyCategory('residential')" />
            <Button label="Business" 
                    class="business-button p-button-lg p-button-primary" 
                    :class="{ 'selected': selectedPropertyCategory === 'business' }" 
                    @click="setPropertyCategory('business')" />
          </div>
          <!-- Search Bar and Radio Buttons -->
          <div class="search-container">
            <div class="radio-buttons p-field">
              <div class="p-formgrid p-grid">
                <div class="p-field-radiobutton p-col-6">
                  <RadioButton inputId="sale" name="propertyType" value="sale" v-model="selectedPropertyType" />
                  <label for="sale">For Sale</label>
                </div>
                <div class="p-field-radiobutton p-col-6">
                  <RadioButton inputId="rent" name="propertyType" value="rent" v-model="selectedPropertyType" />
                  <label for="rent">For Rent</label>
                </div>
              </div>
            </div>
            <div class="search-bar p-inputgroup p-col">
              <InputText placeholder="Search properties..." class="search-input p-inputtext-lg" v-model="searchQuery" />
              <Button icon="pi pi-search" class="search-button p-button-lg p-button-primary" @click="filterPropertiesBySearch" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New Listings Section -->
    <div ref="listingsSection" class="section-title">
      <h1>New Listings</h1>
    </div>
  
    <div class="property-container">
      <PropertyCard v-for="(property, index) in limitedProperties" :key="index" :property="property" style="margin: 10px;"/>
    </div>

    <div v-if="noProperties" class="no-properties-message">
      No properties found matching your criteria.
    </div>

    <div class="see-more-button-container">
      <Button label="See More" class="p-button-lg p-button-primary" @click="redirectToProperties" />
    </div>

    <!-- Agents -->
    <div class="section-title">
      <h1>Agents</h1>
    </div>

    <div style="display: flex; justify-content: center; align-items: center;">
      <AgentCard v-for="agent in agents" :key="agent.id" :agent="agent" />
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
import AgentCard from '@/components/AgentCard.vue';

export default {
  components: {
    Navbar,
    Button,
    InputText,
    RadioButton,
    Card,
    Footer,
    PropertyCard,
    AgentCard
  },
  data() {
    return {
      properties: [],
      searchQuery: '',
      selectedPropertyType: '',
      selectedPropertyCategory: '',
      noProperties: false,
      agents: []
    };
  },
  computed: {
    limitedProperties() {
      return this.properties.slice(0, 12);
    },
    agents(){
      return this.agents.slice(0, 3);
    }
  },
  mounted() {
    this.getProperties();
    this.fetchAgents();
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
    },
    setPropertyCategory(category) {
      this.selectedPropertyCategory = category;
    },
    async filterPropertiesBySearch() {
      const data = {
        query: this.searchQuery,
        propertyType: this.selectedPropertyType,
        propertyCategory: this.selectedPropertyCategory
      };
      try {
        const response = await fetch('http://127.0.0.1:8000/api/home/properties/filter', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data)
        });
        if (!response.ok) {
          throw new Error('Failed to fetch properties');
        }
        const jsonData = await response.json();
        this.properties = jsonData;
        this.noProperties = this.properties.length === 0;
        this.scrollToListings();
        this.clearFilters();
      } catch (error) {
        console.error('Error:', error);
      }
    },
    scrollToListings() {
      this.$nextTick(() => {
        this.$refs.listingsSection.scrollIntoView({ behavior: 'smooth' });
      });
    },
    clearFilters() {
      this.selectedPropertyType = '';
      this.searchQuery = '';
      this.selectedPropertyCategory = '';
    },
    redirectToProperties() {
      this.$router.push('/properties');
    },
    async fetchAgents() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/agents');
        if (!response.ok) {
          throw new Error('Failed to fetch agents');
        }
        const data = await response.json();
        this.agents = data;
      } catch (error) {
        console.error('Error fetching agents:', error);
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
  /* background-image: url('@/assets/images/photo.png'); */
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

.section-title {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
  color: #010633;
}

.buttons {
  margin-top: 20px;
}

.buttons .selected {
  background-color: #007ad9;
  color: white;
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

.property-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  margin-top: 20px;
}

.no-properties-message {
  color: #010633;
  text-align: center;
  margin-top: 20px;
}

.see-more-button-container {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-top: 20px;
  margin-right: 120px
}

.p-field-radiobutton {
  display: flex;
  align-items: center;
}

.p-field-radiobutton label {
  margin-left: 0.5rem;
}

.p-field-radiobutton input[type="radio"]:checked + label::before {
  content: "●";
  color: #055190;
  display: inline-block;
  width: 1em;
  height: 1em;
  line-height: 1em;
  text-align: center;
  border: 1px solid #055190;
  border-radius: 50%;
  margin-right: 0.5em;
}

</style>
