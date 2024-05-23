<template>
    <div>
      <Navbar />
  
      <div class="about-us-container">
        <div class="background-image">
          <h1 class="about-us-title">About Us</h1>
        </div>
  
        <div class="static-boxes">
          <div class="static-box">
            <i class="pi pi-users static-box-icon"></i>
            <h2>Agents</h2>
            <p>Meet our professional agents who are ready to help you.</p>
          </div>
          <div class="static-box">
            <i class="pi pi-home static-box-icon"></i>
            <h2>Properties</h2>
            <p>Explore our wide range of properties available for you.</p>
          </div>
          <div class="static-box">
            <i class="pi pi-chart-line static-box-icon"></i>
            <h2>Sales</h2>
            <p>Check out our latest sales and offers.</p>
          </div>
        </div>
      </div>
  
      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from '@/components/Navbar.vue';
  import Footer from '@/components/Footer.vue';
  
  export default {
    name: "AboutUs",
    components: {
      Navbar,
      Footer
    }
  };
  </script>
  
  <style scoped>
  .about-us-container {
    text-align: center;
    margin: 0;
    padding: 0;
  }
  
  .background-image {
    background-size: cover;
    background-position: top;
    height: 60vh; 
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }
  
  .about-us-title {
    color: white;
    font-size: 3em;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    position: relative;
    z-index: 2;
  }
  
  .static-boxes {
    display: flex;
    justify-content: space-around;
    padding: 20px 0;
    margin-top: -5vh; 
  }
  
  .static-box {
    flex: 1;
    padding: 20px;
    margin: 10px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s;
  }
  
  .static-box:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
  
  .static-box-icon {
    font-size: 2em;
    margin-bottom: 10px;
  }
  
  .static-box h2 {
    margin-top: 10px;
    font-size: 1.5em;
  }
  
  .static-box p {
    margin-top: 5px;
    font-size: 1em;
    color: #666;
  }
  </style>
  