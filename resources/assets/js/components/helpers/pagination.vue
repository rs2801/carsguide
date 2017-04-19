<template>
    
  	<div class="pagination" v-if="(showPrevious || showNext)">
        <button class="btn btn-info previousPage" v-if="showPrevious" v-on:click="loadPreviousPage">
            <span>Previous Page</span>
        </button>
        <button class="btn btn-info nextPage" v-if="showNext" v-on:click="loadNextPage">
            <span>Next Page</span>
        </button>
    </div>

</template>

<script>
    export default {
      	props: ['showPrevious', 'showNext'],
      	methods: {
            loadPreviousPage: function (event) {
                this.$emit('previous');
            },
            loadNextPage: function (event) {
                this.$emit('next');
            }
        }
    }
</script>
