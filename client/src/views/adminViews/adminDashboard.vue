<template>
  <div class="admin-welcome">
    <AdminNavbar />
    <br><br><br><br><br><br>
    <div class="welcome-message">
      <h1>Welcome, Admin!</h1>
      <p>Enjoy managing your platform with ease.</p>
      <br>
    </div>
    <AdminFooter />
  </div>
</template>

<script>
import AdminFooter from '../../components/adminComponents/AdminFooter.vue';
import AdminNavbar from '../../components/adminComponents/AdminNavbar.vue';

export default {
  components: {
    AdminNavbar,
    AdminFooter,
  },
};
</script>

<style scoped>
.admin-welcome {
  text-align: center;
  background-color: #f2f2f2;
  padding: 20px;
}

.welcome-message {
  margin-top: 50px;
}

.welcome-message h1 {
  font-size: 36px;
  color: #333;
}

.welcome-message p {
  font-size: 18px;
  color: #666;
}
</style>
