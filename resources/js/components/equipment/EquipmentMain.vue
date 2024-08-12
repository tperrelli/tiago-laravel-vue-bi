<template>
  <div class="container pt-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5">Crypto Analytics</h5>
        <form action="">
          <div class="row row-cols-lg-auto">
            <div class="col-12">
              <select class="form-select" v-model="form.symbol">
                  <option :value="coin" v-for="(coin, index) in coins">{{  coin }}</option>
              </select>
            </div>
            <div class="col-12">
              <input type="text" class="form-control" placeholder="Name" aria-label="Name" v-model="form.name" />
            </div>
            <div class="col-12">
              <input type="text" class="form-control" placeholder="Amount" aria-label="Amount" v-model="form.amount" />
            </div>
            <div class="col-12">
              <select class="form-select" v-model="form.month">
                <option :value="month.value" v-for="(month, index) in months">{{ month.label }}</option>
              </select>
            </div>
            <div class="col-12">
              <input type="button" @click="filterData" class="btn btn-success" value="Filter" />
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

const coins = ref(['- all -', 'BTC', 'ETH', 'SOL']);
const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);
const months = ref([
  { label: 'Jan', value: 1 }, { label: 'Fev', value: 2 }, { label: 'Mar', value: 3 }, { label: 'Apr', value: 4 }, { label: 'Mai', value: 5 }, { label: 'Jun', value: 6 }
])

const datasets = ref([]);

const form = {
  symbol: null,
  name: null,
  amount: null,
  month: null
};

const loadData = async () => {

  const response = await httpRequest.get('/api/stocks');
  if (response.status === OK) {
    const data = Object.entries(response.data.data)

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
  if (mainChart.value) {

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
    };

    new Chart(mainChart.value, {
      type: 'bar', 
      data: {
        labels: labels.value,
        datasets: datasets.value
      }, 
      options: chartOptions
    });
  }
};

const filterData = async () => {

  const params = {};

  if (form.symbol) {
    params.symbol = form.symbol;
  }

  if (form.amount) {
    params.amount = form.amount;
  }

  if (form.month) {
    params.month = form.month;
  }

  const response = await httpRequest.get('/api/stocks', { params });

  if (response.status === OK) {
    datasets.value = [];
    loadData();
  }
};

loadData();

</script>
