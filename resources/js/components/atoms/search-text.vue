<template>
    <v-text-field
    label="酒名"
    outlined
    append-icon="mdi-magnify"
    :error="is_error"
    :error-messages="error_messages"
    name="name"
    v-model="textValue"
    >
    </v-text-field>
</template>

<script>
  export default {
    props: ['value',],
    components: {
    },
    data() {
        return {
            is_error: false,
            error_messages: [],
            textValue: this.$props.value,

        }
    },
  }
</script>
