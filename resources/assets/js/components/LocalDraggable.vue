<template>
	<draggable :list="array" class="dragArea" :options="{ group: 'tasks'}" :move="checkMoveSub"> 
		<transition-group>
            <div v-for="element in array" :key="element.id" class="transit-1">
                <div class="small-card">
                  {{element.id}}  With supporting text below as a natural lead-in to additional content.
                </div>
            </div>
        </transition-group>
	</draggable>
</template>
<script type="text/javascript">
	export default {
		props : ['array'],
		methods : {
			checkMoveSub(){
				this.$emit('moved')
			}
		}
    }
</script>