<template>
    <Sidenav></Sidenav>
</template>

<script>
import axios from "axios";
import Sidenav from "../components/Sidenav.vue";

export default {
    name: 'Home',
    components: {
        Sidenav
    },
    data() {
        return {
            vacancies: [],
        }
    },
    methods: {
        getVacancies() {

            let data = {
                'wage': document.getElementById('wage').value,
                'zip_code': document.getElementById('zip_code').value,
                'amount_page': document.getElementById('amount_page').value,
                'long_description': document.getElementById('long_description').value,
                'short_description': document.getElementById('short_description').value
            }

            let params = '';

            if (data.amount_page != '') {
                params = params + '?amount_page=' + encodeURIComponent(data.amount_page);
            } else {
                params = params + '?amount_page=' + 5;
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