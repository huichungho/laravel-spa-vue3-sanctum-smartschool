<template>
    <div>
        <h4 class="text-center">Add User</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="user.email">
                    </div>
                    <div class="form-group">
                        <label>School</label>
                        <br><select required v-model="user.school_id">
                            <option :value="null">Select</option>
                            <option v-for="school in schools" :value="school.id" :key="school.id">{{ school.name }}</option>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Are you a?</label>
                        <br><input type="radio" v-model="user.role" value="teacher"> <label>Teacher</label>
                        <br><input type="radio" v-model="user.role" value="student"> <label>Student</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                school_id: null,
                role: 'Teacher'
            },
            schools: []
        }
    },
    created() {
        // school
        this.$axios.get('/api/schools/0')
            .then(response => {
                const current_user = response.data;
                this.schools = current_user.schools;
                console.log(this.schools);
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    methods: {
        addUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/users/add', this.user)
                    .then(response => {
                        this.$router.push({name: 'users'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>