<template>
    <div>
        <div class="container login-form">
            <form method="post" action="">
                <div class="form-group">
                    <label for="exampleInputEmail1">邮箱</label>
                    <input type="email" v-model="email" class="form-control" id="exampleInputEmail1"
                           placeholder="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密码</label>
                    <input type="password" v-model="password" class="form-control" id="exampleInputPassword1"
                           placeholder="password">
                </div>
                <button type="button" class="btn btn-default btn-login" v-on:click="login()">登录</button>
                <div class="form-group forget-password">
                    <a href="#">忘记密码？</a>
                </div>
            </form>
        </div>
        <div class="container-fluid login-info">
            <div class="alert alert-danger" v-show="showError" role="alert">{{ error }}</div>
        </div>
    </div>
</template>
<script>
</script>
<script>
    export default {
        props: ['data'],
        data(){
            return {
                email: '',
                password: '',
                error: '',
                showError: false,
            }
        },
        methods: {
            login: function () {
                if (this.email == '') {
                    alert('邮箱不能为空');
                    return;
                }
                if (this.password == '') {
                    alert('密码不能为空');
                    return;
                }
                this.$http.post('login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    if (response.body.status_code == 200) {
                        window.location.href = 'http://localhost/restaurant/public/admin';
                    } else {
                        this.error = response.body.message;
                        this.showError = true;
                    }
                }, response => {
                    this.error = '网络出错';
                    this.showError = true;
                });
            }
        },
    }
</script>