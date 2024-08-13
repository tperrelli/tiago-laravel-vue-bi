<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="radarChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import httpRequest from '../../../Services/Http';
import { on, off } from '../../../Services/EventBus.js';
import { onMounted, onUnmounted, ref, shallowRef } from 'vue';

const form = ref();
function handleEvent(payload) {
  form.value = payload;
  loadData();
}

onMounted(() => {
  on('filter', handleEvent);
});

onUnmounted(() => {
  off('filter', handleEvent)
});

const OK = 200;
let chart = ref(null);
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
    chart = shallowRef(new Chart(radarChart.value, {
        type: 'radar',
        data: {
          labels: labels.value,
          datasets: datasets.value
        },
        options: chartOptions
    }));
  } else if (chart.value) {
    chart.value.update();
  }
};

loadData();
</script>