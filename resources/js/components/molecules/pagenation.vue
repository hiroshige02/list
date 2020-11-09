<template>
    <div>
    <v-pagination
    v-model="page"
    :length="totalPages"
    color="pink"
    @input="clickPage"
    ></v-pagination>
    </div>
</template>

<script>
  export default {
    props: ['totalPages','perPage','currentPage'],
    data () {
        return {
            page: 1,
        }
    },
    created(){
        if(this.$props.currentPage != undefined){
            this.$data.page = this.$props.currentPage;
        }
    },
    methods: {
        clickPage(pageNumber){
            this.$emit('clickedPage', pageNumber)
        }
    }
  }
  //イベントの受け渡し
</script>
