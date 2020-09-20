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
    data(){
        return {};
    },
    methods: {
        action:function(){
        //   if(this.$props.eventName == "increaseInput"){
        //     this.increaseInput();
        //   }elseif(this.$props.eventName == "login"){
        //     axios.post( "/login',{
        //     name：this.name、
        //     email ：this.email、
        //     description：this.description
        //     }）。then（response => {
        //     console.log（ 'successful'）;
        //     }）。catch（error => {
        //     if（error.response.status == 422）{
        //     this .validationErrors = error.response.data.errors;
        //     }
        //   }else{
        //     return;
        //   }
        },
        increaseInput(){
            console.log('llllllllllllll');

        }
    }
  }
</script>
