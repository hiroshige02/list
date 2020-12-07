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
    :disabled="disable"
    ></v-select>
</template>

<script>
  export default {
    props: ["itemArray","label","name","eventName",
    "selectedValue","oldValue","oldText","errorMessage","ifDisabled"],
    data (){
        return {
            value: '',
            existValue: this.oldValue,
            existText: this.oldText,
            disable: false
        }
    },

    methods: {
        changeEvent() {
            if(this.$props.eventName !== undefined){
                if(this.$props.eventName == 'personalChange'){
                    this.$emit(this.$props.eventName, {'value':this.value, 'column':this.name});//OK
                }
                this.$emit(this.$props.eventName, this.value);
            }
        }

    },
    created(){
        if(this.selectedValue !== undefined){
            this.$data.value = this.selectedValue.value;
        }
        this.$data.disable = this.$props.ifDisabled;
    },
    watch: {
        ifDisabled: function(){
            this.$data.disable = this.$props.ifDisabled;
        }
    }
  }
</script>
