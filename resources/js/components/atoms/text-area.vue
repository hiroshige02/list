<template>
    <div>
        <v-textarea
        outlined
        :name="name"
        :label="label"
        :placeholder="placeholder"
        :value="value"
        :color="color"
        :error-messages="errorMessages"
        ></v-textarea>
    </div>
</template>

<script>
  export default {
    props: ['name','label','value','placeholder','color','errorMessages'],
    data() {
        return {


        }
    },
  }
</script>
