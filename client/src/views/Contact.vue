<template>
    <div class="form-container">
      <div class="p-grid p-fluid">

        <div class="container">
        <div class="p-col-12 p-md-6">
          <div class="field-container">
            <label for="name">Name</label>
            <InputText id="name" v-model="form.name" placeholder="Enter your name" />
          </div>
        </div>
        <div class="p-col-12 p-md-6">
          <div class="field-container">
            <label for="email">Email</label>
            <InputText id="email" v-model="form.email" placeholder="Enter your email" />
          </div>
        </div>
        </div>
      </div>
  
      <div class="p-grid p-fluid">
        <div class="container">
        <div class="p-col-12 p-md-6">
          <div class="field-container">
            <label for="address">Address</label>
            <InputText id="address" v-model="form.address" placeholder="Enter your address" />
          </div>
        </div>
        <div class="p-col-12 p-md-6">
          <div class="field-container">
            <label for="phone">Phone Number</label>
            <InputText id="phone" v-model="form.phone" placeholder="Enter your phone number" />
          </div>
        </div>
        </div>
      </div>
  
      <div class="p-grid p-fluid">
        <div class="p-col-12">
          <div class="field-container">
            <label for="message">Message</label>
            <InputText id="message" v-model="form.message" rows="4" placeholder="Enter your message" class="message" />
          </div>
        </div>
      </div>
  
      <div class="p-grid p-fluid">
        <div class="p-col-12">
          <Button style="background-color: #022953;" label="Send Message" icon="pi pi-send" @click="submitForm" />
        </div>
      </div>
    </div>


    
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

  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          address: '',
          phone: '',
          message: '',
        },
      };
    },
    methods: {
      submitForm() {
        console.log('Form submitted:', this.form);
      },
    },
  };
  </script>
  
  <style scoped>
  .container{
    display: flex;
    column-gap: 100px;
  }
  .form-container {
    max-width: 850px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: #ffffff;
  }
  
  .field-container {
    margin-bottom: 20px;
  }
  
  label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
  }
  
  .p-inputtext,
  .p-inputtextarea {
    width: 350px;
 
  }

  
  .p-button {
    width: 25%;
    margin-top: 20px;
    margin-left: 37%;
    justify-content: center;
  }

  .message{
    width: 800px;
   
  }
  

  .contact-info {
  text-align: center;
  margin-top: 100px;
  font-size: 18px;
  margin-left: 300px;

}

.contact-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 10px;
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

.contact-item:hover {
  transform: translateY(-3px);
}

.contact-item i:hover {
  color: #000307; 
  cursor: pointer;
}
  </style>
  