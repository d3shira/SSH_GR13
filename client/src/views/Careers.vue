<template>
  <div class="center-container">
    <div class="careers-form">
      <h1 class="form-title">Careers Form</h1>
      <div class="p-grid">
        <div class="p-col-12 p-md-6">
          <img src="@/assets/images/careers.jpg" alt="Company Logo" class="responsive-image" />
        </div>
        <div class="p-col-12 p-md-6">
          <p class="content-paragraph">
            We're excited that you're interested in joining our team! At our company, we value innovation, collaboration,
            and creativity. If you're passionate about making a difference and eager to contribute your skills and ideas,
            we encourage you to apply.
          </p>
          <p class="content-paragraph">
            Please fill out the form below to apply for a position with us. We look forward to reviewing your application.
          </p>
        </div>
      </div>
      <form class="p-grid p-fluid">
        <div class="p-col-12 p-md-6">
          <label for="name">Name</label>
          <input id="name" type="text" v-model="name" class="p-inputtext" placeholder="Enter your name" required />
        </div>
        <div class="p-col-12 p-md-6">
          <label for="email">Email</label>
          <input id="email" type="email" v-model="email" class="p-inputtext" placeholder="Enter your email" required />
        </div>
        <div class="p-col-12">
          <label for="resume">Upload Resume</label>
          <input id="resume" type="file" @change="onFileChange" class="p-inputtext" accept=".pdf,.doc,.docx" required />
          <small class="p-invalid" v-if="!resume">Please upload your resume.</small>
        </div>
        <div class="p-col-12">
          <label for="message">Message (optional)</label>
          <textarea id="message" v-model="message" rows="4" class="p-inputtext" placeholder="Enter your message"></textarea>
        </div>
        <div class="p-col-12 button-container">
          <button @click.prevent="submitForm" class="p-button p-button-primary small-button"><b>SUBMIT</b></button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      resume: null,
      message: ''
    };
  },
  methods: {
    onFileChange(event) {
      this.resume = event.target.files[0];
    },
    submitForm() {
      if (!this.resume) {
        // Handle file not uploaded scenario
        console.error('Resume not uploaded');
        return;
      }
      // Handle form submission here
      console.log('Form submitted');
    }
  }
}
</script>

<style scoped>
.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.careers-form {
  max-width: 600px;
  width: 100%;
  padding: 20px;
  background: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

.form-title {
  text-align: center;
  margin-bottom: 20px;
}

.content-paragraph {
  font-size: 14px;
  line-height: 1.5;
}

.responsive-image {
  max-width: 100%;
}

.button-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.small-button {
  padding: 15px 20px;
  font-size: 12px;
  width: auto;

}

@media (max-width: 500px) {
  .content-paragraph {
    font-size: 12px;
  }
  .p-col-12 {
    width: 100% !important;
  }
}
</style>
