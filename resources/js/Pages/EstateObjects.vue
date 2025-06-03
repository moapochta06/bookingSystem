<template>
    <Layout>
        <h1>Объекты</h1>
        <div v-for="object in estateObjects" :key="object.id" class="object-card">
            <img  v-if="object.image && object.image !== 'null'" :src="`/storage/${object.image}`" alt="Изображение объекта" class="w-full h-48 object-cover rounded">

            <div class="">
                <h4>{{ object.title }}</h4>
                <span>{{ object.area }}м²</span>
                <span>{{ object.rooms_count }}комнаты</span>
                <span>{{ object.guests_count }}гостя</span>
                <div class="price">{{ object.price }} ₽ / ночь</div>
                <div class="adress">{{ object.city }}, ул.{{ object.street }}, д.{{ object.house_number }}, кв.{{ object.apartment_number }}</div>
                <Link method="get" :href="`/objects/estate/${object.id}`">Подробнее</Link>
                <button class="more_btn" @click="toggleActions(object.id)">...</button>
            </div>
            <!-- Выпадающее меню действий -->
                <div v-if="activeDropdown === object.id" class="absolute right-2 top-10 bg-white border shadow-md z-10">
                    <ul>
                        <li>
                            <Link :href="`/admin/estate/${object.id}/edit`">Редактировать</Link>
                        </li>
                        <li>
                            <Link method="delete" :href="`/admin/estate/${object.id}`" class="text-red-600">
                                Удалить
                            </Link>
                        </li>
                    </ul>
                </div>
        </div>
        <Link method="get" href="/admin/create/estate" >
                Добавить +
        </Link>
    </Layout>
</template>

<script setup>
import Layout from '../Layouts/Layout.vue'
import { reactive, ref} from 'vue'
import { router, usePage, Link } from '@inertiajs/vue3'

const page = usePage();
const { estateObjects} = usePage().props
document.title = page.props.title;

// Отслеживаем активный dropdown
const activeDropdown = ref(null)

function toggleActions(id) {
    activeDropdown.value = activeDropdown.value === id ? null : id
}
</script>

<style scoped>
h1 {
    font-weight: 500;
}
</style>