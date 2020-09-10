<template>  
    <div @click="action">
      <custom-button
          :button-color="buttonColor"
          :button-text="buttonText"
          :is-small="isSmall"
          :is-normal="isNormal"
          :is-large="isLarge"
          :height="height"
          :width="width"
          :min-width="minWidth"
          :min-height="minHeight"
          :font="font"
      >
      </custom-button>
    </div>
</template> 

<script> 
  export default {
    props: ['buttonText','buttonColor',
    'isSmall','isNormal','isLarge',
    'height','width','minWidth','minHeight',
    'font','eventName'],
    methods: {
        action:function(){
          if(this.$props.eventName == "increaseInput"){
            this.increaseInput();
          }else{
            return;
          }
        },
        increaseInput(){
            console.log('llllllllllllll'); //OK
            
        }
    }
  }
</script>