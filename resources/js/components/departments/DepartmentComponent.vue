<template>
    <div>
        <div class="form-group">
            <a href="/departments/create"
               class="btn btn-success">Create new department</a>
        </div>

        <div class="card">
            <div class="card-header">Departments list</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Users</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="department, index in departments">
                        <td><img :src="'/storage/logo/' + department.logo"
                                 alt=""
                                 height="70px"></td>
                        <td>
                            <p class="td-name">{{ department.name }}</p>
                            <p class="td-description">{{ department.description }}</p>
                        </td>
                        <td>
                            <p v-for="user in department.users">{{ `${user.id}. ${user.name}` }}</p>
                        </td>
                        <td class="td-buttons">
                            <a :href="'/departments/' + department.id + '/edit'"
                               class="btn btn-info">Edit
                            </a>
                            <a href="#"
                               class="btn btn-danger"
                               v-on:click="deleteEntry(department.id, index)">
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
                departments: []
            }
        },
        mounted() {
            var app = this;
            axios.post('/departments-all')
                .then(function (resp) {
                    app.departments = resp.data;
                })
                .catch(function (resp) {
                    alert("Не удалось загрузить отделы");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы действительно хотите удалить отдел?")) {
                    var app = this;
                    axios.delete('/departments/' + id)
                        .then(function (resp) {
                            app.departments.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить отдел");
                        });
                }
            }
        }
    }
</script>
