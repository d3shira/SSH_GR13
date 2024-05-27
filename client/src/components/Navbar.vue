<template>
  <div>
    <div class="background-image"></div>
    <div class="p-shadow-2 navbar">
      <div class="p-d-flex p-jc-between p-ai-center" style="display: flex; align-items: center;">
        <div class="p-text-center">
          <div class="logo"> <img width="50px" height="50" src="../assets/images/kosova-estate.png"> </div>
          <div class="title"> <router-link to="/" class="logo">Kosova Estate</router-link> </div>
        </div>
        <div class="menu-items p-d-flex p-ai-center">
          <div class="p-mx-3">
            <router-link to="/properties" class="menu-item">Properties</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/agents" class="menu-item">Agents</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/aboutus" class="menu-item">About Us</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/careers" class="menu-item">Career</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/contact" class="menu-item">Contact Us</router-link>
          </div>
          <div class="p-mx-3">
            <router-link to="/login" class="menu-item">Login</router-link>
          </div>

          <div class="faq">
            <router-link to="/faqs">
              <i class="fas fa-question-circle" style="font-size: 1.7rem; color:white;"></i>
            </router-link>
          </div>
          <div class="favorites">
            <router-link to="/favorites">
              <i class="fas fa-heart" style="font-size: 1.7rem; color:white;"></i>
            </router-link>
          </div>
          <div class="user-menu">
            <Menu :model="userMenuItems" popup ref="userMenu"></Menu>
            <i class="fas fa-user" style="font-size: 1.7rem; color:white; cursor: pointer;" @click="$refs.userMenu.toggle($event)"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Menu from 'primevue/menu';

export default {
  name: 'Navbar',
  components: {
    Menu
  }, 
  data() {
    return {
      userMenuItems: [
        {
          label: 'Login',
          icon: 'pi pi-fw pi-sign-in',
          command: () => { this.$router.push('/login'); }
        },
        {
          label: 'Logout',
          icon: 'pi pi-fw pi-sign-out',
          command: this.logout
        }
      ]
    };
  },
  methods: {
    logout() {
      fetch('http://127.0.0.1:8000/api/logout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.message) {
          localStorage.removeItem('auth_token');
          this.$router.push({ path: '/' }); // Redirect to the home page
        } else {
          console.error('Logout failed', data);
        }
      })
      .catch(error => {
        console.error('Error during logout', error);
      });
    }
  }
};
</script>

<style scoped>
.background-image {
  background-image: url('@/assets/images/photo.png');
  background-size: cover;
  background-position: center;
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: -1;
}

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
  justify-content: end;
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

.faq {
  margin-left: 250px;
  margin-right: 30px;
}

.favorites {
  margin-right: 30px;
}

.user-menu {
  display: flex;
  align-items: center;
  margin-left: 20px;
}
</style>
