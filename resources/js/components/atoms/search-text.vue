<template>
    <v-text-field
        label="酒名など"
        single-line
        outlined
        append-icon="mdi-magnify"
        :error="is_error"
        :error-messages="error_messages"
    >
    </v-text-field>
</template>

<script> 
  export default {
    props: ['searchText',], //不要？
    components: {
    },
    data() {
        return {
            is_error: false,
            error_messages: [],

        }
    },
  }
</script>