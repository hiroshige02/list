<template>
    <div class="no-gutters">
        <v-btn
          :type="type"
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
          @click="onclick"
        ><span :class="font">{{buttonText}}</span></v-btn>
    </div>
</template>

<script>
  export default {
    props: ['type','buttonText','buttonColor',
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
        onclick(){
            if(this.$props.eventName != undefined){
                this.$emit(this.$props.eventName);
                return;
            }

        }
    }

  }
</script>
