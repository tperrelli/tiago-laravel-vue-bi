<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="barChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useChart } from '../../../composables/useChart.js';

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Total de crypto por mês'
    }
  }
};

const barChart = ref(null);
const { loadData } = useChart('/api/stocks', barChart, 'bar', chartOptions);

loadData();
</script>