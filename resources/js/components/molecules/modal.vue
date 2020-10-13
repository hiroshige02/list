<template>
    <div id="overlay" @click.self="cancelClick">
        <div id="modal-content">
            <img :src="image">
            <v-row>
                <v-col cols=12 class="d-flex">
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

            </v-row>

        </div>
    </div>
</template>

<script>
  export default {
    props: ['imgName','userId'],
    data(){
        return {
            image: `/storage/app/public/img/tmp/${this.$props.userId}/${this.$props.imgName}`,
            user_id: this.$props.userId
        }
    },
    created(){
        console.log('modal.imgName : ' + this.$props.imgName);
    },

    methods: {

        deleteImage: function() {
            axios.post('/api/tentativeimage/delete', {
                'image_source': this.$data.image,
                'user_id': this.$data.user_id
            },)
            .then(function(res) {
                console.log('@@@@@@@@ post tentativeDelete @@@@@@@@');
                // this.cancelClick();
            }).catch(function(error){
                console.log(error);
                return;
            });

            this.$emit('close');
            this.$emit('deleteLink');

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
