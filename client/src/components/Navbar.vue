<template>
  <div>
    <div class="background-image"></div>
    <div class="p-shadow-2 navbar">
      <div class="p-d-flex p-jc-between p-ai-center" style="display: flex; align-items: center;">
        <div class="logo p-text-center">Kosova Estate</div>
        <div class="menu-items p-d-flex p-ai-center">
          <div class="p-mx-3">
            <router-link to="/properties" class="menu-item">Properties</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/agents" class="menu-item">Agents</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="" class="menu-item">About Us</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/careers" class="menu-item">Career</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="" class="menu-item">Contact Us</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/login" class="menu-item">Login</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  </template>
  
  <script>
  export default {
    name: 'Navbar',
  };
  </script>
  
  <style scoped>
  .background-image {
    background-image: url('@/assets/images/photo.png');
    background-size: cover;
    background-position: center;
    position: absolute; /*was fixed*/
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    /*filter: saturate(0.5); /* Adjust values as needed */
}
  .navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #010633;
    /*background-color: rgba(1, 6, 51, 0.8); /* Add some transparency to the navbar */
    color: white;
    padding: 25px 20px; 
    width: 100%;
    z-index: 1000;
  }
  
  .logo {
    font-size: 1.5rem;
    font-weight: bold;
  }
  
  .menu-items {
    flex: 1; 
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .menu-item {
    color: white;
    text-decoration: none;
    padding: 10px 20px; 
    margin: 0 10px; 
    font-weight: bold;
  }
  
  .menu-item:hover {
    background-color: #010633;
    color: #3C5B6F;
    transition: 1ms;
  }
  </style>
  