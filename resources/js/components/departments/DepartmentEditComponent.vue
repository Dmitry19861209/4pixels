<template>
    <div>
        <div class="card">
            <div class="card-header">Departments edit</div>
            <div class="card-body">
                <form id="departmentEditForm"
                      enctype="multipart/form-data"
                      @submit="checkForm"
                      :action="'/departments/' + department.id"
                      method="post">
                    <input type="hidden" name="_token" id="csrf-token" :value="propToken">
                    <div v-if="errors.length">
                        <b>Исправьте указанные ошибки:</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"
                               class="form-control"
                               id="name" name="name"
                               v-model="department.name"
                               placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control"
                                  id="description" name="description"
                                  v-model="department.description"
                                  autocomplete="off"
                                  placeholder="Enter description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input"
                                       name="logo"
                                       id="inputGroupFile01"
                                       aria-describedby="inputGroupFileAddon01"
                                       v-on:change="onImageChange">
                                <label class="custom-file-label"
                                       for="inputGroupFile01">{{ department.logo || 'Choose file' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div v-for="user in users">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       :checked="userIsChecked(user.id)"
                                       v-on:change="checkUser"
                                       :value="user.id">
                                <label class="form-check-label">
                                    {{ user.name }}
                                    (<a :href="'/users/' + user.id + '/edit'">{{ user.email }}</a>)
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['propDepartmentId', 'propToken'],
        data: function () {
            return {
                users: {},
                errors: [],
                department: {},
                logoLabel: 'Choose file',
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
            axios.post('/department-by-id/' + this.propDepartmentId)
                .then(function (resp) {
                    app.department = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить отдел");
                });
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.logoLabel = files[0].name;
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.department.name) {
                    this.errors.push('Укажите имя.');
                }

                if (!this.department.description) {
                    this.errors.push('Укажите description.');
                }

                if (!this.errors.length) {
                    return true;
                }

                e.preventDefault();
            },
            userIsChecked: function(userId) {
                const isChecked = this.department && this.department.users &&
                    this.department.users.find(user => user.id === userId);
                return !!isChecked;
            },
            checkUser: function(e) {
                axios.post('/check-user', {
                    userId: e.target.value,
                    departmentId: this.department.id,
                    state: e.target.checked,
                })
                    .then(function (resp) {
                        app.department = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось назначить пользователя в отдел.");
                    });
            }
        }
    }
</script>
