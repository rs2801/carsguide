<template>
    <div class="container text-center">
        
        <h1 class="searchTitle">Twitter search.</h1>

        <search-form :searching="searching" v-on:search="newSearch(arguments[0])"></search-form>

        <api-searching v-if="searching" :term="searchTerm" :more="next_page"></api-searching>

        <results-table :searchResults="results" :nextPage="next_page" :searching="searching" :noResults="noResults" v-on:search="search()"></results-table>
        
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
                'apiError': false,
                'missingTerm': false,
                'noResults': false,
            }
        },
        methods: {
            processSuccess: function (response) {

                this.searching = false;

                var results = response.data.results;
                var key = response.data.next_page;

                if(!results) {
                    this.apiError = true;
                    return;
                }
                
                this.next_page = key;

                if(results.length === 0) {
                    this.noResults = true;
                    return;
                }

                this.results.push(results);
            },
            reset: function () {
                this.results = [];
                this.next_page = null;
                this.noResults = false;
            },
            processError: function (error) {
                this.searching = false;

                if(error.response.status == 400) {
                    this.missingTerm = true;
                    return;
                }
                
                this.apiError = true;
            },
            newSearch: function (term) {
                this.reset();
                this.searchTerm = term;

                if(!this.searchTerm) {
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
                    this.processSuccess(response);
                }).catch((error) => {
                    this.processError(error);
                });
                  
            }
        }
    }
</script>
