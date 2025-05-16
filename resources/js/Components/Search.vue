<template>
    <div class="search">
      <input 
        type="text" 
        v-model="form.city" 
        placeholder="Город"
      >
      <input 
        type="text" 
        :value="formatDates(form.dates)" 
        placeholder="Выберите даты"
        @click="showCalendar = true"
        readonly
      >
      <DatePicker
        v-if="showCalendar"
        v-model.range="form.dates" 
        :attributes="attributes"
        :popover="{ visibility: 'click' }"
        @close="showCalendar = false"
      />
    </div>
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
    return `${dates.start.toLocaleDateString()} — ${dates.end.toLocaleDateString()}`;
  };
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