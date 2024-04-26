<template>
    <div class="login-form">
      <h2>Login Form</h2>
      <form @submit.prevent="handleSubmit">
        <div class="p-field p-grid">
          <label for="email" class="p-col-12 p-md-2">Email</label>
          <div class="p-col-12 p-md-10">
            <InputText id="email" v-model="email" type="email" required />
          </div>
        </div>
        <div class="p-field p-grid">
          <label for="password" class="p-col-12 p-md-2">Password</label>
          <div class="p-col-12 p-md-10">
            <InputText id="password" v-model="password" type="password" required />
          </div>
        </div>
        <div class="p-field p-grid">
          <div class="p-col-12">
            <Button type="submit" label="Login" icon="pi pi-check" />
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  
  export default {
    components:{
        InputText,
        Button},
    
    data() {
      return {
        email: '',
        password: ''
      }
    },
    methods: {
      handleSubmit() {
        // Handle form submission logic here
        console.log('Form submitted');
      }
    },
    components: {
      InputText,
      Button
    }
  }
  </script>
  
  <style scoped>
  .login-form {
    max-width: 400px;
    margin: 40px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .p-field {
    margin-bottom: 20px;
  }
  
  .p-grid {
    align-items: center;
  }
  
  .p-col-12 {
    padding: 10px;
  }
  
  .p-col-md-2 {
    padding: 10px;
  }
  
  .p-col-md-10 {
    padding: 10px;
  }
  </style>