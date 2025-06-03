<template>
    <form class="search" @submit.prevent="submitForm">
      <input 
        type="text" 
        v-model="form.city" 
        placeholder="Город"
      >
      <input 
        type="text" 
        :value="formatDates(form.dates)" 
        placeholder="Заезд &nbsp; &mdash; &nbsp;Выезд"
        @click="showCalendar = true"
        readonly
      >
      <select v-model="form.guests">
        <option value="">Количество гостей</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
       <button type="submit"></button>
    </form>
    <DatePicker
        v-if="showCalendar"
        v-model.range="form.dates" 
        :attributes="attributes"
        :popover="{ visibility: 'click' }"
      />
  </template>
  
  <script setup>
  import { setupCalendar } from 'v-calendar';
  import 'v-calendar/style.css';
  import { ref, computed, onMounted } from 'vue'
  import { DatePicker } from 'v-calendar';
  import { router } from '@inertiajs/vue3' 

  
  const showCalendar = ref(false);

  const form = ref({
    city: '',
    dates: {
      start: null,
      end: null,
    },
    guests: ''
  });
  
  const attributes = computed(() => [
    {
      key: 'today',
      highlight: {
        color: 'blue',
        fillMode: 'light',
      },
      dates: new Date(),
    },
  ]);
  
  const formatDates = (dates) => {
    if (!dates?.start || !dates?.end) return '';
    return `${dates.start.toLocaleDateString()}   —   ${dates.end.toLocaleDateString()}`;
  };

  const formatForUrl = (date) => {
      return date ? new Date(date).toISOString().split('T')[0] : ''
  }


  const urlParams = new URLSearchParams(window.location.search)

  onMounted(() => {
      form.value = {
          city: urlParams.get('city') || '',
          dates: {
              start: urlParams.get('from') ? new Date(urlParams.get('from')) : null,
              end: urlParams.get('to') ? new Date(urlParams.get('to')) : null,
          },
          guests: urlParams.get('guests') || '',
      }
  })

const submitForm = () => {
    const startDate = formatForUrl(form.value.dates.start)
    const endDate = formatForUrl(form.value.dates.end)

    router.get('/search-results', {
        city: form.value.city,
        from: startDate,
        to: endDate,
        guests: form.value.guests,
        show_all: false,
    })
}
  </script>
  
  <style scoped>

.search input:first-child {
  margin-left: 7px;
}

.search {
    margin: 0 auto 40px;
    width: 857px;
    height: 67px;
    background: var(--elem-color);
    border-radius: 22px;
    display: flex;
    gap: 7px;
    align-items: center;
    justify-content: start;
}
input, select {
    width: 256px;
    height: 50px;
    border-radius: 18px;
    margin: 0;
}

.search input:nth-child(2) {
   text-align: center;
}

select {
  padding: 13px;
  background: var(--bg-color);
}

button {
  width: 30px;
  height: 30px;
  margin-left: 10px;
  background: url(../../images/search.svg) no-repeat center;
}
  </style>


