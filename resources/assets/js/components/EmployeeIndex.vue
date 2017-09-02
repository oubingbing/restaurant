
<template>
    <div class="employee vue-container">
        <div class="employee-manager col-md-2">
            <div class="manager-item" v-on:click="showCreateView"><i class="el-icon-plus"></i> 添加员工</div>
            <div class="manager-item" v-on:click="createSheetView"><i class="el-icon-plus"></i> 排班表</div>
            <div class="manager-item" v-on:click="employeeAssignView"><i class="el-icon-plus"></i> 员工排班</div>
            <div class="manager-item"><a v-bind:href="adminUrl">返回</a></div>
        </div>

        <div id="employee-container" class="col-md-10">

            <el-tabs type="border-card">
                <el-tab-pane label="员工列表">
                    <div style="height: 800px">
                        <div class="employee-item" v-for="value in employeeList">
                            <div class="item-content col-md-3">
                                <div class="avatar">
                                    <img v-bind:src="img_url" alt="">
                                    <div class="profile">
                                        <div><small>{{ value.username }}</small></div>
                                        <div><small>女</small></div>
                                        <div><small>店长</small></div>
                                    </div>
                                </div>
                                <div class="des">
                                    <span>这是一个勤劳的员工，我们的激情岁月，我们的青春</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="排班表">排班表</el-tab-pane>
                <el-tab-pane label="员工排班表">员工排班表</el-tab-pane>
                <el-tab-pane label="签到列表">签到列表</el-tab-pane>
            </el-tabs>
        </div>

        <div class="create-container" v-bind:class="{ 'hidden':isHidden }">
            <div class="create-employee-title"><h4>添加员工</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>姓名 (必填)</label>
                        <input type="text" v-model="name" required class="form-control" placeholder="员工姓名">
                    </div>
                    <div class="form-group">
                        <label>邮箱 (必填)</label>
                        <input type="email" v-model="email" class="form-control" placeholder="email">
                    </div>
                    <button type="button" v-on:click="createEmployee"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
                <div class="create-employee-tips"><span>温馨提示：员工需要登录邮箱激活账号</span></div>
            </div>
        </div>

        <div class="create-container sheet" v-bind:class="{ 'hidden':isHiddenSheet }">
            <div class="create-employee-title" style="margin-left: 6px"><h4>新建排班</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="sheet-form-container">
                        <div class="sheet-left col-md-6">
                            <div class="form-group">
                                <label>排班名称 (必填)</label>
                                <input type="text" v-model="sheetData.name" required class="form-control" placeholder="排班名称">
                            </div>
                            <div class="form-group">
                                <label>开始日期 (必填)</label>
                                <calendar @listenDateSelect="listenStartDate"></calendar>
                            </div>
                            <div class="form-group">
                                <label>截止日期 (必填)</label>
                                <calendar @listenDateSelect="listenEndDate"></calendar>
                            </div>
                            <div class="form-group">
                                <label>上班时间 (必填)</label>
                                <el-time-select
                                        v-model="start_time"
                                        :picker-options="{start: '08:30',step: '00:15',end: '18:30'}"
                                        placeholder="选择时间">
                                </el-time-select>
                                <!--<input type="text" class="form-control" v-model="sheetData.start_time" placeholder="8:30">-->
                            </div>
                            <div class="form-group">
                                <label>下班时间 (必填)</label>
                                <el-time-select
                                        v-model="end_time"
                                        :picker-options="{start: '08:30',step: '00:15',end: '18:30'}"
                                        placeholder="选择时间">
                                </el-time-select>
                                <!--<input type="text" class="form-control" v-model="sheetData.end_time" placeholder="8:30">-->
                            </div>
                        </div>
                        <div class="sheet-right col-md-6">
                            <div class="form-group">
                                <label>排班类型 (必填)</label>
                                <select class="form-control" v-model="sheetData.type" data-itemid="1">
                                    <option value="1">固定班</option>
                                    <option value="2">临时班</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>排班状态 (必填)</label>
                                <select class="form-control" v-model="sheetData.status">
                                    <option value="1">启用</option>
                                    <option value="2">暂停</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>排班星期 (必填)</label>
                                <select class="form-control" v-model="sheetData.week" placeholder="请选择">
                                    <option value="1">星期一</option>
                                    <option value="2">星期二</option>
                                    <option value="3">星期三</option>
                                    <option value="4">星期四</option>
                                    <option value="5">星期五</option>
                                    <option value="6">星期六</option>
                                    <option value="0">星期天</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>工资 (必填)</label>
                                <input type="number" v-model.number="sheetData.hour_salary" class="form-control" placeholder="工资">
                            </div>
                        </div>
                    </div>
                    <button type="button" v-on:click="createSheet"
                            class="btn btn-default btn-login create-employee-btn sheet-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
            </div>
        </div>

        <div class="create-container" v-bind:class="{ 'hidden':isHiddenAssign }">
            <div class="create-employee-title"><h4>员工排班</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>排班表</label>
                        <select class="form-control" v-model="assignEmployeeToSchedule.schedule_id">
                            <option v-bind:value="schedule.id" v-for="schedule in scheduleList">{{ schedule.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>员工</label>
                        <select class="form-control" v-model="assignEmployeeToSchedule.employee_id">
                            <option v-bind:value="employee.id" v-for="employee in employeesList">{{ employee.username }}</option>
                        </select>
                    </div>
                    <button type="button" v-on:click="assignSchedule"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
            </div>
        </div>

        <div class="container-fluid login-info">
            <transition name="fade">
                <div class="alert alert-danger error" v-if="showError" role="alert"><span>{{ error }}</span></div>
            </transition>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['employees'],
        mounted() {

        },
        data(){
            return {
                employeeList: this.employees,
                isHidden: true,
                isHiddenSheet: true,
                isHiddenAssign: true,
                email: null,
                showError: false,
                name: null,
                value2: new Date(2016, 9, 10, 18, 40),
                sheetData:{},
                scheduleList:null,
                employeesList:null,
                assignEmployeeToSchedule:{},
                adminUrl:this.configs.default.url + 'admin/select_restaurant/1',
                start_time:'',
                end_time:'',
                img_url:this.configs.default.url + 'image/avatar.jpg'
            }
        },
        methods: {
            showCreateView: function () {
                this.isHidden = false;
            },
            listenStartDate:function (date) {
                this.sheetData.start_date = date;
            },
            listenEndDate:function (date) {
                this.sheetData.end_date = date;
            },
            createSheetView: function () {
                this.isHiddenSheet = false;
            },
            /** 员工排班页面 **/
            employeeAssignView: function () {
                this.isHiddenAssign = false;
                var _this = this;

                this.$http.get(this.configs.default.url + 'admin/schedules_employees', {}).then(response => {
                    _this.scheduleList = response.body.schedules;
                    _this.employeesList = response.body.employees;

                    console.log(response.body);

                }, response => {
                    this.error = '请求排班表和员工表失败';
                    this.showError = true;
                    setTimeout(function () {
                        _this.showError = false;
                    }, 2500);
                });

            },
            close: function () {
                if (!this.isHidden) {
                    this.isHidden = true;
                    this.showError = false;
                }
                if (!this.isHiddenAssign) {
                    this.isHiddenAssign = true;
                    this.showError = false;
                }
                if (!this.isHiddenSheet) {
                    this.isHiddenSheet = true;
                    this.showError = false;
                }
            },
            /** 添加员工 **/
            createEmployee(){
                var _this = this;
                this.$http.post(this.configs.default.url + 'admin/add_employee', {
                    name:this.name,
                    email:this.email
                }).then(response => {
                    if (response.body.status_code == 200) {
                        this.error = response.body.message;
                        setTimeout(function () {
                            _this.showError = false;
                        }, 2500);
                    } else {
                        this.$message({
                            message: 'response.body.message',
                            type: 'warning'
                        });
                        /*this.$message('这是一条消息提示');
                        this.error = response.body.message;
                        this.showError = true;
                        setTimeout(function () {
                            _this.showError = false;
                        }, 2500);*/
                    }
                }, response => {
                    this.error = '网络出错';
                    this.showError = true;
                });
            },
            /** 新建排班 **/
            createSheet:function () {
                var _this = this;
                this.sheetData.start_time = this.start_time;
                this.sheetData.end_time = this.end_time;
                this.$http.post(this.configs.default.url + 'admin/create_schedule', {
                    sheet_data:this.sheetData
                }).then(response => {
                    console.log(response.body.status_code);
                    if (response.body.status_code == 200) {
                        this.error = response.body.message;
                        this.showError = true;
                        setTimeout(function () {
                            _this.showError = false;
                        }, 2500);
                    } else {
                        this.error = response.body.message;
                        this.showError = true;
                        setTimeout(function () {
                            _this.showError = false;
                        }, 2500);
                    }
                }, response => {
                    this.error = '网络出错';
                    this.showError = true;
                    setTimeout(function () {
                        _this.showError = false;
                    }, 2500);
                });
            },

            /** 给员工排班 **/
            assignSchedule:function () {

                var _this = this;

                this.$http.post(this.configs.default.url + 'admin/assign_schedule', {
                    employee_id:this.assignEmployeeToSchedule.employee_id,
                    schedule_id:this.assignEmployeeToSchedule.schedule_id,
                }).then(response => {
                    if (response.body.status_code == 200) {
                        this.$message({
                            message: response.body.message,
                            type: 'success'
                        });
                        /*this.error = response.body.message;
                        this.showError = true;
                        setTimeout(function () {
                            _this.showError = false;
                        }, 2500);*/
                    } else {
                        this.$message.error(response.body.message);
                    }
                }, response => {
                    this.error = '网络出错';
                    this.showError = true;
                });
            }
        },
    }
</script>