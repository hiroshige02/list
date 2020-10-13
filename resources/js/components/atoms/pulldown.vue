<template>
    <v-select
    :items="itemArray"
    :label="label"
    dense
    solo
    v-model="value"
    :name="name"
    v-on:change="changeEvent"
    item-text="text"
    item-value="value"
    :error-messages="errorMessage"
    ></v-select>
</template>

<script>
  export default {
    props: ["itemArray","label","name","eventName",
    "selectedValue","oldValue","oldText","errorMessage"],
    data (){
        return {
            value: '',
            existValue: this.oldValue,
            existText: this.oldText,
        }
    },

    methods: {
        changeEvent() {
            if(this.$props.eventName !== undefined){
                this.$emit(this.$props.eventName, this.value);
            }
        }

    },
    created(){
        if(this.selectedValue !== undefined){
            this.$data.value = this.selectedValue.value;
        }
    }
  }
</script>
