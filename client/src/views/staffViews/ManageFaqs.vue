<template>
    <div>
      <StaffNavbar />
      <h1 style="padding-top: 110px; padding-bottom: 20px; display: flex; justify-content: center; color: #010633;">FAQs Dashboard</h1>
      <div class="card">
        <DataTable :value="faqs" paginator :rows="10" tableStyle="min-width: 50rem">
          <Column field="id" header="ID" style="width: 10%"></Column>
          <Column field="user_id" header="User ID" style="width: 10%"></Column>
          <Column field="question" header="Question" style="width: 30%"></Column>
          <Column field="answer" header="Answer" style="width: 30%"></Column>
          <Column header="Actions" style="width: 20%">
            <template #body="slotProps">
              <Button label="Edit" icon="pi pi-pencil" @click="editFaq(slotProps.data)" />
            </template>
          </Column>
        </DataTable>
      </div>
      <Dialog header="Edit FAQ" v-model:visible="showDialog">
        <div class="p-fluid">
          <div class="p-field">
            <label for="question">Question</label>
            <InputText id="question" v-model="selectedFaq.question" disabled />
          </div>
          <div class="p-field">
            <label for="answer">Answer</label>
            <InputText id="answer" v-model="selectedFaq.answer" />
          </div>
        </div>
        <template #footer>
          <Button label="Cancel" icon="pi pi-times" @click="showDialog = false" class="p-button-text" />
          <Button label="Save" icon="pi pi-check" @click="saveFaq" />
        </template>
      </Dialog>
      <StaffFooter />
    </div>
  </template>
  <script setup>
  import StaffNavbar from '@/components/staffComponents/StaffNavbar.vue';
  import StaffFooter from '@/components/staffComponents/StaffFooter.vue';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import Button from 'primevue/button';
  import Dialog from 'primevue/dialog';
  import InputText from 'primevue/inputtext';
  import { ref, onMounted } from 'vue';
  
  const faqs = ref([]);
  const selectedFaq = ref(null);
  const showDialog = ref(false);
  
  onMounted(async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/faqs');
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      faqs.value = data;
    } catch (error) {
      console.error('Error fetching FAQs:', error);
    }
  });
  
  const editFaq = (faq) => {
    selectedFaq.value = { ...faq };
    showDialog.value = true;
  };
  
  const saveFaq = async () => {
    console.log('Saving FAQ:', selectedFaq.value); // Debugging: Log the selected FAQ before saving
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/faqs/${selectedFaq.value.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ answer: selectedFaq.value.answer }), // Ensure only the answer is being sent
      });
      console.log('Response:', response); // Debugging: Log the response
      if (!response.ok) {
        const errorData = await response.json();
        console.error('Error response:', errorData);
        throw new Error('Network response was not ok');
      }
      const updatedFaq = await response.json();
      console.log('Updated FAQ:', updatedFaq); // Debugging: Log the updated FAQ
      const index = faqs.value.findIndex(faq => faq.id === updatedFaq.id);
      if (index !== -1) {
        faqs.value[index] = updatedFaq;
      }
      showDialog.value = false;
    } catch (error) {
      console.error('Error updating FAQ:', error);
    }
  };
  </script>
  
  
  <style scoped>
  .card {
    margin: 20px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background-color: #fff;
  }

  </style>