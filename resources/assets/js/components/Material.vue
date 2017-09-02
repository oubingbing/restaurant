<template>
    <div class="employee vue-containe">
        <div class="employee-manager col-md-2">
            <div class="manager-item" v-on:click="showCreateView">一级分组</div>
            <div class="manager-item" v-on:click="createGroupTowView">二级级分组</div>
            <div class="manager-item" v-on:click="createMaterialView">添加材料</div>
            <div class="manager-item"><a v-bind:href="adminUrl">返回</a></div>
        </div>
        <div id="employee-container" class="col-md-10">
            <el-tabs type="border-card" v-bind:style="{height:screen_height+'px'}">
                <el-tab-pane label="材料">

                    <el-table :data="materials" border>
                        <el-table-column label="材料名称" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.name }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="一级分组" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.one_level_group }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="二级分组" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.two_level_group }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="单价" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.price }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="单位" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.unit }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="类型" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.type }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="状态" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.status }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="操作" v-bind:width="screen_width">
                            <template scope="scope">
                                <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                                <el-button size="small" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                            </template>
                        </el-table-column>
                    </el-table>

                </el-tab-pane>
                <el-tab-pane label="一级分组">

                    <el-table :data="materials" border>
                        <el-table-column label="分组名称" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.name }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="类型" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.one_level_group }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="状态" v-bind:width="screen_width">
                            <template scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.two_level_group }}</span>
                            </template>
                        </el-table-column>
                    </el-table>

                </el-tab-pane>
                <el-tab-pane label="二级分组">二级分组</el-tab-pane>
            </el-tabs>

        </div>

        <div class="create-container create-group-one" v-bind:class="{ 'hidden':isHidden }">
            <div class="create-employee-title"><h4>新建一级分组</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>分组名称 (必填)</label>
                        <input type="text" v-model="name" class="form-control" placeholder="分组名称">
                    </div>
                    <button type="button" v-on:click="createGroupOne"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
                <div class="create-employee-tips"><span>温馨提示：分组名称不能重复</span></div>
            </div>
        </div>

        <div class="create-container create-group-two" v-bind:class="{ 'hidden':isHiddenTwo }">
            <div class="create-employee-title"><h4>新建二级分组</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>所属一级分组 (必填)</label>
                        <el-select v-model="belong_one_id" clearable placeholder="请选择">
                            <el-option
                                    v-for="item in group_one_list"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="form-group">
                        <label>二级分组名称 (必填)</label>
                        <input type="text" v-model="group_two_name" class="form-control" placeholder="二级分组名称">
                    </div>
                    <button type="button" v-on:click="createGroupTwo"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
                <div class="create-employee-tips"><span>温馨提示：分组名称不能重复</span></div>
            </div>
        </div>

        <!--新建材料-->
        <div class="create-container create-material" v-bind:class="{ 'hidden':isHiddenCreateMaterial }">
            <div class="create-employee-title"><h4>新建材料</h4></div>
            <div class="close" v-on:click="close">关闭</div>
            <div class="container create-form">
                <form method="post" action="">
                    <div class="form-group">
                        <label>材料名称 (必填)</label>
                        <el-input v-model="material.name" placeholder="请输入内容"></el-input>
                    </div>
                    <div class="form-group">
                        <label>所属一级分组 (必填)</label>
                        <el-select v-model="belong_one_id" clearable placeholder="请选择">
                            <el-option
                                    v-for="item in group_one_list"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="form-group">
                        <label>所属二级分组 (必填)</label>
                        <el-select v-model="belong_two_id" clearable placeholder="请选择">
                            <el-option
                                    v-for="item in group_two_list"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </div>

                    <div class="form-group">
                        <label>单价 (必填)</label>
                        <el-input v-model="material.price" placeholder="请输入内容"></el-input>
                    </div>
                    <div class="form-group">
                        <label>单位 (必填)</label>
                        <el-input v-model="material.unit" placeholder="请输入内容"></el-input>
                    </div>
                    <div class="form-group">
                        <label>类型 (必填) </label>
                        <el-radio class="radio" style="color: white" v-model="material_type" label="1">食材</el-radio>
                        <el-radio class="radio" style="color: white" v-model="material_type" label="2">物料</el-radio>
                    </div>
                    <button type="button" v-on:click="createMaterial"
                            class="btn btn-default btn-login create-employee-btn"
                            style="color: white;background: darkorange;border-color: #03CF8A">添加
                    </button>
                </form>
                <div class="create-employee-tips"><span>温馨提示：材料名称不能重复</span></div>
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
        props: ['materials'],
        mounted() {
            console.log(this.configs.default.screen_height);
            //获取一级分组列表
            this.$http.get(this.configs.default.url + 'admin/group_list').then(response => {
                console.log(response.body.data.group_one);
                console.log(response.body.data.group_two);
                this.group_one_list = response.body.data.group_one;
                this.group_two_list = response.body.data.group_two;
            }, response => {
                this.$message({
                    message: '网络错误',
                    type: 'warning'
                });
            });

        },
        data(){
            return {
                isHidden: true,
                isHiddenTwo: true,
                isHiddenCreateMaterial: true,
                adminUrl: this.configs.default.url + 'admin/select_restaurant/1',
                name: null,
                group_one_list: null,
                group_two_list: null,
                belong_one_id: '',
                belong_two_id: '',
                group_two_name: null,
                material_type: 1,
                material: {},
                screen_width:(this.configs.default.screen_width - (this.configs.default.screen_width*0.305)) / 8,
                screen_height:this.configs.default.screen_height -(this.configs.default.screen_width*0.18),
            }
        },
        methods: {
            showCreateView: function () {
                this.isHidden = false;
            },
            createGroupTowView: function () {
                this.isHiddenTwo = false;
            },
            createMaterialView: function () {
                this.isHiddenCreateMaterial = false;
            },
            createGroupTwo: function () {
                this.isHiddenAssign = false;

                this.$http.post(this.configs.default.url + 'admin/create_group_two', {
                    name: this.group_two_name,
                    one_level_group: this.belong_one_id
                }).then(response => {
                    if (response.body.status_code == 200) {
                        this.$message({
                            message: response.body.message,
                            type: 'success'
                        });
                    } else {
                        this.$message.error(response.body.message);
                    }

                }, response => {
                    this.$message({
                        message: '网络错误',
                        type: 'warning'
                    });
                });

            },
            createGroupOne: function () {
                this.isHiddenAssign = false;

                this.$http.post(this.configs.default.url + 'admin/create_group_one', {
                    name: this.name,
                }).then(response => {
                    if (response.body.status_code == 200) {
                        this.$message({
                            message: response.body.message,
                            type: 'success'
                        });
                    } else {
                        this.$message.error(response.body.message);
                    }

                }, response => {
                    this.$message({
                        message: '网络错误',
                        type: 'warning'
                    });
                });

            },
            createMaterial: function () {
                this.material.one_level_group = this.belong_one_id;
                this.material.two_level_group = this.belong_one_id;
                this.material.type = this.material_type;

                console.log(this.material);

                this.$http.post(this.configs.default.url + 'admin/create_material', {
                    materials: this.material,
                }).then(response => {
                    if (response.body.status_code == 200) {
                        this.$message({
                            message: response.body.message,
                            type: 'success'
                        });
                    } else {
                        this.$message.error(response.body.message);
                    }

                }, response => {
                    this.$message({
                        message: '网络错误',
                        type: 'warning'
                    });
                });

            },
            close: function () {
                if (!this.isHidden) {
                    this.isHidden = true;
                }
                if (!this.isHiddenTwo) {
                    this.isHiddenTwo = true;
                }
                if (!this.isHiddenCreateMaterial) {
                    this.isHiddenCreateMaterial = true;
                }
            },
            handleEdit(index, row) {
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
            }

        },
    }
</script>