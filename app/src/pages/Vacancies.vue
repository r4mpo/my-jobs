<template>
    <Sidenav></Sidenav>
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <div class="grid grid-cols-6 gap-4 mb-4">
                <div class="">
                    <label for="long_description" class="block text-sm font-medium leading-6 text-gray-900">Long
                        Description</label>
                    <input id="long_description" name="long_description" type="text" autocomplete="long_description"
                        class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="">
                    <label for="short_description" class="block text-sm font-medium leading-6 text-gray-900">Short
                        Description</label>
                    <input id="short_description" name="short_description" type="text" autocomplete="short_description"
                        class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="">
                    <label for="zip_code" class="block text-sm font-medium leading-6 text-gray-900">Zip Code</label>
                    <input id="zip_code" onkeyup="formatZipCode(this)" name="zip_code" type="text"
                        autocomplete="zip_code"
                        class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="">
                    <label for="wage" class="block text-sm font-medium leading-6 text-gray-900">Wage</label>
                    <input id="wage" onkeyup="formatCurrency(this)" name="wage" type="text" autocomplete="wage"
                        class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="">
                    <label for="amount_page" class="block text-sm font-medium leading-6 text-gray-900">Amount
                        Page</label>
                    <input id="amount_page" onkeyup="allowOnlyNumbers(this)" name="amount_page" type="text"
                        autocomplete="amount_page"
                        class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="">
                    <button v-on:click="getVacancies()"
                        class="block mt-5 p-3 text-white rounded-md rounded-md bg-indigo-600" type="button"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <div v-for="vacancy in vacancies"
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                        vacancy.short_description }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ vacancy.long_description }}</p>
                    <p class="font-normal text-green-700 dark:text-green-400">{{ vacancy.wage }}</p>
                    <p class="mb-3 font-normal text-orange-700 dark:text-orange-400">{{ vacancy.zip_code }}</p>
                    <a href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Read more
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Sidenav from "../components/Sidenav.vue";

export default {
    name: 'Vacancies',
    components: {
        Sidenav
    },
    data() {
        return {
            vacancies: [],
        }
    },
    methods: {
        getVacancies(page = 1) {

            let data = {
                'wage': document.getElementById('wage').value.replace(/\D/g, ''),
                'zip_code': document.getElementById('zip_code').value.replace(/\D/g, ''),
                'amount_page': document.getElementById('amount_page').value,
                'long_description': document.getElementById('long_description').value,
                'short_description': document.getElementById('short_description').value
            }

            let params = '?page=' + page;

            if (data.amount_page != '') {
                params = params + '&amount_page=' + encodeURIComponent(data.amount_page);
            }

            if (data.wage != '') {
                params = params + '&wage=' + encodeURIComponent(data.wage);
            }

            if (data.zip_code != '') {
                params = params + '&zip_code=' + encodeURIComponent(data.zip_code);
            }


            if (data.long_description != '') {
                params = params + '&long_description=' + encodeURIComponent(data.long_description);
            }

            if (data.short_description != '') {
                params = params + '&short_description=' + encodeURIComponent(data.short_description);
            }

            let config = {
                "headers": {
                    "Content-type": "application/json",
                    "Authorization": `Bearer ${sessionStorage.getItem('token')}`,
                }
            };

            axios.get(`http://127.0.0.1:8000/api/vacancies` + params, config)
                .then(response => {
                    this.vacancies = response.data.data;
                }).catch(error => {
                    console.error(error)
                });
        }
    }
}
</script>