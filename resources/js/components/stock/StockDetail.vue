<template>
  <div class="row my-4">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Symbol</th>
                <th scope="col">Amount</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(coin, index) in items">
                <th scope="row">{{ coin.name }}</th>
                <th>{{ coin.small_name }}</th>
                <td>{{ coin.amount }}</td>
                <td>{{ coin.description }}</td>
              </tr>
            </tbody>
          </table>

           <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: currentPage == 1 }">
                <button class="page-link" @click="goToPage(currentPage - 1)">Previous</button>
              </li>
              <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                <button class="page-link" @click="goToPage(currentPage + 1)">Next</button>
              </li>
            </ul>
          </nav>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import httpRequest from '../../Services/Http';
import { useRoute } from 'vue-router';

const OK = 200;
const items = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const route = useRoute();

const loadData = async () => {

  const symbol = route.params.id;
  const endpoint = `/api/stocks/${symbol}?page=${currentPage.value}`;

  const response = await httpRequest.get(endpoint);
  if (response.status === OK) {
    console.log(response.data);
    items.value = response.data.data;
    currentPage.value = response.data.meta.current_page;
    lastPage.value = response.data.meta.last_page;
  }
};

const goToPage = (page) => {
  console.log(page);
  if (page >= 1 && page <= lastPage.value) {
    currentPage.value = page;
    loadData();
  }
};

loadData();
</script>