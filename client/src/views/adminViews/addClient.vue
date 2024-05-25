<template>
  <div class="register-page">
    <!-- Navbar -->
    <AdminNavbar />
    <br><br><br><br><br><br>
    <!-- Register Form Content -->
    <div class="register-form-content">
      <!-- Form Content -->
      <div class="content">
        <!-- Register Form -->
        <div class="form-container">
          <br>
          <h2>Create Client</h2>
          <form @submit.prevent="submitForm">
            <div class="p-field p-grid">
              <label for="first_name" class="p-col-12 p-md-2">First Name</label>
              <div class="p-col-12 p-md-10">
                <InputText id="first_name" v-model="user.first_name" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <label for="last_name" class="p-col-12 p-md-2">Last Name</label>
              <div class="p-col-12 p-md-10">
                <InputText id="last_name" v-model="user.last_name" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <label for="username" class="p-col-12 p-md-2">Username</label>
              <div class="p-col-12 p-md-10">
                <InputText id="username" v-model="user.username" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <label for="email" class="p-col-12 p-md-2">Email</label>
              <div class="p-col-12 p-md-10">
                <InputText id="email" v-model="user.email" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <label for="password" class="p-col-12 p-md-2">Password</label>
              <div class="p-col-12 p-md-10">
                <InputText id="password" v-model="user.password" type="password" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <label for="phone" class="p-col-12 p-md-2">Phone</label>
              <div class="p-col-12 p-md-10">
                <InputText id="phone" v-model="user.phone" class="input-field" />
              </div>
            </div>
            <div class="p-field p-grid">
              <div class="p-col-12">
                <br />
                <Button type="submit" label="Register" class="p-button-lg p-button-primary" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <AdminFooter />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

// Import components
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

// Create a ref for user data
const user = ref({
  first_name: '',
  last_name: '',
  username: '',
  email: '',
  password: '',
  phone: '' // Add phone field to the user object
});

// Function to handle form submission
// Function to handle form submission
const submitForm = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', user.value);
    console.log('User created:', response.data);

    // Clear the form fields
    user.value = {
      first_name: '',
      last_name: '',
      username: '',
      email: '',
      password: '',
      phone: '',
    };
  } catch (error) {
    console.error('Error creating user:', error);
  }
};
</script>

<style scoped>
.register-page {
  height: 100vh;
}

.register-form-content {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.content {
  text-align: center;
  color: black;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
}

.form-container {
  padding: 40px;
  border-radius: 10px;
}

.input-field {
  width: 350px; /* Adjust this value for smaller or larger fields */
}

.p-button-lg {
  padding: 10px 20px;
  font-size: 1.2rem;
}
</style>
