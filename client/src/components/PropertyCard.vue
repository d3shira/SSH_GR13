<template>
  <router-link :to="{ name: 'PropertyDetails', params: { id: property.id } }" style="text-decoration: none;">
    <Card
      style="width: 24rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); margin-right: 20px;"
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
          <i class="pi pi-coins"></i>
          <span>{{ property.price }} €</span>
        </div>
      </template>
    </Card>
  </router-link>
</template>

<script>
import Card from 'primevue/card';

export default {
  components: {
    Card
  },
  props: {
    property: {
      type: Object,
      required: true
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
  </style>
  
