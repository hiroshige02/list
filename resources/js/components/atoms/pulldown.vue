<template>
    <v-select
    :items="itemArray"
    :label="label"
    dense
    solo
    :name="postName"
    v-model="selectedValue"
    v-on:change="changeEvent"
    ></v-select>
</template>

<script>
  export default {
    props: ["itemArray","label","postName","eventName"],
    data (){
        return {
            selected: '',
            selectedValue: ''
        }
    },

    methods: {
        changeEvent() {
            if(this.$props.eventName !== undefined){
                console.log(this.$props.eventName);
                this.$emit(this.$props.eventName, this.selectedValue);

            }
        }

    }
  }
</script>
