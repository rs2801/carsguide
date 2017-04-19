<template>
    <div class="row">

        <div class="form-group col-md-offset-3 col-md-6">
        	<form class="form-inline twitter-search" v-on:submit.prevent="submit">
    			<input type="text" class="form-control input-lg" v-model="searchTerm" placeholder="Search term e.g. carsguide">
    			<button class="btn btn-lg" v="submit">
    				<i v-if="!searching" class="glyphicon glyphicon-search"></i>
    				<i v-else class="glyphicon glyphicon-refresh spinning"></i>
    			</button>
    		</form>
  		</div>

    </div>

</template>

<script>
    export default {
    	data: function() {
            return {
                'searchTerm': 'carsguide',
            }
        },
        props: ['searching'],
        methods: {
            submit: function (event) {
                this.$emit('search', this.searchTerm);
            }
        }
    }
</script>
