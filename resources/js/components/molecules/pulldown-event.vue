<template>
    <div>
        <pulldown
        :item-array="itemArray"
        :label="label"
        :name="name"
        :selected-value="selectedValue"
        :error-message="errorMessage"
        >
        </pulldown>
    </div>
</template>

<script>
  export default {
    props: ["itemArray","label","name","value","oldValue","oldText","errorMessage"],
    data (){
        return {
            selectedValue: this.$props.value,
        }
    },
    created(){
    }

  }
</script>
