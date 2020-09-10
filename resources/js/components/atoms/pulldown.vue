<template>  
    <div>  
        <v-select
        :items="items"
        :label="label"
        dense
        solo
        ></v-select>
    </div> 
</template>

<script> 
  export default {
    props: ["items","label"]
  }
</script>