<template>
    <Layout>
            <h1>{{ estateObject.title }}</h1>
            <div>г.{{ estateObject.city }}, ул.{{ estateObject.street }}, д.{{ estateObject.house_number }}, кв.{{ estateObject.apartment_number }}</div> 

            <div class="flex mt-6 gap-5">
                <img 
                v-if="estateObject.image && estateObject.image !== 'null'" 
                :src="`/storage/${estateObject.image}`" 
                alt="Изображение объекта"
                class=" w-[540px] object-cover "
                >
                <div class="flex flex-col flex-1 h-[305px] pt-9 px-5 pb-9 bg-white [border-radius:20px]">
                    <div class="flex gap-2">
                        <p class="border text-center" v-if="fromDate">{{ formatDate(fromDate) }}</p>
                        <p class="border text-center" v-else>-</p>
                        <p class="border text-center" v-if="toDate">{{ formatDate(toDate) }}</p>
                        <p class="border text-center"  v-else>-</p>
                    </div>
                    <div class="relative">
                        <p class="border pl-5" v-if="guests">Количество гостей: {{ guests }}</p>
                        <p class="border pl-5" v-else>Количество гостей:  - </p>

                    <div class="absolute inset-y-0 right-0 flex mt-2 pr-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    </div>
                    <div class="flex justify-between mt-3">
                    <p><strong>Итого</strong> за {{ daysCount}} суток</p><div class="price">{{ totalPrice }} ₽</div>
                    </div>
                    <button @click="book">Забронировать</button>
                </div>
            </div>
            
            <div class="w-[540px] mt-5 mb-10 pt-8 pb-8 px-10 bg-white [border-radius:20px]">
            <div class="flex gap-5 mb-4">
                <p> Площадь: {{ estateObject.area }} м²</p>
                <p> Комнаты: {{ estateObject.rooms_count }}</p>
                <p> Гостей: {{ estateObject.guests_count }}</p>
            </div>
        
            <div v-if="estateObject.description" class="description ">
                <p>{{ estateObject.description }}</p>
            </div>

            <div class="features mt-4">
                <div>Детали</div>
                <p v-if="estateObject.pets_allowed">Можно с животными</p>
                <p v-if="estateObject.free_cleaning">Бесплатная уборка</p>
                <p v-if="estateObject.air_conditioner">Кондиционер</p>
                <p v-if="estateObject.wifi">Wi-Fi</p>
            </div>
            </div>
<!-- 🐾🧹❄📶 -->
        <!-- Модальное окно -->
        <div v-if="showModal" class="modal-overlay">
            <div class="modal">
                <p :class="{ 'text-green-600': !isModalError, 'text-red-600': isModalError }">
                    {{ modalMessage }}
                </p>
                <div @click="showModal = false">&#215;</div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layouts/Layout.vue'
import { usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = usePage().props
const estateObject = props.estateObject
const fromDate = props.fromDate
const toDate = props.toDate
const guests = props.guests
const user = props.auth.user

const showModal = ref(false)
const modalMessage = ref('')
const isModalError = ref(false)

function formatDate(dateString) {
  const options = { day: 'numeric', month: 'long' };
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('ru', options).format(date);
}

const daysCount = computed(()=>{
    const start = new Date(fromDate);
    const end = new Date(toDate);
    const diffDays = (end - start)/(1000*60*60*24)
    return diffDays
})

const totalPrice = computed(()=>{
    return estateObject.price * daysCount.value;
})

function book() {
    if (!user) {
        modalMessage.value = 'Для бронирования нужно войти в аккаунт'
        isModalError.value = true
        showModal.value = true
        return
    }


    router.post('/bookings', {
        estate_object_id: estateObject.id,
        guest_name: user.name, 
        from_date: fromDate,
        to_date: toDate,
        guests: guests,
        status: 'active' 
       },
       {
        onSuccess: () => {
            modalMessage.value = 'Готово!'
            isModalError.value = false
            showModal.value = true
        },
        onError: (errors) => {
            const messages = Object.values(errors).flat()
            modalMessage.value = messages.join('\n')
            isModalError.value = true
            showModal.value = true
    }})
}

</script>

<style scoped>
h1 {
    margin-top: 70px;
    margin-bottom: 2px;
    font-size: 24px;
    font-weight: 700;
}
h3 {
    font-size: 20px;
}
.content {
    max-width: 800px;
    margin: 2rem auto;
}
img {
    width: 540px;
    height: 380px;
    border-radius: 20px;
}
.description {
    white-space: pre-wrap;
}
button {
    width: 100%;
    height: 50px;
    background: var(--elem-color);
    border-radius: 17px;
    color: #fff;
    margin-top: auto;
}
.back-button {
    margin: 1rem auto;
    max-width: 800px;
    display: inline-block;
    padding: 8px 12px;
    background-color: #f0f0f0;
    border-radius: 4px;
    color: #333;
    text-decoration: none;
    font-weight: 500;
}
.back-button:hover {
    background-color: #e0e0e0;
}
.border {
    border: 1px solid #828282;
    border-radius: 4px;
    margin-bottom: 13px;
    width: 100%;
    height: 35px;
    line-height: 32px;
}
.price {
    font-size: 20px;
    font-weight: 600;
}
.features>div {
    font-size: 18px;
    font-weight: 600;
    margin: 20px 0 10px;
}
.features>p {
    margin-bottom: 9px;
    line-height: 22px;
    background:url(../../images/check.svg) no-repeat center left;
    height: 20px;
    padding-left: 23px;
}
.modal {
    width: 340px;
    height: 180px;
    margin: 150px auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #fff;
    border-radius: 20px;
    position: relative;
    padding: 20px;
}
.modal > div {
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
}
.modal > p {
    font-size: 28px;

}

</style>