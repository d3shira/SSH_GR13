<template>
  <div class="register-page">
    <!-- Navbar -->
    <Navbar />

    <!-- Register Form Content -->
    <div class="register-form-content">
      <!-- Background Image -->
      <!-- <div class="background-image"> -->
        <!-- Form Content -->
        <div class="content">
          <!-- Register Form -->
          <div class="form-container">
            <h2>Register Form</h2>
            <form @submit.prevent="submitForm">
              <div class="p-field p-grid">
                <label for="first_name" class="p-col-12 p-md-2">First Name</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="first_name" v-model="form.first_name" class="input-field" />
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="last_name" class="p-col-12 p-md-2">Last Name</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="last_name" v-model="form.last_name" class="input-field" />
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="username" class="p-col-12 p-md-2">Username</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="username" v-model="form.username" class="input-field" />
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="email" class="p-col-12 p-md-2">Email</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="email" v-model="form.email" class="input-field" />
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="password" class="p-col-12 p-md-2">Password</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="password" v-model="form.password" type="password" class="input-field" />
                </div>
              </div>
              
              <div class="p-field p-grid">
                <div class="p-col-12">
                  <br>
                  <Button type="submit" label="Register" class="p-button-lg p-button-primary" />
                </div>
              </div>
            </form>
          </div>
        </div>
      <!-- </div> -->
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
      form:{
      first_name: '',
      last_name: '',
      username: '',
      email: '',
      password: '',
     
      }
    };
  },
  methods: {
    async submitForm() {
  
      try {
        const response = await fetch('http://127.0.0.1:8000/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.form)
        });
        
        if (!response.ok) {
          throw new Error('Failed to register');
        }

        // Reset the form after successful registration
        this.form = {
          first_name: '',
          last_name: '',
          username: '',
          email: '',
          password: '',
          confirmPassword: ''
        };

        console.log('Registration successful');
        this.$router.push('/login');
      } catch (error) {
        console.error('Error registering user:', error);
        
      }
    }
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

/* .background-image {
  background-image: url('@/assets/images/photo.png');
  background-size: cover;
  background-position: center;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
} */

.content {
  text-align: center;
  color: white;
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
