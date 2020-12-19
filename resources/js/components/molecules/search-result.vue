<template>
    <div style="text-align:center">
        <form action="/sake/search" method="post">
            <input type="hidden" name="_token" :value="csrf">
            <input v-if="maintenanceAddress" type="hidden" name="maintenance" :value='true'>
            <input name="searched[]" v-for="(item, index) in allIds" :key="index" style="display:none;" :value="item">

            <div>
                <ul>
                    <li v-for="(data, index) in resultDatas" :key="index">
                        <a v-if="maintenanceAddress" :href='`/maintenance/sake/${data.id}`'>{{ data.item }}</a>
                        <a v-else :href='`/sake/${data.id}`'>{{ data.item }}</a>
                    </li>
                </ul>
            </div>
            <v-col cols="12" align="center">
                <input type="submit" value="もっと見る">
            </v-col>
        </form>
    </div>
</template>

<script>
  export default {
    props: ["datas", "maintenance"],
    created: function(){
        this.$data.resultDatas = this.$props.datas;
    },
    data(){
        return {
            allIds: [],
            resultDatas: [],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            maintenanceAddress: this.$props.maintenance,
        }
    },
    watch: {
        datas: function(){
            this.$data.allIds = [];
            this.$data.resultDatas = [];
            this.$data.allIds = Object.keys(this.$props.datas);
            this.$data.resultDatas = Object.entries(this.$props.datas)
                                    .map(([id, item]) => ({id, item}))
                                    .slice(0,5);
        }
    },
  }
</script>
