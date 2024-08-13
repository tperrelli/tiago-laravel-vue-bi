<template>
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
              Dashboard
              </a>
          </li>
          <li class="nav-item mb-2">
            <div class="col-12">
              <select class="form-select" v-model="form.symbol">
                  <option :value="coin.value" v-for="(coin, index) in coins">{{ coin.label }}</option>
                </select>
            </div>
          </li>
          <li class="nav-item mb-2">
            <div class="col-12">
                <input type="text" class="form-control" placeholder="Name" aria-label="Name" v-model="form.amount">
            </div>
          </li>
          <li class="nav-item mb-2">
            <div class="col-12">
                <input type="text" class="form-control" placeholder="Amount" aria-label="Amount">
            </div>
          </li>
          <li class="nav-item mb-2">
            <div class="col-12">
              <select class="form-select" v-model="form.month">
                <option :value="month.value" v-for="(month, index) in months">{{ month.label }}</option>
              </select>
            </div>
          </li>
          <li class="nav-item mb-2">
            <div class="col-12">
              <input type="submit" class="btn btn-success" value="Filter" @click="filter"/>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { emit } from '../Services/EventBus';

const form = ref({
  symbol: '',
  name: '',
  amount: 0,
  month: ''
});

const coins = ref([
  { value: '',     label: '- all -'},
  { value: 'ATL',  label: 'ATL'},
  { value: 'BTC',  label: 'BTC'},
  { value: 'ETH',  label: 'ETH'},
  { value: 'SOL',  label: 'SOL'},
  { value: 'BNB',  label: 'BNB'},
  { value: 'XRP',  label: 'XRP'},
]);

const months = ref([
  { label: '- all -', value: '' },
  { label: 'Jan', value: 1 },
  { label: 'Fev', value: 2 },
  { label: 'Mar', value: 3 },
  { label: 'Apr', value: 4 },
  { label: 'Mai', value: 5 },
  { label: 'Jun', value: 6 },
]);

const filter = () => {
  emit('filter', form.value);
}
</script>