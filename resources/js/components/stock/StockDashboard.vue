<template>
  <div class="row my-4">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5">Crypto Analytics</h5>     
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col">
      <bar-chart /> 
    </div>
    <div class="col">
      <line-chart />
    </div>
    <div class="col">
      <pie-chart />
    </div>
  </div>

  <div class="row">
    <div class="col">
      <radar-chart />
    </div>
    <div class="col">
      <polar-chart />
    </div>
    <div class="col">
      <doughnut-chart />
    </div>
  </div>
</template>

<script setup>
import PieChart from './charts/PieChart.vue';
import BarChart from './charts/BarChart.vue';
import LineChart from './charts/LineChart.vue';
import RadarChart from './charts/RadarChart.vue';
import PolarChart from './charts/PolarChart.vue';
import DoughnutChart from './charts/DoughnutChart.vue';
</script>
