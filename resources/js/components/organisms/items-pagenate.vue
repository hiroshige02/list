<template>
    <div>
        <v-row dense>
            <v-col cols="12">
                <list-index
                :datas="lists"
                >
                </list-index>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols=12>
                <pagenation
                :total-pages="totalPages"
                :per-page="perPage"
                @clickedPage="clickedPage"
                ></pagenation>
            </v-col>
        </v-row>
    </div>
</template>


<script>

export default {
    props: ['datas','totalPages','perPage'],

    data() {
        return {
            lists: [],
        }
    },
    created(){
        let parsedData = JSON.parse(this.$props.datas);
        this.$data.lists = parsedData.slice(0,this.$props.perPage);
    },
    methods: {
        clickedPage(pageNumber){

            let parsedData = JSON.parse(this.$props.datas);
            let perPage = this.$props.perPage

            //表示開始の画像インデックス
            let startIndex = (pageNumber-1) * perPage
            //表示画像取得
            this.$data.lists = parsedData.slice(startIndex, pageNumber * perPage);
        }
    }
}

</script>
