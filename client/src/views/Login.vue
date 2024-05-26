<template>
  <div class="login-page">
    <!-- Navbar -->
    <Navbar />

    <!-- Login Form Content -->
    <div class="login-form-content">
      <!-- Form Content -->
      <div class="content">
        <!-- Login Form -->
        <div class="form-container">
          <h1>Login</h1>
          <form @submit.prevent="submitForm">
            <div class="p-field p-grid">
              <label for="username" class="p-col-12 p-md-2">Username</label>
              <div class="p-col-12 p-md-10">
                <br>
                <InputText id="username" v-model="form.username" class="input-field" required />
              </div>
            </div>
            <div class="p-field p-grid">
              <br>
              <label for="password" class="p-col-12 p-md-2">Password</label>
              <div class="p-col-12 p-md-10">
                <br>
                <InputText id="password" v-model="form.password" type="password" class="input-field" required />
              </div>
            </div>
            <div class="p-field p-grid">
              <div class="p-col-12">
                <br>
                <Button type="submit" label="Login" class="p-button-lg p-button-primary" />
              </div>
            </div>
          </form>
          <div class="create-account">
            <p>No Account? <router-link to="/register" style="color: white;"><b>Create one</b></router-link></p>
          </div>
        </div>
      </div>
    </div>

    <!-- <Button @click="logout" label="Logout" class="p-button-lg p-button-secondary logout-button" /> -->
    <Footer />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

export default {
  components: {
    Navbar,
    Footer,
    InputText,
    Button
  },
  data() {
    return {
      form: {
        username: '',
        password: ''
      }
    };
  },
methods: {
    async submitForm() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.form)
        });

        const data = await response.json();

        if (response.ok) {
          console.log('Login successful', data);
          localStorage.setItem('auth_token', data.access_token);
          this.$router.push({ path: '/' });
      
        } else {
          console.error('Login failed', data);
          
          if (data.errors) {
            for (const key in data.errors) {
              console.error(`${key}: ${data.errors[key].join(', ')}`);
            }
          }
        }
      } catch (error) {
        console.error('Error during login', error);
       
      }
    },
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
      this.$router.push({ path: '/login' });
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
.login-page {
  height: 100vh;
}

.login-form-content {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.content {
  text-align: center;
  color: white;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
}

.form-container {
  padding: 20px;
  border-radius: 8px;
}

.input-field {
  width: 350px;
}

.p-button-lg {
  padding: 10px 20px;
  font-size: 1.2rem;
}



.logout-button {
  position: absolute;
  top: 10px;
  right: 10px;
  margin-top: 200px;
}



</style>

