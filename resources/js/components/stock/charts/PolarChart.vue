<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="polarChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useChart } from '../../../composables/useChart.js';

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
      text: 'Polaridade de cryptos'
    }
  }
};
const polarChart = ref(null);
const { loadData } = useChart('/api/stocks', polarChart, 'polarArea', chartOptions);

loadData();
</script>