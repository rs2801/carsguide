
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


 /* Promise polyfill */
require('es6-promise').polyfill();

window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('twitter-search', require('./components/TwitterSearch.vue'));
Vue.component('search-form', require('./components/SearchForm.vue'));
Vue.component('results-table', require('./components/Results.vue'));
Vue.component('twitter-card', require('./components/TwitterCard.vue'));
Vue.component('api-error', require('./components/modals/apiError.vue'));
Vue.component('missing-term', require('./components/modals/missingTerm.vue'));
Vue.component('api-searching', require('./components/helpers/apiSearching.vue'));

const app = new Vue({
    el: '#app'
});
