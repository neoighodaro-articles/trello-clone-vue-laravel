<template>
    <div class="container">
        <div class="row justify-content-center">
            <draggable element="div" class="col-md-12" v-model="categories" :options="dragOptions">
                <transition-group class="row">
                    <div class="col-md-4" v-for="element,index in categories" :key="element.id">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{element.name}}</h4>
                            </div>
                            <div class="card-body card-body-dark">
                                <draggable :options="dragOptions" element="div" @end="changeOrder" v-model="element.tasks">
                                    <transition-group :id="element.id">
                                        <div v-for="task,index in element.tasks" :key="task.category_id+','+task.order" class="transit-1" :id="task.id">
                                            <div class="small-card">
                                                <textarea v-if="task === editingTask" class="text-input" @keyup.enter="endEditing(task)" @blur="endEditing(task)" v-model="task.name"></textarea>
                                                <label for="checkbox" v-if="task !== editingTask" @dblclick="editTask(task)">{{ task.name }}</label>
                                            </div>
                                        </div>
                                    </transition-group>
                                </draggable>
                                <div class="small-card">
                                    <h5 class="text-center" @click="addNew(index)">Add new card</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </draggable>
        </div>
    </div>
</template>

<style scoped>
    .card {
        border:0;
        border-radius: 0.5rem;
    }
    .transit-1 {
        transition: all 1s;
    }
    .small-card {
        padding: 1rem;
        background: #f5f8fa;
        margin-bottom: 5px;
        border-radius: .25rem;
    }
    .card-body-dark{
        background-color: #ccc;
    }
    textarea {
        overflow: visible;
        outline: 1px dashed black;
        border: 0;
        padding: 6px 0 2px 8px;
        width: 100%;
        height: 100%;
        resize: none;
    }
</style>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        data(){
            return {
                categories : [],
                editingTask : null
            }
        },
        methods : {
            addNew(id) {
                let user_id = 1
                let name = "New task"
                let category_id = this.categories[id].id
                let order = this.categories[id].tasks.length

                axios.post('api/task', {user_id, name, order, category_id}).then(response => {
                    this.categories[id].tasks.push(response.data.data)
                })
            },
            loadTasks() {
                this.categories.map(category => {
                    axios.get(`api/category/${category.id}/tasks`).then(response => {
                        category.tasks = response.data
                    })
                })
            },
            changeOrder(data) {
                let toTask = data.to
                let fromTask = data.from
                let task_id = data.item.id
                let category_id = fromTask.id == toTask.id ? null : toTask.id
                let order = data.newIndex == data.oldIndex ? false : data.newIndex

                if (order !== false) {
                    axios.patch(`api/task/${task_id}`, {order, category_id}).then(response => {
                        // Do anything you want here
                    });
                }
            },
            endEditing(task) {
                this.editingTask = null

                axios.patch(`api/task/${task.id}`, {name: task.name}).then(response => {
                    // You can do anything you wan't here.
                })
            },

            editTask(task) {
                this.editingTask = task
            },
        },
        mounted() {
            let token = localStorage.getItem('jwt')

            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

            axios.get('api/category').then(response => {
                response.data.forEach((data) => {
                    this.categories.push({
                        id : data.id,
                        name : data.name,
                        tasks : []
                    })
                })
                this.loadTasks()
            })
        },
        computed: {
            dragOptions () {
              return  {
                animation: 1,
                group: 'description',
                ghostClass: 'ghost'
              };
            },
        },
        beforeRouteEnter (to, from, next) {
            if ( ! localStorage.getItem('jwt')) {
                return next('login')
            }

            next()
        }
}
</script>
