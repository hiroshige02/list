<template>
    <div>
        <v-col
        v-for="(sake, i) in sakes"
        :key="i"
        cols="12"
        >
            <v-card
              color="white"
              class="d-inline-block mx-auto"
              width="100%"
            >
                <!-- <div class="d-flex flex-no-wrap justify-space-between"> -->
                <div class="d-flex flex-no-wrap" justify="left">
                    <v-avatar v-if="sake.image_path" class="ma-3" size="125" tile>
                        <v-img :src="sake.image_path"></v-img>
                    </v-avatar>
                    <div>
                        <v-card-title
                            class="headline"
                            v-text="sake.name"
                        ></v-card-title>
                        <v-card-title v-text="sake.kura">
                        </v-card-title>
                    </div>
                </div>
            </v-card>
        </v-col>
    </div>
</template>

<script>

export default {
    props: ['datas','buttonText','buttonColor','isNormal','isLarge'],

    data() {
        return {
            sakes: [],
        }
    },
    created(){
        console.log(this.$props.datas);
        console.log(JSON.parse(this.$props.datas));

        this.$data.sakes = JSON.parse(this.$props.datas);
    }
}

</script>
