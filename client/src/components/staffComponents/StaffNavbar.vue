<template>
    <div>
      <div class="p-shadow-2 navbar">
        <div class="p-d-flex p-jc-between p-ai-center" style="display: flex; align-items: center;">
          <div class="p-text-center"> 
              <div class="logo"> <img width="50px" height="50" src="../../assets/images/kosova-estate.png"> </div>
              <div class="title"> <router-link to="/" class="logo">Kosova Estate</router-link> </div>
          </div>
          <div class="menu-items p-d-flex p-ai-center">
            <div class="p-mx-3 dropdown">
              <router-link to="/properties" class="menu-item">Properties</router-link>
              <div class="dropdown-content">
                <router-link to="/add-property" class="dropdown-item">Add Property</router-link>
                <router-link to="/owners" class="dropdown-item">Owners</router-link>
              </div>
            </div>
            <div class="p-mx-3">
              <router-link to="/faqs" class="menu-item">FAQs</router-link>
            </div>
            <div class="p-mx-3">
              <router-link to="/contracts" class="menu-item">Contracts</router-link>
            </div>
            <div class="p-mx-3">
              <router-link to="/messages" class="menu-item">Messages</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'StaffNavbar',
  };
  </script>
  
  <style scoped>
  .navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #010633;
    color: white;
    padding: 25px 20px;
    width: 100%;
    z-index: 1000;
  }
  
  .logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    text-decoration: none;
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
  
  .p-text-center {
    display: flex;
  }
  
  .title {
    margin-top: 15px;
    margin-left: 15px;
  }
  
  .dropdown {
    position: relative;
    display: inline-block;
  }
  
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #010633;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  
  .dropdown:hover .dropdown-content {
    display: block;
  }
  
  .dropdown-item {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }
  
  .dropdown-item:hover {
    background-color: #575757;
  }
  </style>
  
  