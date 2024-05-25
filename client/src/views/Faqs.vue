<template>
    <div class="reviews-box">
    <Navbar />
      

      <h2>Ask a Question</h2>
      <textarea v-model="question.question" placeholder="Write your question here..." rows="10" cols="30"></textarea>
      <button @click="submitQuestion">Submit Question</button>
      <div v-if="errors.length > 0" class="error-messages">
        <div v-for="(error, index) in errors" :key="index">{{ error }}</div>
      </div>
      <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
    </div>

  <Footer />

  </template>
  
  <script>
  import axios from 'axios';
  
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

  
  export default {
    components: {
    Navbar,
    Footer,
  },



    data() {
      return {
        question: {
          user_id: '',
          question: ''
        },
        user: {},
        errors: [],
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
          this.question.user_id = this.user.id;
        })
        .catch(error => {
          console.error("There was an error fetching the user data:", error);
        });
      },
      submitQuestion() {
        if (this.user) {        
          axios.post('http://127.0.0.1:8000/api/faqs', this.question)
          .then(response => {
            this.successMessage = 'Question submitted successfully!';
            this.errors = [];
            // Reset the question form
            this.question.question = '';
          })
          .catch(error => {
            if (error.response && error.response.data.errors) {
              this.errors = Object.values(error.response.data.errors).flat();
            } else {
              this.errors = ['An error occurred while submitting the question.'];
            }
          });
        } else {
          this.errors.push('User must be logged in to submit a question.');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .reviews-box {
    width: 300px;
    margin-top: 150px;
    margin-right: 50px;
    margin-left: 40%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .reviews-box h2 {
    margin-bottom: 10px;
  }
  .reviews-box textarea {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
  }
  .reviews-box button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: darkslateblue;
    color: white;
    cursor: pointer;
  }
  .reviews-box button:hover {
    background-color: darkmagenta;
  }
  .error-messages {
    color: red;
    font-size: 0.9rem;
    margin-top: 10px;
  }
  .success-message {
    color: green;
    font-size: 1rem;
    margin-top: 10px;
  }
  </style>