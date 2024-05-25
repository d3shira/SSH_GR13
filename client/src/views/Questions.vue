<template>
    <div class="home">
      <Navbar />
      <br><br><br>
      <div class="job-application-content">
        <div class="background-image">
          <div class="content">
            <h1 style="color:white"><b>Ask any question</b></h1>
            <div class="form-container">
              <form @submit.prevent="submitForm">
                <div class="p-field p-grid">
                  <label for="question" class="p-col-12 p-md-2">Question</label>
                  <div class="p-col-12 p-md-10">
                    <InputText id="question" v-model="form.question" class="input-field" required />
                    <div v-if="errors.question" class="error">{{ errors.question }}</div>
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
          question: '',
        },
        errors: {},
      };
    },
    methods: {
      async submitForm() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/questions', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({
              question: this.form.question,
            })
          });
  
          if (!response.ok) {
            const errorData = await response.json();
            this.errors = errorData.errors || {};
            throw new Error('Failed to submit form');
          }
  
          const data = await response.json();
          console.log('Form submitted successfully:', data);
          this.form.question = '';
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
    background: rgba(255, 255, 255, 0.9);
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
  </style>
  