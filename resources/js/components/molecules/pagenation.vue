<template>
    <div>
    <v-pagination
    v-model="page"
    :length="totalPages"
    color="pink"
    ></v-pagination>
    </div>
</template>

<script>
  export default {
    props: ['totalPages','perPageS'],
    data () {
        return {
            page: 2,
        }
    }
  }
  //イベントの受け渡し
</script>
