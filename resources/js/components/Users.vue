<template>
    <div>
        <h4 class="text-center">All Users</h4><br/>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>School</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.schools.name }}</td>
                <td>{{ user.roles[0].name }}</td>
                <td>{{ format(user.created_at)}}</td>
                <td>{{ format(user.updated_at) }}</td>

                <td v-if="role=='schooladmin' || role=='superadmin'">
                    <div class="btn-group" role="group">
                        <!-- <router-link :to="{name: 'edituser', params: { id: user.id }}" class="btn btn-primary">Edit
                        </router-link> -->
                        <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
                    </div>
                </td>
                <td v-else>-</td>

            </tr>
            </tbody>
        </table>
        </div>
        <span v-if="role=='schooladmin' || role=='superadmin'">
            <button type="button" class="btn btn-primary" @click="this.$router.push('/users/add')">Add/Invite User</button>
        </span>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data() {
        return {
            users: []
        }
    },
    created() {
        // user role
        this.$axios.get('/api/users/0')
            .then(response => {
                const current_user = response.data;
                this.role = current_user.role;
                console.log(this.role);
            })
            .catch(function (error) {
                console.error(error);
            });

        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/users')
                .then(response => {
                    this.users = response.data;
                    console.log(this.users);
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {

        format(date) {
            return moment(date).format('YYYY-MM-DD HH:MM:SS');
        },

        deleteUser(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/users/delete/${id}`)
                    .then(response => {
                        let i = this.users.map(item => item.id).indexOf(id); // find index of your object
                        this.users.splice(i, 1)
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