<template>
    <div>
        <magnify-button
            :button-color="buttonColor"
            :icon-type="iconType" 
            :is-large="isLarge"
            :is-normal="isNormal"
        >
        </magnify-button>
    </div>
</template>

<script> 
  export default {
    props: ['buttonColor','iconType','isLarge','isNormal']
  }
  //イベントの受け渡し
</script>