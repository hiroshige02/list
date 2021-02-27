<template>
    <div>
        <v-col v-for="(data, column) in datas" :key="column"
        cols=12
        class="d-flex no-gutters">
            <v-col cols="4">
                <span>{{ data.label }}</span>
            </v-col>
            <v-col cols="6">
                <pulldown
                :ref="column"
                :item-array="data.selections"
                :name="column"
                event-name="personalChange"
                @personalChange="selectChange"
                ></pulldown>
            </v-col>
        </v-col>

        <!-- 検索結果 -->
        <p v-show="searched" align="center">該当のお酒がありませんでした。</p>
        <search-result :datas="searchedDatas" :maintenance="isMaintenance" v-show="searchResult"></search-result>

        <!-- 「検索」ボタン -->
        <v-col cols=12 align="center">
            <div>
                <custom-button
                button-text="検索"
                button-color="pink"
                :is-large='true'
                font="large-button"
                event-name="personalSearch"
                @personalSearch="search"
                >
                </custom-button>
            </div>
        </v-col>

    </div>
</template>

<script>
  export default {
    props: ["personalData","maintenance"],
    created: function(){
        this.$data.datas = JSON.parse(this.$props.personalData);
    },
    data(){
        return {
            datas: [],
            selected: {},
            searchResult: false,
            searched: false,
            searchedDatas: [],
            isMaintenance: this.$props.maintenance
        }
    },
    watch: {
        searchedDatas: function(newValue, oldValue){
            this.$data.searchResult = Object.keys(newValue).length > 0;
        },
    },

    methods: {
        selectChange(value) {
            this.$data.selected[value.column] = value.value;
        },
        search() {

            let that = this;
            let columns = Object.keys(this.$data.selected);

            // 検索するかどうかのフラグ
            let doSearch = false;

            // 一つでも入力がされていたら検索実行
            columns.some(function(column) {
                if(column != 'undefined' && (that.$data.selected[column] !== "")) {
                    doSearch = true;
                    return true;
                }
            })

            if(!doSearch){
                this.$data.searchResult = false;
                return;
            }

            console.log('kensaku');

            axios.post('/api/sake_search', {
                'search_text': this.$data.selected,
                'search_type': 3
            }).then(function(res) {
                that.$data.searched = false;
                // 該当データ無し
                if(Object.keys(res.data).length < 1) {
                    that.$data.searched = true;
                }
                that.$data.searchedDatas = res.data;
            }).catch(function(error) {
                console.error('個人の評価による検索に失敗しました');
            })

            return;
        }
    }
  }
</script>
