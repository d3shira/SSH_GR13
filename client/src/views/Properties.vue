
<template>
    <div class="page-container">
      <div class="properties">
        <h2>Properties</h2>
        <div class="property-container">
          <div class="property" v-for="(property, index) in properties" :key="property.id" :style="{ 'margin-right': getMargin(index) }">
            <img :src="property.image" alt="Property Image" style="max-width: 100%; max-height:180px;">
            <h3>{{ property.title }}</h3>
            <p>{{ property.description }}</p>
            <p><strong>Location:</strong> {{ property.id }}</p>
            <p><strong>Area:</strong> {{ property.area }}, <strong>ID:</strong> {{ property.id }}, <strong>Price:</strong> ${{ property.price }}</p>
            <p><strong>ID:</strong> {{ property.id }}</p>
              <p><strong>Area:</strong> {{ property.area }}</p>
            <p><strong>Price:</strong> ${{ property.price }}</p>
            <!-- Additional property details can be displayed here -->
          </div>
        </div>
      </div>
      
      
      

      <!-- Extended search form -->
      <form class="extended-search" @submit.prevent="handleSearchSubmit">
        <h2>Kërkimi i zgjeruar</h2>
        
        <div class="form-group">
          <label for="category">Kategoria</label>
          <select id="category" v-model="category">
            <option value=""></option>
            <option value="Residenciale">Residenciale</option>
            <option value="Biznes">Biznes</option>
            <option value="Tokë">Tokë</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Statuset</label>
          <select id="status" v-model="status">
            <option value=""></option>
            <option value="Për Qira">Për Qira</option>
            <option value="Për shitje">Për Shitje</option>
          </select>
        </div>
        <div class="form-group">
          <label for="type">Tipet</label>
          <select id="status" v-model="status">
            <option value=""></option>
            <option value="Shtëpi">Shtëpi</option>
            <option value="Zyre">Zyre</option>
            <option value="Ndërtim i vjetër">Ndërtim i vjetër</option>
            <option value="Banese">Banese</option>
            <option value="Ndërtese">Ndërtese</option>
            <option value="Hotel">Hotel</option>
            <option value="Tokë">Tokë</option>
            <option value="Depo">Depo</option>
            <option value="Studio">Studio</option>
            <option value="Vila">Vila</option>
            <option value="Bar restorant">Bar restorant</option>

          </select>
        </div>
        <div class="form-group">
          <label for="city">Qytet</label>
          <select id="status" v-model="status">
            <option value=""></option>
            <option value="Gjilan">Gjilan</option>
            <option value="Gjakovë">Gjakovë</option>
            <option value="Drenas">Drenas</option>
            <option value="Klinë">Klinë</option>
            <option value="Fushë Kosovë">Fushë Kosovë</option>
            <option value="Lipjan">Lipjan</option>
            <option value="Mitrovicë">Mitrovicë</option>
            <option value="Kastriot">Kastriot</option>
            <option value="Podujevë">Podujevë</option>
            <option value="Prishtinë">Prishtinë</option>
            <option value="Prizren">Prizren</option>
            <option value="Ferizaj">Ferizaj</option>
            <option value="Vushtrri">Vushtrri</option>
          </select>
        </div>
        <!-- Additional labels for surface -->
   
        <div class="form-group surface-group">
  <label for="surface">Siperfaqe</label>
  <div class="surface-inputs">
    <div class="half-input">
      <label for="minSurface" class="hidden">Min</label>
      <input type="number" id="minSurface" v-model="minSurface" placeholder="Min">
    </div>
    <div class="half-input">
      <label for="maxSurface" class="hidden">Max</label>
      <input type="number" id="maxSurface" v-model="maxSurface" placeholder="Max">
    </div>
  </div>
</div>

<div class="form-group price-group">
  <label for="price">Price</label>
  <div class="price-inputs">
    <div class="half-input">
      <label for="minPrice" class="hidden">Min</label>
      <input type="number" id="minPrice" v-model="minPrice" placeholder="Min">
    </div>
    <div class="half-input">
      <label for="maxPrice" class="hidden">Max</label>
      <input type="number" id="maxPrice" v-model="maxPrice" placeholder="Max">
    </div>
  </div>
