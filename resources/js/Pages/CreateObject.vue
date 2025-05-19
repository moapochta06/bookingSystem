 <template>
    <Layout>
        <div class="content">
            <h1>Создание объекта</h1>

             <div v-if="$page.props.flash?.success" class="bg-green-100 text-green-800 p-4 mb-4">
             {{ $page.props.flash.success }}
            </div>

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
                            <input @input="form.image = $event.target.files[0]" type="file" id="image" name="image">
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
                                    <input v-model="form.pets_allowed" type="checkbox" id="pets_allowed" name="pets_allowed">
                                    <label for="pets_allowed">Можно с животными</label>
                                </li>
                                <li>
                                    <input v-model="form.free_cleaning" type="checkbox" id="free_cleaning" name="free_cleaning">
                                    <label for="free_cleaning">Бесплатная уборка</label>
                                </li>
                                <li>
                                    <input v-model="form.air_conditioner" type="checkbox" id="air_conditioner" name="air_conditioner">
                                    <label for="air_conditioner">Кондиционер</label>
                                </li>
                                <li>
                                    <input v-model="form.wifi" type="checkbox" id="wifi" name="wifi">
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
import { reactive } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
const page = usePage();

document.title = page.props.title;

const estateObject = page.props.estateObject || null
const form = reactive({
    title: '',
    city: '',
    street: '',
    house_number: null,
    apartment_number: null,
    rooms_count: null,
    guests_count: null,
    area: null,
    price: null,
    description: '',
    image: null,
    pets_allowed: false,
    free_cleaning: false,
    air_conditioner: false,
    wifi: false,
})

function setRooms(value) {
    if (value !== '+') form.rooms_count = value
}

function setGuests(value) {
    if (value !== '+') form.guests_count = value
}

function submitForm() {
    const data = new FormData()
    for (const key in form) {
        data.append(key, form[key])
    }

    router.post('/create-object', data, {
        forceFormData: true,
        onSuccess: () => alert('Объект успешно создан!'),
        onError: (errors) => console.error(errors),
    })
}
</script>
<style scoped>
    h1 {
        font-weight: 500;
        margin-top: 65px;
    }

            .form-container {
            display: flex;
            gap: 40px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #e0e0e0;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #d0d0d0;
        }
        .form-group .checkbox-group {
            list-style-type: none;
            padding: 0;
        }
        .form-group .checkbox-group li {
            margin-bottom: 5px;
        }
        .form-group .checkbox-group label {
            display: inline-block;
            margin-right: 10px;
        }
        .form-group .checkbox-group input[type="checkbox"] {
            margin-right: 5px;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .button-group button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button-group button:hover {
            background-color: #0056b3;
        }
</style>
