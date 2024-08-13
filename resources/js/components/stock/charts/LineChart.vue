<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="lineChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useChart } from '../../../composables/useChart.js';

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
      text: 'Linha do tempo'
    }
  }
};

const lineChart = ref(null);
const { loadData } = useChart('/api/stocks', lineChart, 'line', chartOptions);

loadData();
</script>
