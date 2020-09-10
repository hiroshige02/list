<template>
<div>
          <v-col
            v-for="(item, i) in items"
            :key="i"
            cols="12"
          >
            <v-card
              color="white"
              class="d-inline-block mx-auto"
              width="100%"
            >
              <div class="d-flex flex-no-wrap justify-space-between">
                <v-avatar
                  class="ma-3"
                  size="125"
                  tile
                >
                  <v-img :src="item.src"></v-img>
                </v-avatar>

                <div>
                  <v-card-title
                    class="headline"
                    v-text="item.name"
                  ></v-card-title>
                  <v-card-title v-text="item.kura"></v-card-title>
                </div>
              </div>
            </v-card>
          </v-col>
  </div>
</template>

<script>

export default {
    props: ['buttonText','buttonColor','isNormal','isLarge'],

    data() {
    return {
        items: [{
            // color: '#1F7087',
            src: '/public/img/hiyoko.jpg',
            name: 'さわ音あ',
            kura: '小沢酒造',
            },
            {
            // color: '#952175',
            src: '/public/img/jazz.png',
            name: '澤乃井',
            kura: '小沢酒造',
        }]
    }
}
}


</script>