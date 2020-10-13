<template>
    <div @click="action">
        <custom-button
        :type="type"
        :event-name="eventName"
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
    props: ['type','buttonText','buttonColor',
    'isSmall','isNormal','isLarge',
    'height','width','minWidth','minHeight',
    'font','eventName'],
    data(){
        return {};
    },
    methods: {
        action:function(){
            if(this.$props.eventName !== undefined){
                return;
            }
            // elseif(this.$props.eventName == "login"){
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
