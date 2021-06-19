<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <br><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_Z2qinxroGkYYxNyHLYfOaPz70tqc983uvMVooyD4NaM_YcL5xmyIZY9WwABiI15FaC4&usqp=CAU">
            <br><span class="text-secondary">Smart School</span>
        </div>

        <nav class="navbar navbar-expand-sm navbar navbar-light" style="background-color: #e3f2fd;">

            <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0"></div>
            <div class="navbar-collapse order-0 order-md-1 position-relative">

                <ul class="navbar-nav mr-auto text-center" v-if="isLoggedIn">
                    <li class="nav-item"><router-link to="/dashboard" class="nav-link">Dashboard</router-link></li>
                    <li class="nav-item"><router-link to="/users" class="nav-link">Users</router-link></li>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                </ul>

                <ul class="navbar-nav mr-auto text-center" v-else>
                    <li class="nav-item"><router-link to="/" class="nav-link">Home</router-link></li>
                    <li class="nav-item"><router-link to="/login" class="nav-link">login</router-link></li>
                    <li class="nav-item"><router-link to="/register" class="nav-link">Register</router-link></li>
                    <li class="nav-item"><router-link to="/about" class="nav-link">About</router-link></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse w-100 dual-collapse2 order-2 order-md-2"></div>
        </nav>

        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>