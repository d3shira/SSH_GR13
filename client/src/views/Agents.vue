<template>
    <div class="agents">
      <!-- Navbar -->
      <Navbar />
      <!-- Agents Page Content -->
      <div class="agents-content">
        <h1 class="agents-title">Agents</h1>
        <div class="content">
            <br>
            <br>
          <h1>Meet our team!</h1>
          <p>Our team of dedicated agents works tirelessly to provide the best service possible. 
                Each member brings a wealth of experience and a strong commitment to excellence, 
                ensuring that all your needs are met with the highest standards. They are passionate, 
                diligent, and always ready to go the extra mile to achieve outstanding results for our clients.</p>
          <div class="agents-list">
            <AgentCard v-for="agent in agents" :key="agent.id" :agent="agent" />
          </div>
          <div class="agents-section">
            <p>Deshira</p>
            <p>Is this working??</p>
            <p>What...??</p>
            <p>Hello there... Testing page??</p>
            <p>Lorem Ipsum stuff</p>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from '@/components/Navbar.vue'
  import Footer from '@/components/Footer.vue'
  import AgentCard from '@/components/AgentCard.vue';
  
  export default {
    components: {
      Navbar,
      Footer,
      AgentCard
    },
    data() {
      return {
        agents: [
          {
            id: 1,
            name: 'John Doe',
            title: 'Real Estate Agent',
            email: 'john@example.com',
            phone: '+1 (123) 456-7890',
            photo: 'https://primefaces.org/cdn/primevue/images/usercard.png',
          },
          {
            id: 2,
            name: 'Jane Smith',
            title: 'Real Estate Agent',
            email: 'jane@example.com',
            phone: '+1 (987) 654-3210',
            photo: 'https://primefaces.org/cdn/primevue/images/usercard.png',
          },
        ],
      };
    }
  };
  </script>
  
  <style scoped>
  .agents {
    height: 100vh;
    padding-top: 75px; /* Ensure content starts below the navbar */
  }
  
  .agents-content {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column; /* Ensure content is stacked vertically */
    text-align: center; /* Center text */
    padding: 0 20px; /* Add some padding to the sides */
  }
  
  .content {
    color: white;
    width: 100%;
    max-width: 800px; /* Limit the maximum width for better readability */
  }
  
  .agents-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .agents-section {
    margin-top: 20px; /* Add some spacing between the text blocks */
  }
  
  .agents-section p {
    margin: 10px 0; /* Add some margin between paragraphs */
  }
  </style>
  