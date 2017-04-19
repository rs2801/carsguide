<template>
    <div>
        <div :id="item.id_str"></div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        mounted: function () {

            twttr.widgets.createTweet(
              this.item.id_str,
              document.getElementById(this.item.id_str),
              {
                conversation: 'none',
                width: 550,
            });
        }
    }
</script>
