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
import Chart from 'chart.js/auto';
import { ref } from 'vue';
import httpRequest from '../../Services/Http';
import PieChart from './charts/PieChart.vue';
import BarChart from './charts/BarChart.vue';
import LineChart from './charts/LineChart.vue';
import RadarChart from './charts/RadarChart.vue';
import PolarChart from './charts/PolarChart.vue';
import DoughnutChart from './charts/DoughnutChart.vue';

const OK = 200;
const mainChart = ref(null);

let chart = null;
const coins = ref([
  { value: '',     label: '- all -'},
  { value: 'ATL',  label: 'ATL'},
  { value: 'BTC',  label: 'BTC'},
  { value: 'ETH',  label: 'ETH'},
    { value: 'SOL',  label: 'SOL'},
]);
const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);
const datasets = ref([]);

const form = ref({
  symbol: '',
  month: '',
});

const months = ref([
    { label: '- all -', value: '' },
    { label: 'Jan', value: 1 },
    { label: 'Fev', value: 2 },
    { label: 'Mar', value: 3 },
    { label: 'Apr', value: 4 },
    { label: 'Mai', value: 5 },
    { label: 'Jun', value: 6 },
]);

const chartData = {
  labels: labels.value,
  datasets: datasets.value
};

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
};

const loadData = async () => {

  const response = await httpRequest.get('/api/stocks', { params: form.value });
  if (response.status === OK) {
    const data = Object.entries(response.data.data)
    datasets.value.splice(0, datasets.value.length)
    data.forEach((item) => {
      datasets.value.push({
        label: item[0],
        data: item[1].total
      })
    })

    loadChart();
  }
};

const loadChart = () => {
  if (mainChart.value && !chart) {
    chart = new Chart(mainChart.value, {
        type: 'bar',
        data: chartData,
        options: chartOptions
    });
  } else if (chart) {
    chart.update()
  }
};

loadData();

</script>
