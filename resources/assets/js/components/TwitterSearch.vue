<template>
    <div class="container text-center">
        
        <h1 class="searchTitle">Twitter search.</h1>

        <search-form :searching="searching" v-on:search="freshSearch(arguments[0])"></search-form>
        <results-table :searchResults="results" :nextPage="next_page" :noResults="noResults" :searching="searching" v-on:search="search()"></results-table>
        <missing-term v-if="missingTerm" v-on:close="missingTerm = false"></missing-term>
        <api-error v-if="apiError" v-on:close="apiError = false"></api-error>

    </div>
</template>

<script>
    export default {
    	data: function() {
            return {
                'searching': false,
                'searchTerm': null,
                'next_page': null,
                'results': [],
                'resultKeys': [],
                'apiError': false,
                'missingTerm': false,
                'noResults': false,
            }
        },
        methods: {
            processResults: function (response) {

                var results = response.data.results;
                var key = response.data.next_page;

                if(!results) {
                    this.apiError();
                    return;
                }
                
                this.next_page = key;
                this.searching = false;

                if(results.length < 1) {
                    this.noResults = true;
                    return;
                }

                if(typeof this.resultKeys[key] === 'undefined' && results.length > 1) {
                    this.noResults = false;
                    this.results.push(results);
                    this.resultKeys[key] = 0;
                }
            },
            resetResults: function () {
                this.results = [];
                this.resultKeys = [];
                this.next_page = null;
                this.noResults = false;
            },
            apiError: function () {
                this.searching = false;
                this.apiError = true;
            },
            freshSearch: function (term) {
                this.resetResults();
                this.searchTerm = term;

                if(this.searchTerm == "") {
                    this.missingTerm = true;
                    return;
                }

                this.search();
            },
            search: function () {

                this.searching = true;

                axios.get('/api/search', {
                    params: {
                        'term': this.searchTerm,
                        'next_page': this.next_page,
                    }
                }).then((response) => {
                    this.processResults(response);
                }).catch((error) => {
                    this.apiError();
                });
                  
            }
        }
    }
</script>
