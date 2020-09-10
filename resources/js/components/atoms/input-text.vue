<template>
    <v-text-field
    :label="textTitle"
    outlined
    :name="name"
    :value="existValue"
    :prefix="prefixText"
    :success-messages="success"
    ></v-text-field>
</template>

<script> 
  export default {
    props: ['textTitle','name','prefixText','success','existValue']
  }
</script>