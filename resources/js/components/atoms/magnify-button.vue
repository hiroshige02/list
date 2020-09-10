<template>  
<!-- <v-btn class="ma-2" color="purple" dark>
          <v-icon dark>mdi-wrench</v-icon>
        </v-btn> -->
    <div>  
        <v-btn 
          label="検索"
          :color="buttonColor"
          dark
          :large="isLarge"
          :normal="isNormal"
          >検索
            <!--<v-icon size="40">{{ iconType }}</v-icon> -->
        </v-btn>
    </div>
</template>

<script> 
  export default {
    props: ['buttonColor','isLarge','isNormal','iconType'],
    data() {
      return {
        //初期値
        // large: "false",
        // normal: "false",
        // color: "primary",
        
      };
    },
  }
  //イベント制御をここでする
</script>