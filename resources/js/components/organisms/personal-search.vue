<template>
    <div>
        <v-col v-for="(data, column) in datas" :key="column"
        cols=12
        class="d-flex no-gutters">
            <v-col cols=6>
                <span>{{ data.label }}</span>
            </v-col>
            <v-col cols=6>
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
        <search-result :datas="searchedDatas" :maintenance="isMaintenance" v-show="searchResult"></search-result>

        <!-- 「検索」ボタン -->
        <v-col cols=12 align="center">
            <div>
                <custom-button
                button-text="検索"
                button-color="primary"
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

            axios.post('/api/sake_search', {
                'search_text': this.$data.selected,
                'search_type': 3
            }).then(function(res) {
                console.log(res);
                console.log(res.data);
                that.$data.searchedDatas = res.data;
            }).catch(function(error) {
                console.error('個人の評価による検索に失敗しました');

            })

            return;
        }
    }
  }
</script>
