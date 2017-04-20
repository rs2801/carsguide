<template>
    
  	<div>
  		<ul class="pagination" v-if="totalPages > 0">
  			<li v-if="showStart">
  			 	<a v-on:click.prevent="loadPage(1)" href="#"><i class="glyphicon glyphicon-step-backward"></i></a>
  			 </li>
  			 <li v-for="page in paginationRange" :class="{active : isActivePage(page)}">
  			 	<a v-on:click.prevent="loadPage(page)" href="#">{{ page }}</a>
  			 </li>
  			 <li v-if="showEnd">
  			 	<a v-on:click.prevent="loadPage(totalPages)" href="#"><i class="glyphicon glyphicon-step-forward"></i></a>
  			 </li>
  			 <li v-if="allowLoadMore">
  			 	<a v-on:click.prevent="loadMore" class="loadMore" href="#">Load more</a>
  			 </li>
  		</ul>
    </div>

</template>

<script>
    export default {
    	data: function() {
            return {
                'visiblePages': 5,
                'showStart': false,
                'showEnd': false
            }
        },
      	props: ['currentPage', 'allowLoadMore', 'totalPages'],
      	computed: {
      		paginationRange () {
			  let start =
			    this.currentPage - (this.visiblePages / 2) <= 0 ? 1
			    : this.currentPage + (this.visiblePages / 2) > this.totalPages
			    ? this.lowerBound(this.totalPages - this.visiblePages + 1, 1)
			    : Math.ceil(this.currentPage - this.visiblePages / 2 + 1);

			  let range = [];

			  for (let i = 0; i < this.visiblePages && i < this.totalPages; i++) {
			    range.push(start + i);
			  }

			  if(range[0] > 1) {
			  	this.showStart = true;
			  } else {
			  	this.showStart = false;
			  }

			  if(range.slice(-1)[0]  < this.totalPages) {
			  	this.showEnd = true;
			  } else {
			  	this.showEnd = false;
			  }

			  return range;
			},
      	},
      	methods: {
      		lowerBound (num, limit) {
				return num >= limit ? num : limit;
			},
            loadPage: function (pageNum) {
            	var pageNum = (pageNum - 1);
                this.$emit('page', pageNum);
            },
            loadMore: function (event) {
                this.$emit('load');
            },
            isActivePage: function (pageNum) {
            	pageNum--;
			    return (this.currentPage === pageNum);
			}
        }
    }
</script>
