<template>
    
  	<div class="ga-large">
    	<i class="glyphicon glyphicon-refresh spinning"></i> Finding <span v-if="more">more</span> tweets for: <strong>{{ term }}</strong>
  	</div>

</template>

<script>
    export default {
      	props: ['term', 'more']
    }
</script>
