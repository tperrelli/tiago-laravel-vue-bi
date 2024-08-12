<template>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" placeholder="First name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="First name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="First name">
          </div>
        </div>
      </form>

        <form class="form-inline">
          <div class="form-group mx-sm-3 mb-2">
            <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
            <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
              <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
          </div>
          
        </form>


        <!-- <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Email address</label>
          <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div> -->
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

loadData();

</script>
