<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <img class="mx-auto h-10 w-auto" src="../../public/images/299326.png" alt="Your Company">

        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">My Jobs - Enter</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input v-model="email" id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="password" id="password" name="password" type="password"
                            autocomplete="current-password" required
                            class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-sm">
                        <RouterLink to="/register" class="font-semibold text-indigo-600 hover:text-indigo-500">Register?
                        </RouterLink>
                    </div>
                </div>

                <div>
                    <button id="send" type="button" v-on:click="login()"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enter</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { login } from '../Operations';
export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        async login() {
            try {
                
                let btn = document.getElementById('send');
                btn.disabled = true;

                let token = await login(this.email, this.password);
                sessionStorage.setItem('token', token);
                this.$router.push('/home');

            } catch (error) {

                if (error.response && error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('Error logging in. Please check your credentials and try again.');
                }

                btn.disabled = false;
            }
        }
    }
}
</script>