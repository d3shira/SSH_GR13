<template>
    <AdminNavbar/>
    <br><br><br>
    <div class="register-page">
        <!-- Register Form Content -->
        <div class="register-form-content">
            <!-- Form Content -->
            <div class="content">
                <!-- Register Form -->
                <div class="form-container">
                    <h2>Register Form</h2>
                    <form @submit.prevent="submitForm" class="form-fields">
                        <div class="p-field">
                            <label for="first_name">First Name</label>
                            <InputText id="first_name" v-model="form.first_name" />
                        </div>
                        <div class="p-field">
                            <label for="last_name">Last Name</label>
                            <InputText id="last_name" v-model="form.last_name" />
                        </div>
                        <div class="p-field">
                            <label for="username">Username</label>
                            <InputText id="username" v-model="form.username" />
                        </div>
                        <div class="p-field">
                            <label for="email">Email</label>
                            <InputText id="email" v-model="form.email" />
                        </div>
                        <div class="p-field">
                            <label for="phone">Phone number</label>
                            <InputText id="phone" v-model="form.phone" />
                        </div>
                        <div class="p-field">
                            <label for="job_position">Job Position</label>
                            <InputText id="job_position" v-model="form.job_position" />
                        </div>
                        <div class="p-field">
                            <label for="password">Password</label>
                            <InputText id="password" v-model="form.password" type="password" />
                        </div>
                        <div class="p-field">
                            <Button type="submit" label="Register" icon="pi pi-check" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <AdminFooter />
</template>

<script>
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';
import InputText  from 'primevue/inputtext';
import Button  from 'primevue/button';

export default {
    components: {
        InputText,
        Button,
        AdminNavbar,
        AdminFooter
    },
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                username: '',
                email: '',
                phone:'',
                job_position:'',
                password: ''
            }
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/registerStaff', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                if (!response.ok) {
                    throw new Error('Failed to register');
                }

                // Reset the form after successful registration
                this.form = {
                    first_name: '',
                    last_name: '',
                    username: '',
                    email: '',
                    phone:'',
                    job_position:'',
                    password: ''
                };

                console.log('Registration successful');
        
            } catch (error) {
                console.error('Error registering user:', error);
            }
        }
    }
};
</script>

<style scoped>
.register-page {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.register-form-content {
    width: 400px;
}

.content {
    text-align: center;
}

.form-container {
    background-color: #f4f4f4;
    border-radius: 5px;
    padding: 20px;
}

.form-fields {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.p-field {
    display: flex;
    align-items: center;
}

label {
    width: 100px; /* Adjust the width as needed */
    margin-right: 1rem;
}
</style>
