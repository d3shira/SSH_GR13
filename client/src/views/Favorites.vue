<template>
    <div class="favorites-page">
      <Navbar />
      <h1>Favorites</h1>
      <div v-if="!isLoggedIn">
        <p>You must be logged in to see your favorite properties.</p>
      </div>
      <div v-else>
        <div v-if="favoriteProperties.length === 0" class="no-favorites">
          No favorite properties.
        </div>
        <div v-else class="property-container">
          <PropertyCard 
            v-for="(property, index) in favoriteProperties" 
            :key="index" 
            :property="property"
            @update-favorites="updateFavorites"
          />
        </div>
      </div>
      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from '@/components/Navbar.vue';
  import PropertyCard from '@/components/PropertyCard.vue';
  import Footer from '@/components/Footer.vue';
  
  export default {
    components: {
      Navbar,
      PropertyCard,
      Footer
    },
    data() {
      return {
        favoriteProperties: [],
        isLoggedIn: false
      };
    },
    created() {
      this.checkLoginStatus();
      this.loadFavorites();
    },
    methods: {
      checkLoginStatus() {
        const token = localStorage.getItem('auth_token');
        this.isLoggedIn = !!token;
      },
      loadFavorites() {
        if (this.isLoggedIn) {
          this.favoriteProperties = JSON.parse(localStorage.getItem('favorites')) || [];
        } else {
          this.favoriteProperties = [];
        }
      },
      updateFavorites(favorites) {
        this.favoriteProperties = favorites;
      }
    },
    watch: {
      isLoggedIn(newStatus) {
        if (!newStatus) {
          this.favoriteProperties = [];
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .favorites-page {
    padding-top: 100px;
  }
  
  .property-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }
  
  .no-favorites {
    text-align: center;
    font-size: 1.5rem;
    margin-top: 20px;
  }
  </style>
  