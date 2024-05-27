<script setup>
import StaffFooter from '../../components/staffComponents/StaffFooter.vue';
import StaffNavbar from '../../components/staffComponents/StaffNavbar.vue';
import Chart from 'primevue/chart';
import { ref, onMounted } from "vue";
import axios from 'axios';

const chartData = ref(null);
const chartOptions = ref(null);
const propertiesStatusChartData = ref(null);
const jobApplicationsChartData = ref(null);
const jobApplicationsChartOptions = ref(null);

const setChartData = async () => {
    const response = await axios.get('http://127.0.0.1:8000/api/sales-report');
    const salesData = response.data;
    
    // Create an array of days of the week
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    const data = {
        labels: daysOfWeek,
        datasets: [{
            label: 'Properties Sold',
            backgroundColor: '#007bff',
            data: daysOfWeek.map(day => salesData[day] || 0)
        }]
    };

    return data
};

const setPropertiesStatusChartData = async () => {
    const response = await axios.get('http://127.0.0.1:8000/api/property-status');
    const propertyData = response.data;

    const documentStyle = getComputedStyle(document.body);

    return {
        labels: ['For Rent', 'For Sale'],
        datasets: [
            {
                label: 'Properties',
                data: [propertyData.forRentCount, propertyData.forSaleCount],
                backgroundColor: [documentStyle.getPropertyValue('--cyan-500'), documentStyle.getPropertyValue('--orange-500')],
                hoverBackgroundColor: [documentStyle.getPropertyValue('--cyan-400'), documentStyle.getPropertyValue('--orange-400')]
            }
        ]
    };
};

const getMonthLabels = () => {
    const currentMonth = new Date().getMonth();
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return months.slice(currentMonth - 5).concat(months.slice(0, currentMonth + 1));
};

const setJobApplicationsChartData = async () => {
    const response = await axios.get('http://127.0.0.1:8000/api/job-applications-report');
    const jobApplicationsData = response.data;

    // Extract the days of the week and corresponding number of job applications
    const daysOfWeek = Object.keys(jobApplicationsData);
    const applicationsCount = daysOfWeek.map(day => jobApplicationsData[day]);

    // Prepare chart data
    const documentStyle = getComputedStyle(document.documentElement);
    return {
        labels: daysOfWeek,
        datasets: [
            {
                label: 'Job Applications',
                data: applicationsCount,
                fill: false,
                borderColor: documentStyle.getPropertyValue('--cyan-500'),
                tension: 0.4
            }
        ]
    };
};

const setChartOptions = () => {
    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                stacked: true,
                grid: { display: false },
                ticks: { color: '#666' }
            },
            y: {
                stacked: true,
                grid: { color: '#eee' },
                ticks: { color: '#666' }
            }
        }
    };
};

const setJobApplicationsChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
};


// Ensure that onMounted is called inside the setup function
onMounted(async () => {
    chartData.value = await setChartData();
    chartOptions.value = setChartOptions();
    propertiesStatusChartData.value = await setPropertiesStatusChartData();
    jobApplicationsChartData.value = await setJobApplicationsChartData();
    jobApplicationsChartOptions.value = setJobApplicationsChartOptions();
});
</script>

<template>
  <div>
    <StaffNavbar />
    <div style="margin-top: 150px;">
      <h1>Sold Properties</h1>
      <Chart type="bar" :data="chartData" :options="chartOptions" class="h-30rem" />
    </div>
    <h1>Properties Status</h1>
    <div class="card">
      <Chart type="pie" :data="propertiesStatusChartData" :options="propertiesStatusChartOptions" class="w-full md:w-30rem" />
    </div>
    <h1>Job Applications</h1>
    <div class="card">
      <Chart type="line" :data="jobApplicationsChartData" :options="jobApplicationsChartOptions" class="h-30rem" />
    </div>
    <StaffFooter />
  </div>
</template>

<style scoped>
  h1 {
    display: flex;
    justify-content: center;
    color: #010633;
    margin-top: 100px;
  }

  .card{
    margin-top: 60px; 
    display: flex; 
    justify-content: center;
  }
</style>
