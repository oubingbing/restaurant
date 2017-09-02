<template>
    <div class="container-fluid container-dashboard vue-container">
        <div class="dashboard-slider col-md-2">
            <div class="slider slider-employee">
                <div class="hide-item">员工</div>
                <div><a :href="employeeUrl"><i class="el-icon-d-arrow-right"></i> 员工</a></div>
                <div class="hide-item">员工</div>
            </div>
            <div class="slider slider-material">
                <div class="hide-item">材料</div>
                <div><a :href="materialUrl"><i class="el-icon-d-arrow-right"></i> 材料</a></div>
                <div class="hide-item">材料</div>
            </div>
            <div class="slider slider-sale">
                <div class="hide-item">外卖</div>
                <div><i class="el-icon-d-arrow-right"></i> 外卖</div>
                <div class="hide-item">外卖</div>
            </div>
            <div class="slider slider-account">
                <div class="hide-item">财务</div>
                <div><i class="el-icon-d-arrow-right"></i> 财务</div>
                <div class="hide-item">财务</div>
            </div>
        </div>
        <div class="sub-item dashboard-main col-md-8">
            <div class="main-item col-md-5">
                <div class="title-container"><h4 class="item-title">今日排班和签到</h4></div>
                <div class="main-item-content">
                    <ul class="list-group">
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                        <li>1111111111</li>
                    </ul>
                </div>
            </div>
            <div class="main-item col-md-5">
                <div class="title-container"><h4 class="item-title">今日采购</h4></div>
            </div>
            <div class="main-item col-md-5">
                <div class="title-container"><h4 class="item-title">今日外卖</h4></div>
            </div>
            <div class="main-item col-md-5">
                <div class="title-container"><h4 class="item-title">今日财务</h4></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        mounted() {
            console.log('dashboard')
        },
        data(){
          return{
              employeeUrl : this.configs.default.url+'admin/employee',
              materialUrl: this.configs.default.url+'admin/material'
          }
        },
        methods: {},
    }
</script>