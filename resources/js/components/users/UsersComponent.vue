<template>
    <div>
        <div class="form-group">
            <a href="/users/create"
               class="btn btn-success">Create new user</a>
        </div>

        <div class="card">
            <div class="card-header">Users list</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created date</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user, index in users">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.created_at }}</td>
                        <td class="td-buttons">
                            <a :href="'/users/' + user.id + '/edit'"
                               class="btn btn-info">Edit
                            </a>
                            <a href="#"
                               class="btn btn-danger"
                               v-on:click="deleteEntry(user.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                users: []
            }
        },
        mounted() {
            var app = this;
            axios.post('/users-all')
                .then(function (resp) {
                    app.users = resp.data;
                })
                .catch(function (resp) {
                    alert("Не удалось загрузить пользователей");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы действительно хотите удалить пользователя?")) {
                    var app = this;
                    axios.delete('/users/' + id)
                        .then(function (resp) {
                            app.users.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить пользователя");
                        });
                }
            }
        }
    }
</script>
