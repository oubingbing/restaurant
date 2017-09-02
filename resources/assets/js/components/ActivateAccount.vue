<template>
    <div class="employee vue-container">

        <div class="create-container activate-container">
            <div class="create-employee-title"><h4 class="activate-title">激活账号</h4></div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>姓名</label>
                        <input type="text" v-model="username" required class="form-control" placeholder="员工姓名">
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input readonly type="email" v-model="email" class="form-control" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <div>
                            <input type="password" v-model="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>确认密码</label>
                        <div>
                            <input type="password" v-model="confirmation" class="form-control"
                                   placeholder="Password confirmation">
                        </div>
                    </div>
                    <button type="button" v-on:click="createEmployee"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">提交</button>
                </form>
            </div>
        </div>
        <div class="container-fluid login-info">
            <div class="alert alert-danger error" v-show="showError"  role="alert">{{ error }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['email','token'],
        mounted() {
            console.log(this.token);
        },
        data(){
            return{
                showError:false,
                error:null,
                username:null,
                password:null,
                confirmation:null
            }
        },
        methods: {
            showCreateView:function () {
                this.isHidden=false;
            },
            close:function () {
                this.isHidden = true;
                this.showError = false;
            },
            createEmployee(){
                this.$http.post(this.configs.default.url+'auth/activate/'+this.token,{
                    username:this.username,
                    email:this.email,
                    password:this.password,
                    password_confirmation:this.confirmation,
                }).then(response => {
                    if(response.body.status_code == 200){
                        this.error = response.body.message;
                    }else{
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