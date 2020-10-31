<template>
    <div id="overlay" @click.self="cancelClick">
        <div id="modal-content">
            <img :src="imagePath">
            <v-row>

                <v-col v-if="confirmFlag" cols=12 align="center">
                    <v-col cols=6 @click="cancelClick">
                        <!-- キャンセルボタン -->
                        <button-event
                        button-text='キャンセル'
                        button-color="pink"
                        :is-normal='true'
                        height="56px"
                        width="150spx"
                        font="normal-button"
                        >
                        </button-event>
                    </v-col>
                </v-col>

                <v-col v-else cols=12 class="d-flex">
                    <v-col cols=6 @click="deleteImage">
                        <!-- 削除ボタン -->
                        <button-event
                        button-text='削除する'
                        button-color="pink"
                        :is-normal='true'
                        height="56px"
                        width="150px"
                        font="normal-button"
                        >
                        </button-event>
                    </v-col>
                    <v-col cols=6 @click="cancelClick">
                        <!-- キャンセルボタン -->
                        <button-event
                        button-text='キャンセル'
                        button-color="pink"
                        :is-normal='true'
                        height="56px"
                        width="150spx"
                        font="normal-button"
                        >
                        </button-event>
                    </v-col>
                </v-col>


                <!-- ！！！！削除サインがつけられるのはこのコンポーネント内のidのみ！！！！ -->
                <!-- ！！！！削除サインがつけられるのはこのコンポーネント内のidのみ！！！！ -->
                <div v-for="id in deleteIds" :key="id">
                    <input type="hidden" name="delete_image_ids[]" :value="id">
                </div>
            </v-row>

        </div>
    </div>
</template>

<script>
  export default {
    props: ['path','userId','createFlag','confirmFlag','imageId'],
    data(){
        return {
            imagePath: '',
            deleteIds: [],

        }
    },
    created(){
        //ここでcreateフラグを使ってthis.$data.imageにパスをセットする？？
        // var parseFile = JSON.parse(this.$props.imgData);
        console.log('******* CHECK *******');
        console.log('this.$props.confirmFlag : ' + this.$props.confirmFlag);
        console.log('createFlag : ' + this.$props.createFlag);
        // console.log('deleteImageIds : ' + this.$props.deleteImageIds);

        // if(this.$props.createFlag != undefined){
        //     console.log('******* CREATE VERSION *******');
        //     this.$data.imagePath = `/storage/app/public/img/tmp/${this.$props.userId}/${this.$props.path}`;
        //     console.log('MODAL::this.$data.imagePath : ' + this.$data.imagePath);

        //     return;
        // }
        this.$data.imagePath = this.$props.path;
    },

    methods: {

        deleteImage: function() {
            this.$emit('close');
            this.$emit('deleteLink');

            if(this.$props.imageId != undefined && this.$props.imageId != ''){
                console.log('deleteImage deleteImage deleteImage');
                console.log(this.$data.deleteIds);
                console.log(this.$props.imageId);
                this.$data.deleteIds.push(this.$props.imageId);

                console.log(this.$data.deleteIds);
                return;
            }

            axios.post('/api/tentative_image/delete', {
                'image_source': this.$props.path,
                'delete_picture_id': this.$props.imageId,
                'user_id': this.$props.userId,
                'create_flag': this.$props.createFlag
            },)
            .then(function(res) {
                console.log('@@@@@@@@ post tentativeDelete @@@@@@@@');
                this.cancelClick();
            }).catch(function(error){
                console.log(error);
                return;
            });

        },
        cancelClick: function(){
            this.$emit('close');
        }

    }
  }
</script>

<style>
  #overlay{
  z-index:1;
  position:fixed;
  top:0;
  left:0;
  width:100%;   /* ひとまずbody-containerが400pxの時に合わせて作っている　*/
  height:100%;
  /* transform: translate(calc(50vw - 50%),calc(50vh - 50%)); ダメだった */

  border-radius: 8px;
  background-color:rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

#modal-content{
  z-index:2;
  width:50%;
  padding-top: 5em;
  padding-bottom: 5em;
  text-align: center;
}

#modal-content > img {
  width: 95%;
}
</style>
