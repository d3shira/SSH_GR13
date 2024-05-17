<template>
    <Card
      style="width: 25rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); margin-right: 20px;"
    >
      <template #header>
        <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
      </template>
      <template #title>Property</template>
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
  /* Add any scoped styles for the card component */
  </style>
  