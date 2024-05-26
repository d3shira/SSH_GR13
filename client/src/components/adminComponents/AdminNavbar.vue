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
              <router-link to="/staff" class="menu-item">Staff</router-link>
              <div class="dropdown-content">
                <router-link to="/registerStaff" class="dropdown-item">Add Staff</router-link>
                <router-link to="/updateStaff" class="dropdown-item">Update Staff</router-link>
                <router-link to="/deleteStaff" class="dropdown-item">Delete Staff</router-link>
              </div>
            </div>
            <div class="p-mx-3 dropdown">
              <router-link to="/manageClients" class="menu-item">Clients</router-link>
              <div class="dropdown-content">
                <router-link to="/addClient" class="dropdown-item">Add Client</router-link>
                <router-link to="/editClient" class="dropdown-item">Update Client</router-link>
                <router-link to="/manageClients" class="dropdown-item">Delete Clients</router-link>
              </div>
            </div>
            <div class="p-mx-3 dropdown">
              <router-link to="/properties" class="menu-item">Properties</router-link>
              <div class="dropdown-content">
                <router-link to="/add-properties" class="dropdown-item">Add Properties</router-link>
                <router-link to="/update-properties" class="dropdown-item">Update Properties</router-link>
                <router-link to="/delete-Properties" class="dropdown-item">Delete Properties</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AdminNavbar',
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
  
  