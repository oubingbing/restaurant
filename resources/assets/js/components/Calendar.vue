<script>
    // for Vue 2.0
    import myDatepicker from 'vue-datepicker'

    export default {
        mounted() {

        },
        data () {
            return {
                // for Vue 2.0
                startTime: {
                    time: ''
                },
                date:'234',
                endtime: {
                    time: ''
                },

                option: {
                    type: 'day',
                    week: ['一', '二', '三', '四', '五', '六', '天'],
                    month: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    format: 'YYYY-MM-DD',
                    placeholder: '选择日期',
                    inputStyle: {
                        'display': 'inline-block',
                        'padding': '6px',
                        'line-height': '22px',
                        'font-size': '16px',
                        'border': '2px solid #fff',
                        'box-shadow': '0 1px 3px 0 rgba(0, 0, 0, 0.2)',
                        'border-radius': '2px',
                        'color': '#5F5F5F'
                    },
                    color: {
                        header: '#F30001',
                        headerText: '#FFFFFF'
                    },
                    buttons: {
                        ok: '确定',
                        cancel: '取消'
                    },
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: true // as true as default
                },
                timeoption: {
                    type: 'min',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD HH:mm'
                },
                multiOption: {
                    type: 'multi-day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format:"YYYY-MM-DD HH:mm"
                },
            }
        },
        methods:{
            listenChange:function (date) {
                this.$emit('listenDateSelect', date);
            }
        },
        components: {
            'date-picker': myDatepicker
        }
    }
</script>
<template>
    <div class="card">
        <!-- for Vue 2.0 -->
        <div class="row">
            <date-picker :date="startTime" :option="option" @change="listenChange"></date-picker>
        </div>

    </div>
</template>