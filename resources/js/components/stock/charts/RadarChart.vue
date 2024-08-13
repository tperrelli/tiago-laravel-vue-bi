<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="radarChart"></canvas>
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
      text: 'Presenção de criptomoedas no mês'
    }
  }
};

const radarChart = ref(null);
const { loadData } = useChart('/api/stocks', radarChart, 'radar', chartOptions);

loadData();
</script>