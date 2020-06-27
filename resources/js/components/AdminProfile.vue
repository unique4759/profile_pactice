<template>
    <div>
        <h1 class="text-center m-0 mt-3">
            Редактировать профиль <span class="text-success">{{ name }}</span>
        </h1>
        <div class="d-flex no-gutters my-3 p-3 bg-white border rounded">
            <div class="d-flex flex-column profile-img col">
                <img v-if="!image" src="../../images/non.png" alt="Profile image"
                     class="mb-3 align-self-center rounded-circle">
                <img v-else :src="image" alt="Profile image" class="mb-3 align-self-center rounded-circle">
                <label for="image" class="d-none">Изображение</label>
                <input type="file"
                       id="image"
                       name="image"
                       @change="onFileChange"
                       accept="image/*"
                       class="align-self-center w-75">
            </div>
            <div class="profile-info col">
                <label for="name" class="d-none">Имя</label>
                <input type="text"
                       id="name"
                       class="form-control mb-2"
                       placeholder="Имя*"
                       name="name"
                       v-model="name">
                <label for="phone" class="d-none">Телефон</label>
                <input type="text"
                       id="phone"
                       class="form-control mb-2"
                       placeholder="Телефон*"
                       name="phone"
                       v-model="phone">
                <label for="email" class="d-none">Email</label>
                <input type="text"
                       id="email"
                       class="form-control mb-2"
                       placeholder="Email*"
                       name="email"
                       v-model="email">
                <label for="password" class="d-none">Новый пароль</label>
                <input type="password"
                       id="password"
                       class="form-control mb-2"
                       placeholder="Новый пароль"
                       name="password"
                       v-model="password">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success btn-sm" @click="save">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "admin-profile",
        props: {
            user: {
                required: true
            }
        },
        data() {
            return {
                id: null,
                name: '',
                phone: '',
                email: '',
                password: '',
                image: '',
            }
        },
        methods: {
            setData(data) {
                this.id = data['id'];
                this.name = data['name'];
                this.phone = data['phone'];
                this.email = data['email'];
                this.image = data['image'] ? data['image'] : '';
            },
            onFileChange(e) {
                let image = e.target.files[0];
                this.read(image);
            },
            read(img) {
                let reader = new FileReader();

                reader.readAsDataURL(img);
                reader.onload = e => {
                    this.image = e.target.result;
                };
            },
            save() {
                axios.post('/profile/update', {
                    name: this.name,
                    phone: this.phone,
                    email: this.email,
                    password: this.password,
                    image: this.image,
                }).then(res => {
                    this.setData(res.data);

                    swal.fire({
                        type: 'success',
                        title: 'Профиль обновлен',
                        showCancelButton: false,
                        confirmButtonText: 'Отлично',
                    });
                }).catch(rej => console.log(rej));
            },
        },
        mounted() {
            this.setData(this.user);
        }
    }
</script>

<style>
    .profile-img img {
        width: 160px;
        height: 160px;
    }
</style>
