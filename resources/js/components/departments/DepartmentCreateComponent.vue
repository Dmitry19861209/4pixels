<template>
    <div>
        <div class="card">
            <div class="card-header">Departments crate</div>
            <div class="card-body">
                <form id="departmentCreateForm"
                      enctype="multipart/form-data"
                      @submit="checkForm"
                      action="/departments"
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
                               v-model="name"
                               placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control"
                                  id="description" name="description"
                                  v-model="description"
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
                                       for="inputGroupFile01">{{ logoLabel }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div v-for="user in users">
                            <div class="form-check">
                                <input class="form-check-input"
                                       name="users[]"
                                       type="checkbox"
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
        props: ['propToken'],
        data: function () {
            return {
                users: {},
                errors: [],
                name: null,
                description: null,
                logo: null,
                logoLabel: 'Choose file'
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
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.logoLabel = files[0].name;
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.name) {
                    this.errors.push('Укажите имя.');
                }

                if (!this.description) {
                    this.errors.push('Укажите description.');
                }

                if (!this.errors.length) {
                    return true;
                }

                e.preventDefault();
            },
        }
    }
</script>
