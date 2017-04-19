<template>
    <div>

        <div class="row" v-if="filtered">
            <div class="twitter-wrap clearfix">
                <div class="clearfix" v-for="item in filtered">
                    <twitter-card :item="item" :key="item.id_str"></twitter-card>
                </div>
            </div>
        </div>

        <div class="ga-large" v-if="showRenderSpinner"><i class="glyphicon glyphicon-refresh spinning"></i> Loading tweets</div>
        <div class="ga-large" v-if="noResults">No tweets found</div>

        <div class="pagination" v-if="(showPrevious || showNext)">
            <button class="btn btn-info previousPage" v-if="showPrevious" v-on:click="loadPreviousPage">
                <span>Previous Page</span>
            </button>
            <button class="btn btn-info nextPage" v-if="showNext" v-on:click="loadNextPage">
                <span>Next Page</span>
            </button>
        </div>

    </div>
</template>

<script>
    export default {
    	data: function() {
            return {
                'page': 0,
                'rendered': 0
            }
        },
        props: {
            searchResults: {
                type: Array,
                default: []
            },
            nextPage: {
                default: null
            },
            noResults: {
                default: false
            },
            searching: {
                default: false
            }
        },
        mounted: function() {
            twttr.ready(function (twttr) {
                twttr.events.bind('rendered', function (ev) {
                    this.rendered = this.rendered + 1;
                }.bind(this));
            }.bind(this));
        },
        computed: {
            filtered: function(){
                if(this.searchResults.length === 0) {
                    this.page = 0;
                    return false;
                }

                this.rendered = 0;
                return this.searchResults.slice(this.page, (this.page + 1))[0];
            },
            showPrevious: function(){
                return (this.page > 0);
            },
            showNext: function(){
                return ((this.page + 1) < this.searchResults.length || (this.nextPage && !this.searching));
            },
            showRenderSpinner: function(){
                if(!this.filtered || (this.filtered.length === this.rendered)) {
                    return false;
                }
                return true;
            }
        },
        methods: {
            loadPreviousPage: function () {
                this.page--;
            },
            loadNextPage: function () {

                this.page++;
                if(this.filtered) {
                    return;
                }

                //not cached, next
                this.$emit('search');
            }
        }
    }
</script>
