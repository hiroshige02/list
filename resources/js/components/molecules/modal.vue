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
                        button-text="削除する"
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
            deleteFlag: false,
        }
    },
    created(){
        //ここでcreateフラグを使ってthis.$data.imageにパスをセットする？？
        // var parseFile = JSON.parse(this.$props.imgData);
        console.log('******* CHECK *******');
        console.log('this.$props.confirmFlag : ' + this.$props.confirmFlag);
        console.log('createFlag : ' + this.$props.createFlag);
        this.$data.imagePath = this.$props.path;
    },
    watch: {
        path: function(){
            this.$data.imagePath = this.$props.path;
        }
    },
    methods: {

        deleteImage: function() {
            this.$emit('close');
            this.$emit('deleteLink');

            if(this.$props.imageId != undefined && this.$props.imageId != ''){
                console.log('deleteImage deleteImage deleteImage');
                console.log(this.$props.imageId);
                // this.$data.deleteIds.push(this.$props.imageId);
                this.$data.deleteFlag = true;

                // console.log(this.$data.deleteIds);
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
  width:100%;
  height:100%;
  /* height: 100vh;
  width: 100vw; */
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
  height: 70%;
  object-fit: contain;
}
</style>
