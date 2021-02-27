<template>
    <div align="center">

        <v-row justify="center" d-flex no-gutters>
            <v-col cols="9" sm="8">
                <v-text-field
                label="酒名"
                outlined
                append-icon="mdi-magnify"
                :is-error="isError"
                :error-messages="errorMessages"
                name="name"
                v-model="value"
                background-color="white"
                :color="labelColor">
                </v-text-field>
            </v-col>
            <div style='float:left' v-on:click="search()">
                <button-event
                button-text="検索"
                button-color="pink"
                is-normal='false'
                :is-large='true'
                :height=56
                font="large-button"
                >
                </button-event>
            </div>
        </v-row>

        <!-- 検索結果 -->
        <p v-show="searched" align="center">該当のお酒がありませんでした。</p>
        <search-result :datas="datas" :maintenance="isMaintenance" v-show="searchResult"></search-result>

    </div>
</template>

<script>
  export default {
    props: ["file","userId","searchText",'isError',
    'errorMessages',"maintenance","labelColor"],
    data(){
        return {
            value: this.$props.searchText,
            datas: [],
            searched: false,
            searchResult: false,
            isMaintenance: this.$props.maintenance
        }
    },
    created: function() {
        // console.log('isMaintenance');
        // console.log(this.$props.maintenance);
    },
    methods: {
        search(){

            console.log('this.$data.value :' + this.$data.value);
            if(this.$data.value == ''){
                this.$data.searchResult = [];
                this.$data.searchResult = false;
                return;
            }

            let that = this;
            axios.post('/api/sake_search', {
                'search_text': this.$data.value,
                'search_type': 1
            },)
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
                return;
            });
        },
    }, watch: {
        datas: function(newValue, oldValue){
            this.$data.searchResult = Object.keys(newValue).length > 0;
        }
    }
  }
  </script>
