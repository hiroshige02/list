<template>
    <div class="no-gutters">
        <v-btn
          type='submit'
          :color="buttonColor"
          :small="isSmall"
          :large="isLarge"
          :normal="isNormal"
          :height="height"
          :width="width"
          :min-width="minWidth"
          :min-height="minHeight"
          :icon-type="iconType"
          :eventName="eventName"
          dark
          @click="clickEvent"
        ><span :class="font">{{buttonText}}</span></v-btn>
    </div>
</template>

<script>
  export default {
    props: ['buttonText','buttonColor',
    'isSmall','isNormal','isLarge',
    'height','width','minWidth','minHeight',
    'iconType','font','eventName'],
    data() {
      return {
        //初期値
        // large: "false",
        // normal: "false",
        // color: "primary",

      };
    },
    methods: {
      // triggerEvent: function(){
      //   console.log('kkkkkkk');
      //   this.$emit(this.$props.eventName);
      // }
      clickEvent: function(){
        if(this.$props.eventName == 'decreaseInput'){
          this.anone();
        }else{
          return;
        }
      },
      anone(){
            console.log('yeeeeeeeeeeeah')
            // this.$parent.$el.remove();
        }
    }

  }
  //イベント制御をここでする
</script>
