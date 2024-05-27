<template>
    <AdminNavbar />
      <div class="add-property">
        <h1 class="center">Add New Property</h1>
        <form @submit.prevent="submitForm">
          <!-- Property Details -->
          <div class="p-field">
            <label for="title">Title:</label>
            <InputText id="title" v-model="form.title" required />
          </div>
          <div class="p-field">
            <label for="description">Description:</label>
            <Textarea id="description" v-model="form.description" />
          </div>
          <div class="p-field">
            <label for="date_listed">Date Listed:</label>
            <Calendar id="date_listed" v-model="form.date_listed" style="width: calc(50%);"/>
          </div>
          <div class="p-field">
            <div class="checkboxes">
              <RadioButton v-model="form.selection" inputId="for_rent" name="type" value="for_rent"/>
              <label for="for_rent" class="ml-2">For Rent</label>
            </div>
            <div class="checkboxes">
              <RadioButton v-model="form.selection" inputId="for_sale" name="type" value="for_sale"/>
              <label for="for_sale" class="ml-2">For Sale</label>
            </div>
          </div>
          <div class="p-field">
            <label for="status">Status:</label>
            <InputText id="status" v-model="form.status" />
          </div>
          <div class="p-field">
          <label for="seller_id">Seller:</label>
          <Dropdown
            id="seller_id"
            v-model="form.seller_id"
            :options="salesAgents"
            optionLabel="fullName"
            optionValue="id"
            placeholder="Select Sales Agent"
            style="width: calc(100%); margin-bottom: 20px;"
          />
        </div>
    
          <!-- Property Type -->
          <div class="p-field">
            <label for="property_type_id">Property Type:</label>
            <Dropdown id="property_type_id" v-model="form.property_type_id" :options="propertyTypes" optionLabel="property_type_name" optionValue="id" placeholder="Select Property Type" 
            style="width: calc(100%); margin-bottom: 20px;" />
          </div>
    
          <!-- Address -->
          <div class="p-field">
            <h3>Address</h3>
            <label for="country">Country:</label>
            <InputText id="country" v-model="form.address.country" required />
            <label for="municipality">Municipality:</label>
            <InputText id="municipality" v-model="form.address.municipality" required />
            <label for="city_village">City/Village:</label>
            <InputText id="city_village" v-model="form.address.city_village" required />
            <label for="address_line">Address Line:</label>
            <InputText id="address_line" v-model="form.address.address_line" required />
            <label for="postal_code">Postal Code:</label>
            <InputText id="postal_code" v-model="form.address.postal_code" required />
          </div>
    
          <!-- Features -->
          <div class="p-field">
            <h3>Features</h3>
            <label for="num_bedrooms">Number of Bedrooms:</label>
            <InputNumber id="num_bedrooms" v-model="form.features.num_bedrooms" />
            <label for="num_bathrooms">Number of Bathrooms:</label>
            <InputNumber id="num_bathrooms" v-model="form.features.num_bathrooms" />
            <label for="square_meters">Square Meters:</label>
            <InputNumber id="square_meters" v-model="form.features.square_meters" />
            <label for="floor_number">Floor Number:</label>
            <InputNumber id="floor_number" v-model="form.features.floor_number" />
            <div class="checkboxes">
              <Checkbox v-model="form.features.has_balcony" :binary="true"/>
              <label for="has_balcony" style="margin-left: 15px;">Has Balcony</label>
            </div>
            <div class="checkboxes">
              <Checkbox v-model="form.features.has_garden" :binary="true"/>
              <label for="has_garden" style="margin-left: 15px;">Has Garden</label>
            </div>
            <div class="checkboxes">
              <Checkbox v-model="form.features.has_garage" :binary="true"/>
              <label for="has_garage" style="margin-left: 15px;">Has Garage</label>
            </div>
            <div class="checkboxes">
              <Checkbox v-model="form.features.has_parking" :binary="true"/>
              <label for="has_parking" style="margin-left: 15px;">Has Parking</label>
            </div>
            <div class="checkboxes">
              <Checkbox v-model="form.features.has_elevator" :binary="true"/>
              <label for="has_elevator" style="margin-left: 15px;">Has Elevator</label>
            </div>
  
            <label for="price" style="margin-top: 20px;">Price:</label>
            <InputNumber id="price" v-model="form.features.price" />
          </div>
  
          <!-- Upload Contract -->
          <div class="p-field">
            <h3>Upload Contract</h3>
            <div class="checkboxes">
              <RadioButton v-model="form.contract_type" inputId="contract_for_rent" name="contract_type" :value="1"/>
              <label for="contract_for_rent" class="ml-2">Contract For Rent</label>
            </div>
            <div class="checkboxes">
              <RadioButton v-model="form.contract_type" inputId="contract_for_sale" name="contract_type" :value="2"/>
              <label for="contract_for_sale" class="ml-2">Contract For Sale</label>
            </div>
            <input type="file" id="contract" accept=".pdf,.doc,.docx" @change="handleContractUpload">
          </div>
  
          <div class="p-field">
            <h3>Upload Images</h3>
            <input type="file" id="images" multiple accept="image/*" @change="handleImageUpload">
          </div>
    
          <!-- Owner -->
          <div class="p-field">
            <h3>Owner</h3>
            <label for="owner_name">Owner Name:</label>
            <InputText id="owner_name" v-model="form.owner.owner_name" required />
            <label for="contact_info">Contact Info:</label>
            <InputText id="contact_info" v-model="form.owner.contact_info" required />
          </div>
    
          <!-- Submit Button -->
          <div class="center">
            <Button type="submit" class="p-button-lg p-button-primary">Add Property</Button>
          </div>
        </form>
      </div>
      <AdminFooter />
    </template>
    
    <script>
    import Button from 'primevue/button';
    import RadioButton from 'primevue/radiobutton';
    import Checkbox from 'primevue/checkbox';
    import Calendar from 'primevue/calendar';
    import Dropdown from 'primevue/dropdown';
    import InputNumber from 'primevue/inputnumber';
    import InputText from 'primevue/inputtext';
    import Textarea from 'primevue/textarea';
    import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
    import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
  
    export default {
      components: {
        AdminFooter,
        AdminNavbar,
        InputText,
        Textarea,
        Checkbox,
        Calendar,
        Dropdown,
        InputNumber,
        Button,
        RadioButton
      },
      data() {
        return {
          form: {
            title: '',
            description: '',
            date_listed: '',
            for_rent: false,
            for_sale: false,
            status: '',
            seller_id: '',
            property_type_id: '',
            address: {
              country: '',
              municipality: '',
              city_village: '',
              address_line: '',
              postal_code: ''
            },
            features: {
              num_bedrooms: '',
              num_bathrooms: '',
              square_meters: '',
              floor_number: '',
              has_balcony: '',
              has_garden: '',
              has_garage: '',
              has_parking: '',
              has_elevator: '',
              price: ''
            },
            owner: {
              owner_name: '',
              contact_info: '',
              contract_type: null,
              contract: null // Add contract file data
            }
          },
          propertyTypes: [],
          images: [],
          salesAgents: [],
        };
      },
      mounted() {
        this.fetchPropertyTypes();
        this.fetchSalesAgents();
      },
      methods: {
        async fetchPropertyTypes() {
          try {
            const response = await fetch('http://127.0.0.1:8000/api/property_types');
            if (!response.ok) {
              throw new Error('Failed to fetch property types');
            }
            const data = await response.json();
            this.propertyTypes = data;
          } catch (error) {
            console.error('Error fetching property types:', error);
          }
        },
        async fetchSalesAgents() {
          try {
            const response = await fetch('http://127.0.0.1:8000/api/sales_agents');
            if (!response.ok) {
              throw new Error('Failed to fetch sales agents');
            }
            const data = await response.json();
            // Add fullName property to each agent
            this.salesAgents = data.map(agent => ({
              id: agent.id, // sales_agents id
              fullName: `${agent.user.first_name} ${agent.user.last_name}`
            }));
          } catch (error) {
            console.error('Error fetching sales agents:', error);
          }
        },
        handleImageUpload(event) {
          const files = event.target.files;
          this.images = [];
          for (let i = 0; i < files.length; i++) {
            this.images.push(files[i]);
          }
        },
        handleContractUpload(event) {
          this.contract = event.target.files[0];
        },
        async submitForm() {
          try {
            console.log('Form Data:', this.form);
  
            // Send form data along with the images to the backend
            const formData = new FormData();
            formData.append('form', JSON.stringify(this.form)); // Convert form data to JSON string and append
            // Append each image to the FormData object
            for (let i = 0; i < this.images.length; i++) {
              formData.append('images[]', this.images[i]);
            }
  
            if (this.contract) {
              formData.append('contract', this.contract);
            }
  
            const response = await fetch('http://127.0.0.1:8000/api/add_properties', {
              method: 'POST',
              body: formData
            });
            if (!response.ok) {
              throw new Error('Failed to add property');
            }
            // Redirect to properties list or show success message
            this.$router.push('/manage-properties-admin');
          } catch (error) {
            console.error('Error adding property:', error);
          }
        }
      }
    };
    </script>
    
    <style scoped>
    .add-property {
      padding-top: 100px;
      max-width: 800px;
      margin: 0 auto;
    }
    
    .add-property form .p-field {
      margin-bottom: 15px;
    }
    
    .add-property form .p-field label {
      display: block;
      margin-bottom: 5px;
    }
    
    .add-property form .p-field input,
    .add-property form .p-field textarea,
    .add-property form .p-field select,
    .add-property form .p-field .p-inputnumber {
      width: calc(100%); /* Adjusted width */
      margin-bottom: 20px;
    }
  
    .center {
      display: flex;
      justify-content: center;
      color: #010633;
    }
  
    .checkboxes{
      display: flex;
      flex-direction: row;
    }
    
    .p-button-lg {
      padding: 10px 20px;
      font-size: 1.2rem;
      background-color: #055190;
      border: #303B98;
      border-radius: 5px;
    }
    </style>
    
  
    