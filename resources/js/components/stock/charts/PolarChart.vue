<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="bubleChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Chart from 'chart.js/auto';
import httpRequest from '../../../Services/Http';

const OK = 200;
const form = ref();
const chart = ref(null);
const bubleChart = ref(null);

const datasets = ref([]);
const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);
const chartOptions = {
  responsive: true,
  scales: {
    r: {
      pointLabels: {
        display: true,
        centerPointLabels: true,
        font: {
          size: 18
        }
      }
    }
  },
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Chart.js Polar Area Chart With Centered Point Labels'
    }
  }
};

const loadData = async () => {
  const response = await httpRequest.get('/api/stocks', { params: form.value });
  if (response.status === OK) {
    const data = Object.entries(response.data.data);
    datasets.value.splice(0, datasets.value.length);
    data.forEach((item) => {
      datasets.value.push({
        label: item[0],
        data: item[1].total
      })
    });

    loadChart();
  }
};

const loadChart = () => {
  if (bubleChart.value && !chart.value) {
    chart.value = new Chart(bubleChart.value, {
        type: 'polarArea',
        data: {
          labels: labels.value,
          datasets: datasets.value
        },
        options: chartOptions
    });
  } else {
    chart.value.update();
  }
};

loadData();
</script>