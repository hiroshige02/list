<template>
    <v-text-field
    :label="textTitle"
    outlined
    :type="type"
    :name="name"
    :value="value"
    :error-messages="errorMessages"
    :prefix="prefixText"
    :success-messages="success"
    ></v-text-field>
</template>

<script>
  export default {
    props: ['textTitle','type','name',
    'prefixText','success','value','errorMessages']
  }
</script>
