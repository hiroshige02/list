<template>
    <div>
    <v-pagination
    v-model="page"
    :length="3"
    color="pink"
    ></v-pagination>
    </div>
</template>

<script> 
  export default {
    props: ['length'],
    data () {
        return {
            page: 1,
        }
    }
  }
  //イベントの受け渡し
</script>