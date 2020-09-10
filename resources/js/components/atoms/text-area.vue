<template>
    <div>
        <v-textarea
            outlined
            :name="name"
            :label="label"
            :placeholder="placeholder"
            :value="value"
            :color="color"
        ></v-textarea>
    </div>
</template>

<script> 
  export default {
    props: ['name','label','value','placeholder','color'],
    data() {
        return {


        }
    },
  }
</script>