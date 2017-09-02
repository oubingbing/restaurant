<template>
    <div class="purchase-container">
        <mt-navbar fixed v-model="selected" class="mt-navbar">
            <mt-tab-item id="1" class="navbar-item">当日采购</mt-tab-item>
            <mt-tab-item id="2" class="navbar-item">材料</mt-tab-item>
            <mt-tab-item id="3" class="navbar-item">我的采购</mt-tab-item>
            <mt-tab-item id="4" class="navbar-item">采购记录</mt-tab-item>
        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="selected" class="mt-tab-container">
            <mt-tab-container-item id="1">

            </mt-tab-container-item>
            <mt-tab-container-item id="2">
                <div class="total-materials">
                    <div class="material-item" v-for="material in materials">
                        <div class="material-info">
                            <span>{{ material.name }}</span>
                            <span>价格:{{ material.price }}/￥</span>
                        </div>
                        <div class="purchase-material">
                            <div>
                                <input type="text" class="purchase-input" placeholder="请输入购买单位数量">
                                <span>/{{ material.unit }}</span>
                            </div>
                            <div>
                                <button>采购</button>
                            </div>
                        </div>
                    </div>

                </div>
            </mt-tab-container-item>
            <mt-tab-container-item id="3">
                <div class="my-purchase-materials">
                    <div class="material-item" v-for="material in materials">
                        <div class="material-info">
                            <div class="material-info-header">
                                <span>{{ material.name }}</span>
                                <small>单价:{{ material.price }}/￥</small>
                            </div>
                            <div class="material-info-footer">
                                <small>数量:{{ material.price }}/{{ material.unit }}</small>
                                <small>总金额:{{ material.price }}/￥</small>
                            </div>
                            <div class="order-time">
                                <small>下单时间</small>
                                <small>2017-8-30 14:56:45</small>
                            </div>
                        </div>
                        <div class="purchase-material">
                            <div>
                                <input type="text" class="purchase-input" placeholder="请输入修改数量">
                                <small>/{{ material.unit }}</small>
                            </div>
                            <div>
                                <button>修改</button>
                            </div>
                        </div>
                    </div>

                </div>
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
            <mt-tab-item id="sign" @click.native="dumpSign">
                <img slot="icon" src="/image/sign.png">
                签到
            </mt-tab-item>
            <mt-tab-item id="take_out_food">
                <img slot="icon" src="/image/waimai.png">
                外卖
            </mt-tab-item>
            <mt-tab-item id="purchase">
                <img slot="icon" src="/image/active-purchase.png">
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
        props: ['materials'],
        mounted() {
            console.log('Component mounted.');
            console.log(this.materials)
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
            dumpSign:function () {
                window.location.href = '/mobile/sign';
            },
            purchase:function (id) {
                console.log(id);
                event.currentTarget.src = '/image/active-car.png';
            }
        },
    }
</script>