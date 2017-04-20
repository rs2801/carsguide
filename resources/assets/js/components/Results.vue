<template>
    <div>

        <div class="row" v-if="tweets">
            <div class="twitter-wrap clearfix">
                <div class="clearfix" v-for="tweet in tweets">
                    <twitter-card :tweet="tweet" :key="tweet"></twitter-card>
                </div>
            </div>
        </div>

        <loading-tweets v-if="loadingTweets"></loading-tweets>
        <no-tweets v-if="noResults"></no-tweets>
        <all-results-found v-if="allResultsFound"></all-results-found>

        <pagination :totalPages="totalPages" :currentPage="currentPage" :allowLoadMore="allowLoadMore" v-on:load="loadMore" v-on:page="loadPage"></pagination>

    </div>
</template>

<script>
    export default {
    	data: function() {
            return {
                'currentPage': 0,
                'loadedTweets': 0,
                'totalPages': 0
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
                    this.loadedTweets = this.loadedTweets + 1;
                }.bind(this));
            }.bind(this));
        },
        computed: {
            tweets: function(){
                if(this.searchResults.length === 0) {
                    this.currentPage = 0;
                    this.totalPages = 0;
                    return false;
                }

                this.loadedTweets = 0;
                this.totalPages = this.searchResults.length;
                return this.searchResults.slice(this.currentPage, (this.currentPage + 1))[0];
            },
            allowLoadMore: function(){
                return (this.nextPage && !this.searching);
            },
            loadingTweets: function(){
                if(!this.tweets || (this.tweets.length === this.loadedTweets)) {
                    return false;
                }

                return true;
            },
            allResultsFound: function(){
                if(!this.loadingTweets && this.totalPages > 0 && !this.allowLoadMore && (this.currentPage+1) === this.totalPages) {
                    return true;
                }

                return false;
            }
        },
        methods: {
            loadPage: function (pageNum) {
                this.currentPage = pageNum;
            },
            loadMore: function () {
                this.currentPage = this.searchResults.length;
                this.$emit('search');
            }
        }
    }
</script>
