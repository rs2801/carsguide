<template>
    <div>
        <div :id="tweet"></div>
    </div>
</template>

<script>
    export default {
        props: ['tweet'],
        mounted: function () {

            twttr.widgets.createTweet(
              this.tweet,
              document.getElementById(this.tweet),
              {
                conversation: 'none',
                width: 550,
            });
        }
    }
</script>
