<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="radarChart"></canvas>
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
const radarChart = ref(null);

const datasets = ref([]);
const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);
const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Presenção de criptomoedas no mês'
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
  if (radarChart.value && !chart.value) {
    chart.value = new Chart(radarChart.value, {
        type: 'radar',
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