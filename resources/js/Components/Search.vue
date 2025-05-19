<template>
    <form class="search" action="#">
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
      <select name="" id="">
        <option value="">Количество гостей</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="+">+</option>
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
  import { ref, computed } from 'vue';
  import { DatePicker } from 'v-calendar';
  
  const form = ref({
    city: '',
    dates: {
      start: null,
      end: null,
    },
    guests: ''
  });
  
  const showCalendar = ref(false);
  
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
  </script>
  
  <style scoped>

.search input:first-child {
  margin-left: 7px;
}

.search {
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


<!-- <template>
    <div class="search">
        <input type="text" v-model="form.city" placeholder="Город">
        <input type="text" v-model="form.date" @focus="openCalendar">
        <DatePicker
        v-model.range="form.dates"
        :attributes="calendarAttributes"
        is-range
        :popover="{ visibility: 'focus' }"
        @onEnd="handleEnd"
        />
    </div>
</template>
<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
const form = useForm({
    city: '',
    date: '',
});
const calendar = ref(false)
const openCalendar = () =>{
    calendar.value = true
}
</script>
<style scoped>
.search{
    width: 857px;
    height: 67px;
    background: var(--elem-color);
    border-radius: 22px;
}
input{
    width: 269px;
    height: 50px;
}
</style> -->