<template>
  <div class="agent-card">
    <Card class="agent-card-inner">
      <template #header>
        <img :src="agent.photo" alt="agent photo" class="agent-photo" />
      </template>
      <template #title>
        <div class="agent-name">{{ agent.first_name }} {{ agent.last_name }}</div>
      </template>
      <template #subtitle>
        <div class="agent-title">{{ agent.job_position }}</div>
      </template>
      <template #content>
        <div class="agent-contact">
          <div>Email: {{ agent.email }}</div>
          <div>Phone: {{ agent.phone }}</div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import Card from 'primevue/card';

export default {
  components: {
    Card
  },
  props: {
    agent: {
      type: Object,
      required: true,
    }
  }
};
</script>

  
  <style scoped>
  .agent-card {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
  }
  
  .agent-card-inner {
    width: 25rem;
    height: 25rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    padding: 10px;
  }
  
  .agent-photo {
    width: 100%;
    height: 12rem;
    border-radius: 5px;
    margin-bottom: 10px;
  }
  
  .agent-name {
    font-size: 1.2rem;
    font-weight: bold;
  }
  
  .agent-title {
    font-style: italic;
  }
  
  .agent-contact {
    background-color: #f0f0f0;
    padding: 5px;
    border-radius: 5px;
  }
  </style>
  
  