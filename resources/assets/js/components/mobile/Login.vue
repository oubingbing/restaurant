<template>
    <div class="login-container" v-bind:style="{height:window_height}">
        <div class="title">
            <h2>welcome to login</h2>
        </div>
        <div class="form-container">
            <div class="login-input">
                <div class="label">
                    <img v-bind:src="email_image" class="email_image" alt="">
                </div>
                <div>
                    <input type="email" placeholder="请输入邮箱" v-model="email">
                </div>
            </div>
            <div class="login-input">
                <div class="label"><img v-bind:src="password_image" alt=""></div>
                <div>
                    <input type="password" placeholder="请输入密码" v-model="password">
                </div>
            </div>
            <div>
                <button class="login-button" v-on:click="login">登陆</button>
            </div>
            <div class="tips">
                <span>tips:账号需要激活才能登录</span>
            </div>
            <div class="create-user">
                <span>power by 叶子</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { Indicator } from 'mint-ui';
    var window_height = window.screen.availHeight;
    export default {
        props: ['data'],
        mounted() {
            console.log('Component mounted.');
            console.log(window_height+'px');
        },
        data(){
          return {
              window_height:window_height+'px',
              email_image:'/image/email.png',
              password_image:'/image/password.png',
              email:null,
              password:null
          }
        },
        methods: {
            login:function () {
                if (this.email == null){
                    this.$toast({
                        message: '邮箱不能为空',
                        position:'bottom'
                    });
                    return;
                }

                if (this.password == null){
                    this.$toast({
                        message: '密码不能为空',
                        position:'bottom'
                    });
                    return;
                }

                Indicator.open('登录中...');

                this.$http.post('/auth/login', {
                    email: this.email,
                    password: this.password,
                    type:'mobile'
                }).then(response => {
                    Indicator.close();
                    if (response.body.status_code == 200) {
                        Indicator.open(response.body.message+',跳转中...');
                        window.location.href = '/mobile/sign';
                    } else {
                        this.$toast({
                            message:response.body.message,
                            position:'bottom'
                        });
                    }
                }, response => {
                    Indicator.close();
                    this.error = '网络出错';
                    this.showError = true;
                });

            }
        },
    }
</script>