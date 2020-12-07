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
                <a :ref="sake.sake_id" href="#" @click="toSpecifics(sake,page)">
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
                </a>
            </v-card>
        </v-col>
    </div>
</template>

<script>

export default {
    props: ['datas','buttonText','buttonColor',
    'isNormal','isLarge','currentPage','maintenanceAddress'],

    data() {
        return {
            sakes: this.$props.datas,
            page: 1,
        }
    },
    created(){
    },
    watch: {
        datas: function(){
            this.$data.sakes = this.$props.datas;
        },
        currentPage: function(){
            this.$data.page = this.$props.currentPage;
        },
    },
    methods: {
        // 遷移先のアドレスを取得
        toSpecifics(sake,pageNo){
            if(this.$props.maintenanceAddress) {
                this.$refs[sake.sake_id][0].href = `/maintenance/sake/${sake.sake_id}/${pageNo}`;
            } else {
                this.$refs[sake.sake_id][0].href = `/sake/${sake.sake_id}/${pageNo}`;
            }
            return;
        }
    }
}

</script>
