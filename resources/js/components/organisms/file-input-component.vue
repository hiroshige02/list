<template>
    <v-col cols="12" sm="10" class="no-gutters">

        <div v-for="(count,i) in emptyField"
        :key="i+10">
            <file-input
            button-text="ー"
            :is-normal="true"
            :font="font"
            :name="name"
            :button-color="buttonColor"
            :is-small="isSmall"
            :is-large="isLarge"
            :total-images="totalImage"
            @decInput="decreaseInput"
            >
            </file-input>
        </div>

        <v-col cols="12" ref="increaseInput">
            <v-col cols="2">
                <span @click="increaseInput()">
                    <button-event
                    button-text="＋"
                    button-color="pink"
                    :is-normal='true'
                    width="45"
                    height="40"
                    min-width="20"
                    min-height="20"
                    :font="font"
                    >
                    </button-event>
                </span>
            </v-col>
        </v-col>

    </v-col>
</template>

<script>
  export default {
    props: ["name","buttonText","files","font",
    "buttonColor","isSmall","isLarge","height","width","totalImage"],
    methods: {
        increaseInput(){
            this.$emit('increaseInput');

            if(this.$props.totalImage >= 5) {
                return;
            }
            this.$data.emptyField = this.$data.emptyField + 1;
        },
        decreaseInput() {
            this.$emit('decreaseInput');
        }
    },
    created(){
        if(this.$props.files){
            this.$data.dataFiles = this.$props.files;
        }
    },
    data(){
        return {
            dataFiles: '',
            emptyField: 0
        }
    },
  }
</script>
