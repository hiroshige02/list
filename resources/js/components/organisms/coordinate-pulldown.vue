<template>
    <div>
    <v-row justify="center" no-gutters>
        <v-col cols="6" sm="4">
            <pulldown
            :label="collectionLabel"
            :item-array="classes"
            :post-name="classPostName"
            eventName="coordinateChange"
            @coordinateChange="classChange"
            >
            </pulldown>
        </v-col>
        <v-col cols="6" sm="4">
            <pulldown
            :label="selectionLabel"
            :item-array="selections"
            :post-name="selectionPostName"
            eventName="selectionChange"
            @selectionChange="selectionChanged"
            :if-disabled="inactive"
            ></pulldown>
        </v-col>
    </v-row>
    <p v-show="searched" align="center">該当のお酒がありませんでした。</p>
    <search-result :datas="datas" :maintenance="isMaintenance" v-show="searchResult" ></search-result>
    </div>
</template>

<script>
  export default {
    props: ["items", "maintenance"],
    data(){
        return {
            classes: [],
            selections: [],
            collectionLabel: '',
            selectionLabel: '',
            classPostName: '',
            selectionPostName: '',
            selectedClass: '',
            datas: [],
            searchResult: false,
            inactive: true,
            searched: false,
            isMaintenance: this.$props.maintenance
        }
    },

    created(){
        this.$data.classes = this.$props.items['classes'];
        this.$data.selections = [];
        this.$data.collectionLabel = this.$props.items['label_1'],
        this.$data.selectionLabel = this.$props.items['label_2'];
        this.$data.classPostName = this.$props.items['name_1'];
        this.$data.selectionPostName = this.$props.items['name_2'];
    },
    watch: {
        datas: function(newValue, oldValue) {
            this.$data.searchResult = Object.keys(newValue).length > 0;
        },
    },
    methods: {
        classChange(selectedValue){
            this.$data.selectedClass = selectedValue;
            this.$data.selections = this.$props.items['selections'][selectedValue];

            if(selectedValue == undefined){
                this.$data.inactive = true;
                return;
            }

            this.$data.inactive = false;
        },
        selectionChanged(selectedValue){
            if(this.$data.selectedClass == ''){
                console.error('メーカーの評価の種類が選択されていません。');
                return;
            }

            let that = this;

            axios.post('/api/sake_search', {
                'class': that.$data.selectedClass,
                'search_text': selectedValue,
                'search_type': 2
            })
            .then(function(res) {
                that.$data.searched = false;
                // 該当データ無し
                if(Object.keys(res.data).length < 1) {
                    that.$data.searched = true;
                }
                //検索結果をリストに反映
                that.$data.datas = res.data;
            }).catch(function(error){
                console.log(error);
            });
        }
    },

  }
</script>
