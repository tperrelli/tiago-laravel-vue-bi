<template>
  <div class="card h-100">
    <div class="card-body">
      <canvas ref="doughnutChart"></canvas>
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
      text: 'Valor negociado no mês'
    }
  }
};

const doughnutChart = ref(null);
const { loadData } = useChart('/api/stocks', doughnutChart, 'doughnut', chartOptions);

loadData();
</script>