<template>
    <div class="footer">
      <div class="footer-content p-d-flex p-jc-between">
        <div class="left-section">
          <h4>KOSOVA ESTATE</h4>
          <div class="kosova-description">
            Your trusted partner in real estate.
          </div>
        </div>
        <div class="contact-info">
          <h4>CONTACT</h4>
          <div class="contact-line">
            <div class="contact-line">
            <i class="pi pi-map-marker" style="margin-right: 5px;"></i> 123 Main Street
          </div>
          <div class="contact-line">
            <i class="pi pi-globe" style="margin-right: 5px;"></i> City, Country
          </div>
          <div class="contact-line">
            <i class="pi pi-envelope" style="margin-right: 5px;"></i> Email: info@kosovaestate.com
          </div>
          <div class="contact-line">
            <i class="pi pi-phone" style="margin-right: 5px;"></i> Phone: +123 456 789
          </div>
        </div>
      </div>
        <div class="menu-items">
          <h4>NAVIGATION</h4>
          <router-link to="/" class="footer-link">Home</router-link>
          <router-link to="/properties" class="footer-link">Properties</router-link>
          <router-link to="/agents" class="footer-link">Agents</router-link>
          <router-link to="/aboutus" class="footer-link">About Us</router-link>
          <router-link to="/contact" class="footer-link">Contact Us</router-link>
        </div>
      </div>
      <hr class="footer-line" />
      <div class="footer-copyright">
        &copy; 2024 Kosova Estate. All rights reserved.
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Footer',
  };
  </script>
  
  <style scoped>
  .footer {
    background-color: #010633;
    color: white;
    padding: 20px;
    margin-top: 50px;
    position: absolute;
    right: 0;
    left: 0;
  }
  
  .footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: flex-start;
    padding-left: 150px;
  }
  
  .left-section,
  .contact-info,
  .menu-items {
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .footer-link {
    color: white;
    text-decoration: none;
    margin-bottom: 10px;
  }
  
  .footer-link:hover {
    text-decoration: underline;
  }
  
  .footer-line {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #3C5B6F;
  }

  .contact-line {
    margin-bottom: 10px; /* Same margin as the navigation links */
  }
  
  .footer-copyright {
    margin-top: 20px;
    text-align: center;
  }
  </style>
  