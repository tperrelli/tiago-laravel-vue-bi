<template>
  <div class="container pt-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5">Crypto Analytics</h5>
        <form action="">
          <div class="row row-cols-lg-auto">
            <div class="col-12">
              <select class="form-select">
                  <option value="{{ coin }}" v-for="(coin, index) in coins">{{  coin }}</option>
              </select>
            </div>
            <div class="col-12">
              <input type="text" class="form-control" placeholder="Name" aria-label="Name">
            </div>
            <div class="col-12">
              <input type="text" class="form-control" placeholder="Amount" aria-label="Amount">
            </div>
            <div class="col-12">
              <input type="text" class="form-control" placeholder="Month" aria-label="Month">
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
const datasets = ref([]);

const chartData = {
  labels: labels.value,
  datasets: datasets.value
};

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
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
    new Chart(mainChart.value, {
      type: 'bar', 
      data: chartData, 
      options: chartOptions
    });
  }
};

const filterData = () => {

  //TODO
};

loadData();
filterData();

</script>
