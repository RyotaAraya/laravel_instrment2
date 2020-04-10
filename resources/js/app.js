
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    data: {
        keyword: "",
        tasks: []
    },
    computed: {
        filteredTasks: function() {
            let tasks = [];
            for (let i in this.tasks) {
                let task = this.tasks[i];
                //キーワードを大文字に変換
                let keyword = this.keyword.toUpperCase();
                let plantUpperCase = task.plant_name.toUpperCase();
                let tagUpperCase = task.tag_no.toUpperCase();

                //一致しないと-1を返す
                if (
                    plantUpperCase.indexOf(keyword) !== -1 ||
                    tagUpperCase.indexOf(keyword) !== -1 ||
                    task.task_status.indexOf(this.keyword) !== -1
                ) {
                    //一致したら表示する
                    tasks.push(task);
                }
            }
            return tasks;
        }
    },
    methods: {
        fetchTasks: function() {
            axios.get("/api/get").then(res => {
                this.tasks = res.data;
            });
        }
    },
    created() {
        this.fetchTasks();
    }
});
