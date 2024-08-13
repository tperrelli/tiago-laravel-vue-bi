<template>
  <div class="card">
    <div class="card-body">
      <!-- TODO
        list
      -->
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import httpRequest from '../../Services/Http';

const OK = 200;
const items = ref([]);

const symbol = ref('');
const endpoint = `/api/stocks?symbol=${symbol.value}`;

const loadData = async () => {
  const response = await httpRequest.get(endpoint, );
  if (response.status === OK) {
    items.value = response.data.data;
  }
};

watch([symbol], loadData);
</script>