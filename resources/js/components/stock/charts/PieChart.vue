<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="pieChart"></canvas>
    </div>
  </div>
</template>

<script setup>

import { ref } from 'vue';
import { useChart } from '../../../composables/useChart.js';

const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Fatias de cryptos no mercado'
    }
  }
};

const pieChart = ref(null);
const { loadData } = useChart('/api/stocks', pieChart, 'pie', chartOptions);

loadData();
</script>