</div>

<div class="form-group room-group">
  <div class="room-inputs">
    <div class="half-input">
      <label for="bedroom" class="hidden">Bedroom</label>
      <input type="number" id="bedroom" v-model="bedroom" placeholder="Bedroom">
    </div>
    <div class="half-input">
      <label for="workroom" class="hidden">WorkRoom</label>
      <input type="number" id="workroom" v-model="workroom" placeholder="Workroom">
    </div>
  </div>
</div>


        <!-- Add more form fields for extended search as needed -->
        <button type="submit">Search</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        properties: [
          { id: '', title: 'Modern Apartment in City Center', image: 'https://www.livehome3d.com/assets/img/articles/design-house/how-to-design-a-house.jpg',price:''},
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },
          { id: '', title: 'Cozy Family House in Suburbs',image:"https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/wp-content/uploads/2021/08/download-7.jpg",price:'' },

          // Add more properties as needed
        ],

        
        minPrice: '',
        maxPrice: '',
        category: '',
        status: '',
        type: '',
        city: '',
        minSurface: '',
        maxSurface: '',
        bedroom:'',
        workroom:''
      };
    },
    methods: {
      handleSearchSubmit() {
        // Handle extended search form submission logic here
        console.log('Extended search form submitted');
        console.log('Category:', this.category);
        console.log('Status:', this.status);
        console.log('Type:', this.type);
        console.log('City:', this.city);
        console.log('Minimum Surface:', this.minSurface);
        console.log('Maximum Surface:', this.maxSurface);
        // You can perform the search based on the entered values
      },
      getMargin(index) {
        if (index === 0) {
          return '30px';
        } else if (this.properties[index].id === 2) {
          return '30px'; // Adjust this value as needed
        } else {
          return '10px';
        }
      },
      focusInput(inputId) {
        document.getElementById(inputId).focus();
      }
    }
  };
  </script>
  
  <style scoped>
  .page-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top:20px;
    margin-left: 150px;
    margin-right: 150px;
  }
  .hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}

  
  .properties {
    width: calc(66.66% - 20px);
  }
  
  .property-container {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
  }
  
  .property {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
  }
  
  .property h3 {
    margin-top: 0;
  }
  
  .property p {
    margin-bottom: 10px;
  }
  
  .extended-search {
    width: calc(33.33% - 20px);
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 69px;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .extended-search label {
    display: block;
    margin-bottom: 10px; /* Adjust spacing between labels */
    cursor: pointer;
  }
  
  .extended-search input[type="number"],
  .extended-search input[type="text"],
  .extended-search select {
    width: calc(100% - 40px); /* Adjust for padding */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px; /* Add margin for spacing */
  }
  
  .extended-search button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .extended-search button:hover {
    background-color: #0056b3;
  }
  .surface-group {
  display: flex;
  flex-direction: column;
}

.surface-label {
  margin-bottom: 5px;
}

.surface-inputs {
  display: flex;
}

.half-input {
  flex: 1; /* Each input takes half of the available space */
  margin-right: 10px; /* Add spacing between inputs */
}

.half-input:last-child {
  margin-right: 0; /* Remove margin from the last input */
}

.price-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.price-group label {
  margin-bottom: 5px;
}

.price-inputs {
  display: flex;
}

.price-inputs .half-input {
  flex: 1;
  margin-right: 10px;
}

.price-inputs .half-input:last-child {
  margin-right: 0;
}

.room-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.room-group label {
  margin-bottom: 5px;
}

.room-inputs {
  display: flex;
}

.room-inputs .half-input {
  flex: 1;
  margin-right: 10px;
}

.room-inputs .half-input:last-child {
  margin-right: 0;
}

.extended-search button {
    width: calc(100% - 40px); /* Make the button the same width as the input fields */
    margin-top: 20px; /* Add margin for spacing */
    padding: 10px 20px;
    background-color:#1434A4; /* Set the background color to red */
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  


  </style>
  