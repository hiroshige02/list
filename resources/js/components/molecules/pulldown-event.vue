<template>
    <div>
        <pulldown
        :item-array="itemArray"
        :label="label"
        :post-name="classPostName"
        >
        </pulldown>
    </div>
</template>

<script>
  export default {
    props: ["itemArray","label","classPostName"],
    beforeMount(){
        // console.log("this.$props.postName");
        // console.log(JSON.stringify(this.$props.itemArray));
    }

  }
</script>
