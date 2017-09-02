<template>
    <div class="sign-container">
        <mt-navbar fixed v-model="selected" class="mt-navbar">
            <mt-tab-item id="1" class="navbar-item">签到</mt-tab-item>
            <mt-tab-item id="2" class="navbar-item">签到详情</mt-tab-item>
            <mt-tab-item id="3" class="navbar-item">我的排班</mt-tab-item>
            <mt-tab-item id="4" class="navbar-item">门店排班</mt-tab-item>
        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="selected" class="mt-tab-container">
            <mt-tab-container-item id="1">
                <div class="sign-content" v-bind:style="{height:window_height}">
                    <div class="sign-icon">
                        <div>
                            <img src="/image/zhiwen.png" v-on:click="doSign" alt="" v-bind:style="{transform:change_transform}">
                        </div>
                    </div>
                    <div class="sign-detail">
                        <div class="detail-item"><span>两个小时</span><span>合计：20元</span></div>
                        <div class="detail-item"><p>签到时间：2017-8-30 12:30:45</p></div>
                    </div>

                    <div class="assign-container">
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                        <div class="assign-employee">
                            <p>早班</p>
                            <p>欧志兵</p>
                        </div>
                    </div>
                </div>
            </mt-tab-container-item>
            <mt-tab-container-item id="2">
                <ul>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                </ul>
            </mt-tab-container-item>
            <mt-tab-container-item id="3">
                <ul>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                </ul>
            </mt-tab-container-item>
            <mt-tab-container-item id="4">
                <ul>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                    <li>321322</li>
                </ul>
            </mt-tab-container-item>
        </mt-tab-container>

        <mt-tabbar fixed v-model="selected">
            <mt-tab-item id="sign">
                <img slot="icon" src="/image/active-sign.png">
                签到
            </mt-tab-item>
            <mt-tab-item id="take_out_food">
                <img slot="icon" src="/image/waimai.png">
                外卖
            </mt-tab-item>
            <mt-tab-item id="purchase" @click.native="dumpPurchase">
                <img slot="icon" src="/image/purchase.png">
                采购
            </mt-tab-item>
            <mt-tab-item id="account">
                <img slot="icon" src="/image/account.png">
                财务
            </mt-tab-item>
            <mt-tab-item id="me">
                <img slot="icon" src="/image/me.png">
                我的
            </mt-tab-item>
        </mt-tabbar>
    </div>
</template>

<script>
    var window_height = window.screen.availHeight;
    import { Indicator } from 'mint-ui';

    export default {
        props: ['data'],
        mounted() {
            console.log('Component mounted.');
        },
        data(){
          return {
              selected:true,
              change_transform:null,
              window_height:window_height-100+'px',
          }
        },
        methods: {
            doSign:function () {
                Indicator.open();
                var _this = this;

                this.$http.patch('/mobile/sign', {}).then(response => {
                    Indicator.close();
                    if (response.body.status_code == 200) {
                        _this.$toast({
                            message: response.body.message,
                            position:'middle'
                        });
                    } else {
                        this.$toast({
                            message:response.body.message,
                            position:'middle'
                        });
                    }
                }, response => {
                    Indicator.close();
                    this.$toast({
                        message:'网络出错',
                        position:'bottom'
                    });
                });
            },
            dumpPurchase:function () {
                window.location.href = '/mobile/purchase';
                console.log(123);
            }
        },
    }
</script>