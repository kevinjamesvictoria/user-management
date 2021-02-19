<template>
    <div>
        <h3 class="text-center">Create User</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="user.name">
                        <span v-if="!$v.user.name.required && $v.user.name.$dirty" class="text-danger">Name is required!</span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="user.email">
                        <span
                                v-if="(!$v.user.email.required || !$v.user.email.email) && $v.user.email.$dirty"
                                class="text-danger"
                        >Valid Email is required!</span>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" v-mask="'(###) ###-####'" v-model="user.phone_number">
                        <span
                                v-if="(!$v.user.phone_number.required) && $v.user.phone_number.$dirty"
                                class="text-danger"
                        >Phone number is required!</span>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" v-model="user.address">
                        <span
                                v-if="(!$v.user.address.required) && $v.user.address.$dirty"
                                class="text-danger"
                        >Address is required!</span>
                    </div>
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" v-mask="'#####'" v-model="user.zip_code">
                        <span
                                v-if="(!$v.user.zip_code.required) && $v.user.zip_code.$dirty"
                                class="text-danger"
                        >Zip code is required!</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        required,
        minLength,
        maxLength,
        alpha,
        email,
        numeric
    } from "vuelidate/lib/validators";
    export default {
        data() {
            return {
                user: {}
            }
        },
        validations: {
            user: {
                name: {
                    required
                },
                email: {
                    required,
                    email
                },
                phone_number:{
                    required,
                },
                address: {
                    required
                },
                zip_code: {
                    required,
                }
            }
        },
        methods: {
            addUser() {
                console.log(this.$v)
                this.$v.$touch();
                if (!this.$v.$invalid){
                    this.axios
                        .post('http://user-management.local/api/users', this.user)
                        .then(response => (
                            this.$router.push({ name: 'home' })
                        ))
                        .catch(err => console.log(err))
                        .finally(() => this.loading = false)
                }
            },
        }
    }
</script>