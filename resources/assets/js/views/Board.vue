<template>
    <div class="container">
        <div class="row justify-content-center">
            <draggable element="div" class="col-md-12" v-model="categories" :move="changeCategory" :options="dragOptions"> 
                <transition-group class="row">
                    <div class="col-md-4" v-for="element,index in categories" :key="element.id"> 
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{element.name}}</h4>  
                            </div>
                            <div class="card-body card-body-dark">
                                <draggable :options="dragOptions" element="div" @end="changeOrder" v-model="element.tasks">
                                    <transition-group :id="element.id">
                                        <div v-for="elementDeep in element.tasks" :key="elementDeep.category_id+','+elementDeep.order" class="transit-1" :id="elementDeep.id"> 
                                            <div class="small-card">
                                                <textarea v-if="elementDeep === editingTask" class="text-input" @keyup.enter="endEditing(elementDeep)" @blur="endEditing(elementDeep)" v-model="elementDeep.name"></textarea>
                                                <label for="checkbox" v-if="elementDeep !== editingTask" @dblclick="editTask(elementDeep)">{{ elementDeep.name }}</label>
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
            addNew(id){
                // this.array.push({id: this.array.length+1, text : "new task"});
                var category_id = this.categories[id].id
                axios.post('api/task', {
                    user_id: '1',
                    name: "new tasks",
                    order: this.categories[id].tasks.length,
                    category_id : category_id
                })
                .then((response) => {
                    this.categories[id].tasks.push(response.data.data)
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            loadTasks(){
                this.categories.map( (category) => {
                    axios.get(`api/category/${category.id}/tasks`)
                    .then((response) => {
                        category.tasks = response.data
                    })
                    .catch(function (error) {
                        console.log(error)
                    }) 
                })
            },
            changeCategory(data){
                console.log(data)
            },
            changeOrder(data){
                var category_id = data.from.id == data.to.id? null : data.to.id
                var task_id     = data.item.id
                var task_order  = data.newIndex == data.oldIndex? false : data.newIndex
                if(task_order)
                {
                    axios.patch(`api/task/${task_id}`, {
                        order : task_order,
                        category_id : category_id
                    })
                }
            },
            endEditing(task) {
                this.editingTask = null
                axios.patch(`api/task/${task.id}`, {
                    name: task.name
                })
            },
            editTask(task){
                this.editingTask = task
            }
        },
        mounted(){
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
            
            axios.get('api/category')
                .then((response) => {
                    response.data.forEach( (data) => {
                        this.categories.push({
                            id : data.id,
                            name : data.name,
                            tasks : []
                        })
                    })
                    this.loadTasks()
                })
                .catch(function (error) {
                    console.log(error)
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
            if(localStorage.getItem('jwt'))
            {
                next() 
            }
            else 
            {
                return next('login');
            }
        }
    }
</script>
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