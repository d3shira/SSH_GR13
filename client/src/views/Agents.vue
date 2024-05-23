<template>
  <div class="agents">
    <!-- Navbar -->
    <Navbar />
    <!-- Agents Page Content -->
    <div class="agents-content">
      <h1 class="page-title">Meet our team!</h1>
      <p class="page-description">
        Our team of dedicated agents works tirelessly to provide the best service possible. 
        Each member brings a wealth of experience and a strong commitment to excellence, 
        ensuring that all your needs are met with the highest standards. They are passionate, 
        diligent, and always ready to go the extra mile to achieve outstanding results for our clients.
      </p>
      <!-- Agent cards -->
      <div class="agents-list">
        <AgentCard v-for="agent in paginatedAgents" :key="agent.id" :agent="agent" />
      </div>
      <!-- Paginator Component -->
      <Paginator 
        :rows="rowsPerPage" 
        :totalRecords="totalAgents" 
        :first="first" 
        @page="onPageChange" 
      />
    </div>
    <Footer />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import AgentCard from '@/components/AgentCard.vue';
import Paginator from 'primevue/paginator';

export default {
  components: {
    Navbar,
    Footer,
    AgentCard,
    Paginator,
  },
  data() {
    return {
      agents: [],
      totalAgents: 0,
      first: 0,
      rowsPerPage: 6,
    };
  },
  computed: {
    paginatedAgents() {
      const start = this.first;
      const end = this.first + this.rowsPerPage;
      return this.agents.slice(start, end);
    }
  },
  mounted() {
    this.fetchAgents();
  },
  methods: {
    async fetchAgents() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/agents');
        if (!response.ok) {
          throw new Error('Failed to fetch agents');
        }
        const data = await response.json();
        this.agents = data;
        this.totalAgents = data.length;
      } catch (error) {
        console.error('Error fetching agents:', error);
      }
    },
    onPageChange(event) {
      this.first = event.first;
    }
  }
}
</script>

<style scoped>
.agents {
  padding-top: 75px; /* Ensure content starts below the navbar */
}

.agents-content {
  max-width: 1000px; /* Increase the max-width for a wider content area */
  margin: 0 auto;
  padding: 20px;
}

.page-title {
  text-align: center;
  color: white;
}

.page-description {
  text-align: center;
  margin-bottom: 20px;
  color: white;
}

.agents-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.agent-card {
  width: calc(33.3333% - 30px); /* 3 cards per row with space */
  margin: 15px;
  box-sizing: border-box;
}

/* Other styles as needed */
</style>

  