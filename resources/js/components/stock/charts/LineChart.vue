<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="lineChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Chart from 'chart.js/auto';
import httpRequest from '../../../Services/Http';

const OK = 200;
const chart = ref(null);
const lineChart = ref(null);

const datasets = ref([]);
const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);
const form = ref();

const chartOptions = {
  plugins: {
    filler: {
      propagate: false,
    },
  },
  interaction: {
    intersect: false,
  },
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Volume negociado no mês'
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
  if (lineChart.value && !chart.value) {
    chart.value = new Chart(lineChart.value, {
        type: 'line',
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