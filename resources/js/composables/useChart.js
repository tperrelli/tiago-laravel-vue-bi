import { ref, shallowRef, onMounted, onUnmounted } from 'vue';
import Chart from 'chart.js/auto';
import httpRequest from '../Services/Http';
import { on, off } from '../Services/EventBus.js';

export function useChart(endpoint, chartContext, typeChart = 'line', chartOptions = {}, eventBusFilter = 'filter') {

  const form = ref(null);
  let chart = ref(null);
  const OK = 200;
  const datasets = ref([]);
  const labels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun']);

  const loadData = async () => {
    const response = await httpRequest.get(endpoint, { params: form.value });
    if (response.status === OK) {
      const data = Object.entries(response.data.data);
      datasets.value.splice(0, datasets.value.length);
      data.forEach((item) => {
        datasets.value.push({
          label: item[0],
          data: item[1].total
        })
      });
  
      loadChart();
    }
  };

  const loadChart = () => {
    if (chartContext.value && !chart.value) {
      chart = shallowRef(new Chart(chartContext.value, {
          type: typeChart,
          data: {
            labels: labels.value,
            datasets: datasets.value
          },
          options: chartOptions
      }));
    } else if (chart.value) {
      chart.value.update()
    }
  };

  const handleEvent = (payload) => {
    form.value = payload;
    loadData();
  };

  onMounted(() => {
    on(eventBusFilter, handleEvent);
    loadData();
  });

  onUnmounted(() => {
    off(eventBusFilter, handleEvent);
    if (chart.value) {
      chart.value.destroy();
    }
  });
  
  return {
    loadData,
  };

}