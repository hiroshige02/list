<template>
    <div>
        <list-index
        :datas="lists"
        :current-page="currentPage"
        :maintenanceAddress="isMaintenance"
        >
        </list-index>

        <p v-if="noData" align="center">該当のお酒がありませんでした。</p>

        <v-row justify="center">
            <v-col cols=12>
                <pagenation
                :total-pages="totalPages"
                :per-page="perPage"
                @clickedPage="clickedPage"
                :current-page="currentPage"
                ></pagenation>
            </v-col>
        </v-row>
    </div>
</template>


<script>

export default {
    props: ['datas','totalPages','perPage','returnPage','maintenance'],

    data() {
        return {
            lists: [],
            currentPage: undefined,
            isMaintenance: this.$props.maintenance,
            noData: false
        }
    },
    created(){
        let parsedData = JSON.parse(this.$props.datas);

        if(parsedData.length === 0) {
            this.$data.noData = true;
            return;
        }

        this.$data.lists = parsedData.slice(0,this.$props.perPage);

        if(this.$props.returnPage != undefined){
            this.$data.currentPage = this.$props.returnPage;

            let parsedData = JSON.parse(this.$props.datas);
            let perPage = this.$props.perPage;

            //表示開始のインデックス
            let startIndex = (this.$data.currentPage-1) * perPage;
            //表示画像取得
            this.$data.lists = parsedData.slice(startIndex, this.$data.currentPage * perPage);
        }
    },
    methods: {
        clickedPage(pageNumber){
            this.$data.currentPage = pageNumber;
            let parsedData = JSON.parse(this.$props.datas);
            let perPage = this.$props.perPage;

            //表示開始の画像インデックス
            let startIndex = (pageNumber-1) * perPage;
            //表示画像取得
            this.$data.lists = parsedData.slice(startIndex, pageNumber * perPage);
        }
    }
}

</script>
