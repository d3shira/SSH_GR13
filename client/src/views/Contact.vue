<template>
  <div class="home">
    <Navbar />
    <br><br><br>
    <div class="job-application-content">
      <div class="background-image">
        <div class="content">
          <h1 style="color:white"><b>Contact Us</b></h1>
          <p style="color: white;">You can also contact to sell your property</p>
        
          <div class="form-container">
            <form @submit.prevent="submitForm">
              <div class="p-field p-grid">
                <label for="name" class="p-col-12 p-md-2">Name</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="name" v-model="form.name" class="input-field" required />
                  <div v-if="errors.name" class="error">{{ errors.name }}</div>
                </div>
              </div>
            
              <div class="p-field p-grid">
                <label for="contact" class="p-col-12 p-md-2">Phone Number</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="contact" v-model="form.contact" class="input-field" required />
                  <div v-if="errors.contact" class="error">{{ errors.contact }}</div>
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="email" class="p-col-12 p-md-2">Email</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="email" v-model="form.email" class="input-field" required type="email" />
                  <div v-if="errors.email" class="error">{{ errors.email }}</div>
                </div>
              </div>
              <div class="p-field p-grid">
                <label for="address" class="p-col-12 p-md-2">Address</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="address" v-model="form.address" class="input-field" />
                  <div v-if="errors.address" class="error">{{ errors.address }}</div>
                </div>
              </div>
              
              <div class="p-field p-grid">
                <label for="message" class="p-col-12 p-md-2">Message</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="message" v-model="form.message" class="input-field" />
                  <div v-if="errors.message" class="error">{{ errors.message }}</div>
                </div>
              </div>


              <div class="p-field p-grid">
                <div class="p-col-12 p-md-10 p-md-offset-2">
                  <br>
                  <Button type="submit" label="Submit" class="p-button-lg p-button-primary" />
                </div>
              </div>
            </form>
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
        name: '',
        email: '',
        address: '',
        contact: '',
        message: '',
      },
      errors: {}
    };
  },

 
  methods: {
    async submitForm() {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/contact', {
      method: 'POST',
      headers: {
       
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(this.form) 
    });

    if (!response.ok) {
      throw new Error('Failed to submit form');
    }

    const data = await response.json();
    console.log('Form submitted successfully:', data);
    // Reset form after successful submission
    this.form = {
      name: '',
      
      address: '',
      nationality: '',
      contact: '',
      email: '',
      message: ''
    };
    this.errors = {};
  } catch (error) {
    console.error('Error submitting form:', error);
  }
}

  }
};
</script>

<style scoped>
.home {
  height: 100vh;
}

.job-application-content {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.background-image {
  
  background-size: cover;
  background-position: center;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
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
  /* background: rgba(255, 255, 255, 0.9); */
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.input-field {
  width: 250px;
}

.p-button-lg {
  padding: 10px 20px;
  margin: 0 10px;
  font-size: 1.2rem;
  background-color: #055190;
  border: #303B98;
}


label {
  color: white;
  font-weight: bolder;
}
</style>

