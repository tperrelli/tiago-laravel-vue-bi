<template>
  <div class="container pt-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5">Crypto Analytics</h5>
        <form @submit.prevent="loadData">
          <div class="row row-cols-lg-auto">
            <div class="col-12">
              <select class="form-select" v-model="form.symbol">
                  <option :value="coin.value" v-for="(coin, index) in coins">{{ coin.label }}</option>
              </select>
            </div>
            <div class="col-12">
              <input type="text" v-model="form.name" class="form-control" placeholder="Name" aria-label="Name">
            </div>
            <div class="col-12">
              <input type="text" v-model="form.amount" class="form-control" placeholder="Amount" aria-label="Amount">
            </div>
              <div class="col-12">
                  <select class="form-select" v-model="form.month">
                      <option :value="month.value" v-for="(month, index) in months">{{ month.label }}</option>
                  </select>
              </div>
            <div class="col-12">
              <input type="submit" class="btn btn-success" value="Filter" />
            </div>
          </div>
        </form>
      </div>
      <div class="card-body">
        <canvas ref="mainChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { ref } from 'vue';
import httpRequest from '../../Services/Http';

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
