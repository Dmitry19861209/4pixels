<template>
    <div>
        <div class="card">
            <div class="card-header">Users edit</div>
            <div class="card-body">
                <form id="userCreateForm"
                      @submit="checkForm"
                      action="/users"
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
                        <label for="email">E-mail</label>
                        <input type="email"
                               class="form-control"
                               id="email" name="email"
                               v-model="email"
                               autocomplete="off"
                               placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                               class="form-control"
                               id="password" name="password"
                               v-model="password"
                               autocomplete="off"
                               placeholder="Password">
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
                errors: [],
                name: null,
                email: null,
                password: null
            }
        },
        mounted() {

        },
        methods: {
            checkForm: function (e) {
                this.errors = [];

                if (!this.name) {
                    this.errors.push('Укажите имя.');
                }
                if (!this.email) {
                    this.errors.push('Укажите электронную почту.');
                } else if (!this.validEmail(this.email)) {
                    this.errors.push('Укажите корректный адрес электронной почты.');
                }

                if (!this.errors.length) {
                    return true;
                }

                e.preventDefault();
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>
