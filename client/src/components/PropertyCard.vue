<template>
  <div class="property-card">
    <i
      :class="['pi', isFavorite ? 'pi-heart-fill' : 'pi-heart', 'heart-icon']"
      @click.stop="toggleFavorite"
      :style="isFavorite ? 'color: red;' : ''"
    ></i>
    <Card
      style="width: 24rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); margin-right: 20px; position: relative;"
      @click="navigateToDetails"
    >
      <template #header>
        <div class="image-container">
          <img v-if="property.image_url" :src="property.image_url" alt="property image" />
          <img v-else alt="default header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
        </div>
      </template>
      <template #title">{{ property.title }}</template>
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
          <i class="pi pi-coins"></i>
          <span>{{ property.price }} €</span>
        </div>
      </template>
    </Card>
    <div v-if="errors.length > 0" class="error-messages">
      <div v-for="(error, index) in errors" :key="index">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import Card from 'primevue/card';
import axios from 'axios';

export default {
  components: {
    Card
  },
  props: {
    property: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isFavorite: false,
      user: null,
      errors: [],
    };
  },
  created() {
    this.fetchUser();
  },
  mounted() {
    this.isFavorite = this.checkIfFavorite();
  },
  watch: {
    user(newUser) {
      this.isFavorite = this.checkIfFavorite();
    }
  },
  methods: {
    navigateToDetails() {
      this.$router.push({ name: 'PropertyDetails', params: { id: this.property.id } });
    },
    toggleFavorite() {
      if (!this.user || !this.user.id) {
        this.errors.push('You must be logged in to add properties to favorites.');
        alert('You must be logged in to add properties to favorites.');
        return;
      }

      this.isFavorite = !this.isFavorite;
      let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      if (this.isFavorite) {
        if (!favorites.some(fav => fav.id === this.property.id)) {
          favorites.push(this.property);
        }
      } else {
        favorites = favorites.filter(fav => fav.id !== this.property.id);
      }
      localStorage.setItem('favorites', JSON.stringify(favorites));
      this.$emit('update-favorites', favorites); // Emit an event to update the favorites in the parent component
    },
    checkIfFavorite() {
      if (!this.user || !this.user.id) return false;
      const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      return favorites.some(fav => fav.id === this.property.id);
    },
    fetchUser() {
      axios.get('http://127.0.0.1:8000/api/user', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      .then(response => {
        this.user = response.data;
        this.isFavorite = this.checkIfFavorite();
      })
      .catch(error => {
        console.error("There was an error fetching the user data:", error);
        this.user = null;
        this.isFavorite = false;
      });
    }
  }
};
</script>

<style scoped>
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

.heart-icon {
  position: absolute;
  top: 10px;
  left: 10px;
  font-size: 1.5rem;
  cursor: pointer;
  transition: color 0.3s;
  z-index: 1; /* Ensure the icon is above other elements */
}

.heart-icon:hover {
  color: red;
}

.property-card {
  position: relative;
  cursor: pointer;
}

.error-messages {
  color: red;
  font-size: 0.9rem;
  margin-top: 10px;
}
</style>
