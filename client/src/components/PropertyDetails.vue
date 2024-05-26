<template>
  <div class="property-details">
    <!-- Navbar -->
    <Navbar />

    <h1>Property Details</h1>

    <div class="content-wrapper">
      <!-- Property Information Table -->
      <div class="property-info">
        <div class="property-images">
          <h2>Property Images</h2>
          <div class="image-gallery">
            <div v-for="(image, index) in property.images" :key="index" class="image-container">
              <img :src="image.image_url" alt="Property Image" />
            </div>
          </div>
        </div>
        <table>
          <tr>
            <th>ID</th>
            <td>{{ property.id }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>{{ property.status }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ property.description }}</td>
          </tr>
          <tr>
            <th>Address</th>
            <td>{{ property.address_line }}</td>
          </tr>
          <tr>
            <th>Municipality</th>
            <td>{{ property.municipality }}</td>
          </tr>
          <tr>
            <th>Square Meters</th>
            <td>{{ property.square_meters }} sqm</td>
          </tr>
          <tr>
            <th>Price</th>
            <td>{{ property.price }} €</td>
          </tr>
          <tr>
            <th>Bedrooms</th>
            <td>{{ property.num_bedrooms }}</td>
          </tr>
          <tr>
            <th>Bathrooms</th>
            <td>{{ property.num_bathrooms }}</td>
          </tr>
          <tr>
            <th>Floor Number</th>
            <td>{{ property.floor_number }}</td>
          </tr>
          <tr>
            <th>Balcony</th>
            <td>{{ property.has_balcony }}</td>
          </tr>
          <tr>
            <th>Garden</th>
            <td>{{ property.has_garden }}</td>
          </tr>
          <tr>
            <th>Parking</th>
            <td>{{ property.has_parking }}</td>
          </tr>
          <tr>
            <th>Elevator</th>
            <td>{{ property.has_elevator }}</td>
          </tr>
        </table>
      </div>

      <!-- Reviews Box -->
      <div class="reviews-box">
        <h2>Write a Review</h2>
        <textarea v-model="review.comment" placeholder="Write your review here..." rows="10" cols="30"></textarea>
        <input v-model="review.rating" type="number" min="1" max="5" placeholder="Rating (1-5)">
        <button @click="submitReview">Submit Review</button>
        <div v-if="errors.length > 0" class="error-messages">
          <div v-for="(error, index) in errors" :key="index">{{ error }}</div>
        </div>
        <div v-if="successMessage" class="success-message">{{ successMessage }}</div>

        <h2><br>Reviews</h2>
        
        <div v-if="property.reviews && property.reviews.length > 0">
          <div v-for="(review, index) in property.reviews" :key="index" class="review-item">
            <p><strong>Rating:</strong> {{ review.rating }} / 5</p>
            <p><strong>Comment:</strong> {{ review.comment }}</p>
            <hr>
          </div>
        </div>
        <div v-else>
          <p>No reviews yet.</p>
        </div>

       
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import axios from 'axios';

export default {
  components: {
    Navbar
  },
  data() {
    return {
      property: {},
      review: {
        user_id: '',
        property_id: '', // This will be set after fetching property details
        rating: '',
        comment: ''
      },
      user: {},
      errors: [],
      successMessage: ''
    };
  },
  created() {
    const propertyId = this.$route.params.id;
    this.fetchPropertyDetails(propertyId);
    this.fetchUser();
  },
  computed: {
    lastThreeReviews() {
      if (this.property.reviews && this.property.reviews.length > 0) {
        return this.property.reviews.slice().reverse().slice(0, 3);
      }
      return [];
    }
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
        this.review.user_id = this.user.id;
      })
      .catch(error => {
        console.error("There was an error fetching the user data:", error);
      });
    },
    fetchPropertyDetails(id) {
      axios.get(`http://127.0.0.1:8000/api/properties/${id}`)
        .then(response => {
          this.property = response.data;
          this.review.property_id = this.property.id;
        })
        .catch(error => {
          console.error("There was an error fetching the property details:", error);
        });
    },
    submitReview() {
      if (this.user) {        
        axios.post('http://127.0.0.1:8000/api/reviews', this.review)
        .then(response => {
          this.successMessage = 'Review submitted successfully!';
          this.errors = [];
          // Reset the review form
          this.review.rating = '';
          this.review.comment = '';
          // Fetch property details again to update reviews
          this.fetchPropertyDetails(this.property.id);
        })
        .catch(error => {
          if (error.response && error.response.data.errors) {
            this.errors = Object.values(error.response.data.errors).flat();
          } else {
            this.errors = ['An error occurred while submitting the review.'];
          }
        });
      } else {
        this.errors.push('User must be logged in to submit a review.');
      }
    }
  }
};
</script>

<style scoped>
.property-details {
  display: flex;
  flex-direction: column;
  align-items: center;
  max-width: 1200px;
  margin: 100px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}
.property-details h1 {
  text-align: center;
  color: #010633;
  margin-bottom: 20px;
}
.content-wrapper {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-left: 50px;
}
.property-info {
  width: 60%;
  margin-top: 20px;
}
.property-info table {
  width: 100%;
  border-collapse: collapse;
}
.property-info th,
.property-info td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}
.property-info th {
  background-color: #f2f2f2;
}

.property-images {
  width: 100%;
  margin-top: 20px;
}
.property-images h2 {
  color: #010633;
  margin-bottom: 10px;
}
.image-gallery {
  display: flex;
}
.image-container {
  flex: 1 1 calc(33.333% - 10px);
  max-width: calc(33.333% - 10px);
  height: 150px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}
.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.reviews-box {
  width: 300px;
  margin-top: 75px;
  margin-right: 50px;
  margin-left: 0px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #010633;
}
.reviews-box h2 {
  margin-bottom: 10px;
}
.reviews-box .review-item {
  width: 100%;
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
}
.reviews-box textarea {
  width: 100%;
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: none;
}
.review-item {
  width: 100%;
  margin-bottom: 10px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.reviews-box input {
  width: 100%;
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
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
  background-color:darkmagenta;
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
