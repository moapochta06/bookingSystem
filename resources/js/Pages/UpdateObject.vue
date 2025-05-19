<template>
    <Layout>
        <div class="content">
            <h1>Обновление объекта</h1>

            <form @submit.prevent="submitForm">
                <div class="form-container">
                    <!-- Левая колонка -->
                    <div class="left-column">
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input v-model="form.title" type="text" id="title" name="title" placeholder="Введите заголовок" required>
                        </div>

                        <div class="form-group">
                            <label for="city">Адрес</label>
                            <input v-model="form.city" type="text" id="city" name="city" placeholder="Город" required>
                        </div>

                        <div class="form-group">
                            <input v-model="form.street" type="text" id="street" name="street" placeholder="Улица" required>
                        </div>

                        <div class="form-group">
                            <input v-model="form.house_number" type="text" class="house-number-input"> Дом №
                            <input v-model="form.apartment_number" type="text" class="apartment-number-input"> Квартира №
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea v-model="form.description" id="description" name="description" rows="5" placeholder="Введите описание"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Загрузить изображение</label>
                            <input @change="handleImageChange" type="file" id="image" name="image">
                            <div v-if="form.image_preview" class="image-preview">
                                <img :src="form.image_preview" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка -->
                    <div class="right-column">
                        <div class="form-group">
                            <label>Кол-во комнат</label>
                            <div class="button-group">
                                <button type="button" @click="setRooms(1)">1</button>
                                <button type="button" @click="setRooms(2)">2</button>
                                <button type="button" @click="setRooms(3)">3</button>
                                <button type="button" @click="setRooms('+')">+</button>
                            </div>
                            <input v-model.number="form.rooms_count" type="hidden" id="rooms_count" name="rooms_count">
                        </div>

                        <div class="form-group">
                            <label>Кол-во гостей</label>
                            <div class="button-group">
                                <button type="button" @click="setGuests(1)">1</button>
                                <button type="button" @click="setGuests(2)">2</button>
                                <button type="button" @click="setGuests(3)">3</button>
                                <button type="button" @click="setGuests('+')">+</button>
                            </div>
                            <input v-model.number="form.guests_count" type="hidden" id="guests_count" name="guests_count">
                        </div>

                        <div class="form-group">
                            <label for="area">Площадь</label>
                            <input v-model.number="form.area" type="number" id="area" name="area" placeholder="в кв. м." step="0.01" required>
                            <span>кв. м.</span>
                        </div>

                        <div class="form-group">
                            <label for="price">Цена</label>
                            <input v-model.number="form.price" type="number" id="price" name="price" placeholder="в рублях" step="0.01" required>
                            <span>руб.</span>
                        </div>

                        <div class="form-group">
                            <label>Детали</label>
                            <ul class="checkbox-group">
                                <li>
                                    <input v-model="form.pets_allowed" type="checkbox" id="pets_allowed" name="pets_allowed" true-value="1" false-value="0">
                                    <label for="pets_allowed">Можно с животными</label>
                                </li>
                                <li>
                                    <input v-model="form.free_cleaning" type="checkbox" id="free_cleaning" name="free_cleaning" true-value="1" false-value="0">
                                    <label for="free_cleaning">Бесплатная уборка</label>
                                </li>
                                <li>
                                    <input v-model="form.air_conditioner" type="checkbox" id="air_conditioner" name="air_conditioner" true-value="1" false-value="0">
                                    <label for="air_conditioner">Кондиционер</label>
                                </li>
                                <li>
                                    <input v-model="form.wifi" type="checkbox" id="wifi" name="wifi" true-value="1" false-value="0">
                                    <label for="wifi">Wi-Fi</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit">Сохранить</button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layouts/Layout.vue'
import { reactive, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const props = defineProps({
    estateObject: Object
})

const form = reactive({
    title: props.estateObject.title || '',
    city: props.estateObject.city || '',
    street: props.estateObject.street || '',
    house_number: props.estateObject.house_number || '',
    apartment_number: props.estateObject.apartment_number || '',
    description: props.estateObject.description || '',
    rooms_count: props.estateObject.rooms_count || 1,
    guests_count: props.estateObject.guests_count || 1,
    area: props.estateObject.area || '',
    price: props.estateObject.price || '',
    pets_allowed: props.estateObject.pets_allowed || 0,
    free_cleaning: props.estateObject.free_cleaning || 0,
    air_conditioner: props.estateObject.air_conditioner || 0,
    wifi: props.estateObject.wifi || 0,
    image: null,
    image_preview: props.estateObject.image_url || null,
})

const setRooms = (count) => {
    if (count === '+') {
        form.rooms_count++
    } else {
        form.rooms_count = count
    }
}

const setGuests = (count) => {
    if (count === '+') {
        form.guests_count++
    } else {
        form.guests_count = count
    }
}

const handleImageChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.image = file
        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
            form.image_preview = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const submitForm = () => {
    // Create FormData for file upload
    const formData = new FormData()
    
    // Append all form fields to FormData
    Object.keys(form).forEach(key => {
        if (key !== 'image_preview') {
            formData.append(key, form[key])
        }
    })

    router.post(`/admin/estate/${props.estateObject.id}`, formData, {
        preserveScroll: true,
        onSuccess: () => {
            // Handle success if needed
        },
        onError: (errors) => {
            // Handle errors if needed
        }
    })
}
</script>

<style scoped>
/* Add your styles here */
.content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.form-container {
    display: flex;
    gap: 20px;
}

.left-column, .right-column {
    flex: 1;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.button-group {
    display: flex;
    gap: 5px;
}

.button-group button {
    padding: 5px 10px;
    background: #eee;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.checkbox-group {
    list-style: none;
    padding: 0;
}

.checkbox-group li {
    margin-bottom: 5px;
}

.image-preview img {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
}

button[type="submit"] {
    background: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background: #45a049;
}
</style>