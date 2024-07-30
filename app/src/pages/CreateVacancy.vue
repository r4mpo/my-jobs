<template>
    <Sidenav></Sidenav>
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <form class="max-w-md mx-auto">

                <h3 class="text-5xl font-extrabold">Register your new vacancy easily !!!</h3>
                
                <hr class="mb-5">

                <div class="grid gap-4 grid-cols-3 mb-5">
                    <div>
                        <label for="short_description" class="block mb-2 text-sm font-medium text-gray-900">Short
                            description</label>
                        <input v-model="vacancy.short_description" type="text" id="short_description"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Institutional website development" required />
                    </div>

                    <div>
                        <label for="zip_code" class="block mb-2 text-sm font-medium text-gray-900">Zip Code</label>
                        <input onkeyup="formatZipCode(this)" v-model="vacancy.zip_code" type="text" id="zip_code"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="14010-035" required />
                    </div>

                    <div>
                        <label for="wage" class="block mb-2 text-sm font-medium text-gray-900">Wage</label>
                        <input onkeyup="formatCurrency(this)" v-model="vacancy.wage" type="text" id="wage"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="R$1.500,00" required />
                    </div>
                </div>

                <div class="mb-5">
                    <label for="long_description" class="block mb-2 text-sm font-medium text-gray-900">Long
                        description</label>
                    <textarea v-model="vacancy.long_description" id="long_description"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="We need a developer to create a responsive institutional website using HTML, CSS and JavaScript. Must be delivered within 2 weeks."
                        required></textarea>
                </div>

                <button type="button" v-on:click="createVacancy()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>

            </form>
        </div>
    </div>
</template>

<script>
import Sidenav from "../components/Sidenav.vue";
import { postData } from "../Operations";

export default {
    name: 'CreateVacancy',
    components: {
        Sidenav
    },
    data() {
        return {
            vacancy: {
                short_description: '',
                long_description: '',
                wage: '',
                zip_code: '',
            }
        }
    },
    methods: {
        async createVacancy() 
        {
            let url = 'vacancies';

            let data = {
                short_description: this.vacancy.short_description,
                long_description: this.vacancy.long_description,
                zip_code: this.vacancy.zip_code.replace(/\D/g, ''),
                wage: parseInt(this.vacancy.wage.replace(/\D/g, '')),
            }

            try {

                let create = await postData(url, data);

                if(create.message != undefined){
                    alert(create.message)
                }

                if(create.data != undefined){
                    this.$router.push('/vacancies');
                }

            } catch (error) {
                console.error(error);
                alert('error when creating');
            }
        }
    }
}
</script>