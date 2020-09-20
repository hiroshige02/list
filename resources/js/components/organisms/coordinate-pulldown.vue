<template>

    <!-- 関数名を変数で表示できないか -->
    <v-col cols="12" class="d-flex no-gutters">
        <v-col cols=6>
            <pulldown
            :label="collectionLabel"
            :item-array="classes"
            :post-name="classPostName"
            eventName="baka"
            @baka="changeSelection"
            >

            </pulldown>

        </v-col>
        <v-col cols=6>
            <pulldown
            :label="selectionLabel"
            :item-array="selections"
            :post-name="selectionPostName"
            ></pulldown>
        </v-col>
    </v-col>

</template>

<script>
  export default {
    props: ["items"],
    data(){
        //ここの初期化が効いていないのでは。
        return {
            classes: '',
            selected: '',
            selections: '',
            collectionLabel: '',
            selectionLabel: '',
            classPostName: '',
            selectionPostName: '',
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
        selected: function(){
            if(this.$data.selected !== ''){
                console.log('CHANGED!!!');
                this.$data.selections =  this.$props.items['selections'][this.selected];
            }

        }
    },
    methods: {
        changeSelection(selectedValue){
            console.log('egumieegm');
            console.log(selectedValue);
            console.log(JSON.stringify(this.$data.items));
            this.$data.selections = this.$props.items['selections'][selectedValue];
        }
    }

  }
</script>
