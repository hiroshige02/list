<template>
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
  }
  //イベント制御をここでする
</script>
