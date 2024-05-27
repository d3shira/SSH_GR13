<template>
  <div class="home">
    <Navbar />
    <br><br><br>
    <div class="job-application-content">
      <div class="background-image">
        <div class="content">
          <h1 style="color: #010633"><b>Contact Us</b></h1>
          <p style="color: #010633;">You can also contact us to sell your property</p>
        
          <div class="form-container">
            <form @submit.prevent="submitForm">
              <div class="container">
              <div class="p-field p-grid">
                <label for="name" class="p-col-12 p-md-2 ">Name</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="name" v-model="form.name" class="input-field"  required />
                  <div v-if="errors.name" class="error">{{ errors.name }}</div>
                </div>
              </div>
           
              <div class="p-field p-grid">
                <label for="contact" class="p-col-12 p-md-2 ">Phone Number</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="contact" v-model="form.contact" class="input-field" required />
                  <div v-if="errors.contact" class="error">{{ errors.contact }}</div>
                </div>
              </div>
            </div> 
            <div class="container">
              <div class="p-field p-grid">
                <label for="email" class="p-col-12 p-md-2 ">Email</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="email" v-model="form.email" class="input-field" required type="email" />
                  <div v-if="errors.email" class="error">{{ errors.email }}</div>
                </div>
              </div>
            
              <div class="p-field p-grid">
                <label for="address" class="p-col-12 p-md-2 ">Address</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="address" v-model="form.address" class="input-field" />
                  <div v-if="errors.address" class="error">{{ errors.address }}</div>
                </div>
              </div>
              </div>
              <div class="message">
              <div class="p-field p-grid">
                <label for="message" class="p-col-12 p-md-2 ">Message</label>
                <div class="p-col-12 p-md-10">
                  <InputText id="message" v-model="form.message" class="input-field" />
                  <div v-if="errors.message" class="error">{{ errors.message }}</div>
                </div>
              </div>
            </div>

              <div class="p-field p-grid">
                <div class="p-col-12 p-md-10 p-md-offset-2">
                  <br>
                  <Button type="submit" label="Submit" class="p-button-lg p-button-primary" />
                </div>
              </div>
              <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
              <div v-if="errors.general" class="error-message">{{ errors.general }}</div>
            </form>
          
        
                    
              <div class="contact-info">
                <div class="container">
                <div class="contact-item">
                  <i class="pi pi-map-marker"></i>
                  <span>Pristina, Kosovo</span>
              </div>
               <div class="contact-item">
                  <i class="pi pi-phone"></i>
                  <span>+38345111111</span>
                </div>
                <div class="contact-item">
                  <i class="pi pi-envelope"></i>
                  <span>kosova_estate@gmail.com</span>
                </div>
                </div>
  </div>
</div>
      </div>
    </div></div>
    <Footer />
  </div>
</template>


<script>

import axios from 'axios';
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
        user_id: ''
      },
      user: {},
      errors: {},
      successMessage: ''

    };
  },

 
  created() {
    this.fetchUser();
  },

    methods: {
    fetchUser() {
      axios.get('http://127.0.0.1:8000/api/user', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      .then(response => {
        this.user = response.data;
        this.form.user_id = this.user.id;
      })
      .catch(error => {
        console.error("There was an error fetching the user data:", error);
      });
    },

    async submitForm() {
      if (!this.user.id) {
         this.errors.general = 'You must be logged in to submit the form.';
    
       setTimeout(() => {
        this.errors.general = '';
      }, 5000);
    
     return;
     }
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

        this.successMessage = 'Form submitted successfully!';
        setTimeout(() => {
        this.errors.general = '';
      }, 5000);

        this.form = {
          name: '',
          address: '',
          contact: '',
          email: '',
          message: '',
          user_id: this.user.id
        };
        this.errors = {};
        setTimeout(() => {
          this.successMessage = '';
        }, 5000);


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
  background-color: white;
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
  color: #010633;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
}

.form-container {
  padding-top: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.input-field {
  width: 250px;
  margin: 10px 0px;
}

.p-button-lg {
  padding: 10px 20px;
  margin: 0 10px;
  font-size: 1.2rem;
  background-color: #F26419;
  border: #F26419;
}

label {
  color: #010633;
  font-weight: bolder;
  /* margin-right: 200px; */
}

h1 {
  color: #010633;
}

p {
  color: #010633;
}

.container{
  display: flex;
  margin-left: 32%;
  column-gap: 50px;
}

#message{
  width:550px;
  margin-right: 1%;
}




.contact-info {
  text-align: center;
  margin-top: 40px;
  font-size: 18px;
  margin-right: 230px;
  /* margin-left: 20px; */

}

.contact-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  /* margin-bottom: 10px; */
  transition: transform 0.2s;
  margin-right: 130px;
}

.contact-item i {
  margin-bottom: 5px; 
  font-size: 36px; 
  color: #022953; 
}

.contact-item span {
  font-size: 16px;
  font-weight: bold;
}

/* .contact-item:hover {
  transform: translateY(-3px);
} */

/* .contact-item i:hover {

    color: #000307; 
  cursor: pointer;
} */


.success-message {
  margin-top: 10px;
  /* padding: 10px; */
  background-color: #dff0d8;
  color: #3c763d;
  border: 1px solid #d6e9c6;
  border-radius: 4px;
  text-align: center;
  width:300px;
  margin-left: 40%;;
}

.error-message {
  margin-top: 10px;
  /* padding: 10px; */
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
  border-radius: 4px;
  text-align: center;
  width:300px;
  margin-left: 40%;;
}

</style>