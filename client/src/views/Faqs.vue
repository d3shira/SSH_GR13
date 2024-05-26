<template>
  <div>
    <Navbar />
    <div class="container1">
      <div class="txt">
        <h1 style="color:#010633; font-size:65px">How can we help?</h1>
        <p style="color:#010633">Explore our detailed FAQ guide, packed with answers and helpful tips to
          address all your questions and concerns. We're here to help you every step of the way.
        </p>
      </div>
      <div> <img src="../assets/images/questioning.png" width="700px" height="500px"></div>
    </div>

    <h1 style="color:#010633; font-size:50px; text-align: center;">Frequent asked questions</h1>

    <div class="faqs-container">
      <div class="faqs-list">
        <div v-for="(faq, index) in faqs" :key="index" class="faq-item" @click="toggleAnswer(index)">
          <strong>{{ faq.question }}</strong> 
          <div style="color:grey;" v-if="faq.showAnswer" class="faq-answer">
            <strong></strong> {{ faq.answer || 'null' }}
          </div>
        </div>
      </div>
    </div>

    <div class="reviews-box">
      <h2 style="color:white; font-size: 30px;">Didn't find your answer?</h2>
      <p style="color:white; text-align: center; font-weight: 100;">If you have any other question you can write them here</p>
      <div class="inputtext">
      <textarea v-model="question.question" placeholder="Write your question here..." rows="10" cols="30"></textarea></div>
      <div class="butoni"> <button @click="submitQuestion">Submit Question</button></div>
      <div v-if="errors.length > 0" class="error-messages">
        <div v-for="(error, index) in errors" :key="index">{{ error }}</div>
      </div>
      <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
    </div>
    <Footer />
  </div>
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
      successMessage: '',
      faqs: []
    };
  },
  created() {
    this.fetchUser();
    this.fetchFaqs();
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
    fetchFaqs() {
      axios.get('http://127.0.0.1:8000/api/faqs')
      .then(response => {
        this.faqs = response.data.map(faq => ({ ...faq, showAnswer: false }));
      })
      .catch(error => {
        console.error("There was an error fetching the FAQs:", error);
      });
    },
    submitQuestion() {
      if (this.user) {        
        axios.post('http://127.0.0.1:8000/api/faqs', this.question)
        .then(response => {
          this.successMessage = 'Question submitted successfully!';
          this.errors = [];
          this.question.question = '';
          this.fetchFaqs();
        })
        .catch(error => {
          if (error.response && error.response.data.errors) {
            this.errors = Object.values(error.response.data.errors).flat();
          } else {
            this.errors = ['You should be logged in to submit a question!'];
          }
        });
      } else {
        this.errors.push('User must be logged in to submit a question.');
      }
    },
    toggleAnswer(index) {
      this.faqs[index].showAnswer = !this.faqs[index].showAnswer;
    }
  }
};
</script>

<style scoped>
.reviews-box {
  width: 100%;
  margin-top: 120px;
  padding: 20px;
  border: 1px solid #ccc;
  /* border-radius: 10px; */
  /* background-color: #f9f9f9; */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #010633;

}
.reviews-box h2 {
  margin-bottom: 10px;
}
.reviews-box textarea {
  /* width: 100%; */
  margin-bottom: 10px;
  padding: 10px;
  border: 1px initial #ffffff;
  border-radius: 5px;
  resize: none;
  background-color: #010633;
  height: 50px;
  color:white;

}
.reviews-box button {
  padding: 10px 20px;
  border: none;
  border-radius: 30px;
  background-color: #F26419;
  color: white;
  cursor: pointer;
  font-weight: bold;
}
.reviews-box button:hover {
  background-color: #b8531d;
}
.error-messages {
  color: white;
  font-size: 0.9rem;
  margin-top: 10px;
}
.success-message {
  color: white;
  font-size: 1rem;
  margin-top: 10px;
}

.faqs-container {
  max-width: 800px;
  padding: 0 20px;
  margin-top: 120px;
  color: rgb(0, 0, 0);
  background-color: white;
  border-radius: 10px;
  margin-left: 25%;
}

.faqs-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.faq-item {
  width: calc(50% - 10px);
  border: 1px solid #959494;
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.3s;
  box-shadow: 0 1px ;
}

.faq-item:hover {
  background-color: #f9f9f9;
}

.faq-answer {
  margin-top: 10px;
}

.container {
  column-gap: 30px;
  margin-left: 30%;
}

::v-deep .background-image {
  display: none;
}

.container1 {
  margin-top: 150px;
  margin-left: 120px;
  margin-bottom: 100px;
  display: flex;
  column-gap: 200px;
}

.txt {
  width: 300px;
  margin-top: 90px;
  margin-left: 50px;
}


.inputtext{
  color:white;

}

.butoni{
  background-color: #F26419;
  border-radius: 13px;
}



::v-deep .footer {
 background-color: white;
 color:#010633;
}

</style>
