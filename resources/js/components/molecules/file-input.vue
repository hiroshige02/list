<template>

    <v-col cols=12 ref="file_input" class="d-flex no-gutters">
        <v-col cols="2" class="pt-2">
            <span @click="decreaseInput()">
                <button-event
                :button-text="buttonText"
                button-color="pink"
                :is-normal="true"
                width="45"
                height="40"
                min-width="20"
                min-height="20"
                :font="font"
                >
                </button-event>
            </span>
        </v-col>
        <v-col cols="10">
            <file-input-tag
            :name="name"
            v-model="value"
            ></file-input-tag>
        </v-col>

    </v-col>


</template>

<script>
  export default {
    props: ["name","buttonText","font",
    "buttonColor","value"],
    data(){
        return{
        }
    },
    methods: {
        decreaseInput(){
            this.$refs.file_input.remove();
            this.$emit('decInput');
        }
    }
  }
</script>
