<template>
    <div>
        <h2 class="text-center">Users List</h2>

        <table class="table table-dar table-striped table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Address</th>
                <th>Zip Code</th>
                <th>Files</th>
                <th>Action</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone_number }}</td>
                <td>{{ user.address }}</td>
                <td>{{ user.zip_code }}</td>
                <td>
                    <a v-for="userFiles in user.user_files" href="#" @click.prevent="handleDownload(userFiles.id, userFiles.filename)">
                        {{ userFiles.filename }}
                    </a>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'upload', params: { id: user.id }}" class="btn btn-primary">Upload Files</router-link>
                        <router-link :to="{name: 'edit', params: { id: user.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
            }
        },
        created() {
            this.axios
                .get('http://user-management.local/api/users/')
                .then(response => {
                    this.users = response.data;
                });
        },
        methods: {
            deleteUser(id) {
                this.axios
                    .delete(`http://user-management.local/api/users/${id}`)
                    .then(response => {
                        let i = this.users.map(data => data.id).indexOf(id);
                        this.users.splice(i, 1)
                    });
            },
            handleDownload(id, filename){
                this.axios
                    .get(`http://user-management.local/api/users/files/download/${id}`)
                    .then((res) => {
                        window.open(`http://user-management.local/api/users/files/download/${id}`, '_blank')
                    });
            }
        }
    }
</script>