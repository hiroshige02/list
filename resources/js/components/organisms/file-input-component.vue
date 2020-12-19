<template>
    <v-col cols="12" sm="10" class="no-gutters">

        <div v-for="(file,index) in dataFiles"
        :key="index">
            <file-input
            :button-text="buttonText"
            :is-normal="true"
            :font="font"
            :name="name"
            :value="file"
            :button-color="buttonColor"
            :is-small="isSmall"
            :is-large="isLarge"
            >
            </file-input>
        </div>

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
            >
            </file-input>
        </div>

        <v-col cols="12">
            <v-col cols=2 @click="increaseInput()">
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
            </v-col>
        </v-col>

    </v-col>
</template>

<script>
  export default {
    props: ["name","buttonText","files","font",
    "buttonColor","isSmall","isLarge","height","width",
    "minWidth","minHeight"],
    methods: {
        increaseInput(){
            console.log('increase increase');
            this.$data.emptyField = this.$data.emptyField + 1;
            console.log(this.$data.emptyField);
        }
    },
    created(){
        if(this.$props.files){
            this.$data.dataFiles = this.$props.files;
            console.log('files' + this.$data.dataFiles); //OK
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
