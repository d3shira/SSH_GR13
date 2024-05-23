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
                <label for="email" class="p-col-12 p-md-2">Email</label>
               
                <div class="p-col-12 p-md-10">
                  <br>
                  <InputText id="email" v-model="email" class="input-field" required />
                </div>
              </div>
              <div class="p-field p-grid">
                <br>
                <label for="password" class="p-col-12 p-md-2">Password</label>
                <div class="p-col-12 p-md-10">
                  <br>
                  <InputText id="password" v-model="password" type="password" class="input-field" required />
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
              <p>No Account? <router-link to="/register">Create one</router-link></p>
            </div>
          </div>
        </div>
      </div>
  

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
        email: '',
        password: ''
      }
    };
  },
  methods: {
    submitForm() {
      console.log(this.form);
      // Handle form submission logic here
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
  width: 350px; /* Adjust this value for smaller or larger fields */
}

.p-button-lg {
  padding: 10px 20px;
  font-size: 1.2rem;
}
</style>